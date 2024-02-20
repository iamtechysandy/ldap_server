<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    // Check if the file is a CSV file
    $file_type = $_FILES["csv_file"]["type"];
    if ($file_type != "text/csv" && $file_type != "application/vnd.ms-excel") {
        $_SESSION['error_message'] = "Error: Please upload a CSV file.";
        header("Location: index.php");
        exit();
    }

    // Check if there was an error uploading the file
    if ($_FILES["csv_file"]["error"] > 0) {
        $_SESSION['error_message'] = "Error: " . $_FILES["csv_file"]["error"];
        header("Location: index.php");
        exit();
    }

    // Read the CSV file
    $csv_file = $_FILES["csv_file"]["tmp_name"];
    $file_handle = fopen($csv_file, "r");

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ldap";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement for insertion
    $sql = "INSERT INTO ldap_entries (dn, cn, sn, givenName, mail, mobile, ou) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssssss", $dn, $cn, $sn, $givenName, $mail, $mobile, $ou);

    // Loop through each row in the CSV file and insert into database
    while (($row = fgetcsv($file_handle, 1000, ",")) !== FALSE) {
        // Map CSV columns to LDAP attributes
        list($cn, $sn, $givenName, $mail, $mobile, $ou) = $row;

        // Generate DN
        $dn = "cn=$cn,ou=$ou,dc=example,dc=com";

        // Execute SQL statement
        if (!$stmt->execute()) {
            $_SESSION['error_message'] = "Error: Failed to import LDAP entry.";
            header("Location: index.php");
            exit();
        }
    }

    // Close file handle
    fclose($file_handle);

    // Close statement and connection
    $stmt->close();
    $conn->close();

    $_SESSION['success_message'] = "LDAP entries imported successfully.";
    header("Location: index.php");
    exit();
} else {
    $_SESSION['error_message'] = "Error: Please upload a CSV file.";
    header("Location: index.php");
    exit();
}
?>
