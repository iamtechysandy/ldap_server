<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "yourpassword";
$dbname = "ldap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get LDAP entry ID from URL parameter
if (isset($_GET['id'])) {
    $entry_id = $_GET['id'];
    
    // Fetch LDAP entry from database by ID
    $sql = "SELECT * FROM ldap_entries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $entry_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If LDAP entry found, generate LDIF file and initiate download
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Generate LDIF content
        $ldif = "dn: " . $row["dn"] . "\n";
        $ldif .= "objectClass: inetOrgPerson\n";
        $ldif .= "objectClass: organizationalPerson\n";
        $ldif .= "objectClass: person\n";
        $ldif .= "objectClass: top\n";
        $ldif .= "cn: " . $row["cn"] . "\n";
        $ldif .= "sn: " . $row["sn"] . "\n";
        $ldif .= "givenName: " . $row["givenName"] . "\n";
        $ldif .= "mail: " . $row["mail"] . "\n";
        $ldif .= "mobile: " . $row["mobile"] . "\n";
        $ldif .= "ou: " . $row["ou"] . "\n";
        
        // Set headers for LDIF file download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="ldap_entry.ldif"');
        
        // Output LDIF content
        echo $ldif;
    } else {
        echo "LDAP entry not found.";
    }
    
    // Close statement
    $stmt->close();
} else {
    echo "LDAP entry ID not provided.";
}

// Close connection
$conn->close();
?>
