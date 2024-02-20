<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LDAP Entries</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-backward"></i> Import/Add Data</h2>
        <div class="row">
            <div class="col">
                <a href="index.php" class="btn btn-primary"><i class="fas fa-home"></i> Import/Add Data</a>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <h2 class="mb-4">Download LDAP Entries</h2>
        <form class="mb-4" action="" method="post">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <?php
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

        // Fetch LDAP entries from the database based on search query
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $sql = "SELECT * FROM ldap_entries WHERE cn LIKE '%$search%' OR mail LIKE '%$search%' OR mobile LIKE '%$search%'";
        $result = $conn->query($sql);

        // Display LDAP entries
        if ($result->num_rows > 0) {
            echo '<form action="download_selected.php" method="post">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr><th><input type="checkbox" id="select-all"></th><th>DN</th><th>Common Name (CN)</th><th>Surname (SN)</th><th>Given Name</th><th>Email</th><th>Mobile</th><th>Organizational Unit (OU)</th><th>Download LDIF</th></tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><input type="checkbox" name="selected[]" value="' . $row["id"] . '"></td>';
                echo '<td>' . $row["dn"] . '</td>';
                echo '<td>' . $row["cn"] . '</td>';
                echo '<td>' . $row["sn"] . '</td>';
                echo '<td>' . $row["givenName"] . '</td>';
                echo '<td>' . $row["mail"] . '</td>';
                echo '<td>' . $row["mobile"] . '</td>';
                echo '<td>' . $row["ou"] . '</td>';
                echo '<td><a href="download_ldif.php?id=' . $row["id"] . '">Download</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '<button type="submit" class="btn btn-primary">Download Selected</button>';
            echo '</form>';
        } else {
            echo "<p>No LDAP entries found.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <script>
        // JavaScript to toggle the selection of all checkboxes
        document.getElementById('select-all').addEventListener('click', function () {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = !checkbox.checked;
            });
        });
    </script>
</body>

</html>
