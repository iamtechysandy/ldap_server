<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $givenName = $_POST['givenName'];
    $mail = $_POST['mail'];
    $mobile = $_POST['mobile'];
    $ou = $_POST['ou'];
    
    // Generate DN
    $dn = "cn=$cn,ou=$ou,dc=example,dc=com";
    
    // Create LDIF template
    $ldif = "dn: $dn\n";
    $ldif .= "objectClass: inetOrgPerson\n";
    $ldif .= "objectClass: organizationalPerson\n";
    $ldif .= "objectClass: person\n";
    $ldif .= "objectClass: top\n";
    $ldif .= "cn: $cn\n";
    $ldif .= "sn: $sn\n";
    $ldif .= "givenName: $givenName\n";
    $ldif .= "mail: $mail\n";
    $ldif .= "mobile: $mobile\n";
    $ldif .= "ou: $ou\n";
    
    // Generate filename
    $filename = "cn" . date("Ymd") . ".ldif";
    
    // Save to file
    if (file_put_contents($filename, $ldif)) {
        $_SESSION['success_message'] = "LDAP entry saved successfully.";
    } else {
        $_SESSION['error_message'] = "Error: Failed to save LDAP entry.";
    }

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "Yourpassword";
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
    $stmt->bind_param("sssssss", $dn, $cn, $sn, $givenName, $mail, $mobile, $ou);
    
    // Execute SQL statement
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "LDAP entry inserted into MySQL database successfully.";
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close connection
    $stmt->close();
    $conn->close();
    
    // Redirect back to index.php
    header("Location: index.php");
    exit();
} else {
    $_SESSION['error_message'] = "Form submission error!";
    // Redirect back to index.php
    header("Location: index.php");
    exit();
}
?>
