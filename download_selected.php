<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selected']) && is_array($_POST['selected']) && !empty($_POST['selected'])) {
        // Prepare LDIF content
        $ldif_content = '';
        foreach ($_POST['selected'] as $entry_id) {
            // Fetch LDAP entry from database by ID
            $sql = "SELECT * FROM ldap_entries WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $entry_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Append LDIF entry to content
                $ldif_content .= "dn: " . $row["dn"] . "\n";
                $ldif_content .= "objectClass: inetOrgPerson\n";
                $ldif_content .= "objectClass: organizationalPerson\n";
                $ldif_content .= "objectClass: person\n";
                $ldif_content .= "objectClass: top\n";
                $ldif_content .= "cn: " . $row["cn"] . "\n";
                $ldif_content .= "sn: " . $row["sn"] . "\n";
                $ldif_content .= "givenName: " . $row["givenName"] . "\n";
                $ldif_content .= "mail: " . $row["mail"] . "\n";
                $ldif_content .= "mobile: " . $row["mobile"] . "\n";
                $ldif_content .= "ou: " . $row["ou"] . "\n\n";
            }
        }
        
        // Set headers for LDIF file download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="selected_entries.ldif"');
        
        // Output LDIF content
        echo $ldif_content;
    } else {
        echo "No LDAP entries selected.";
    }
}

// Close connection
$conn->close();
?>
