<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <title>LDAP Entry Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
<div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-download"></i> Download LDIF File</h2>
        <div class="row">
            <div class="col">
                <a href="ldif.php" class="btn btn-primary"><i class="fas fa-file-download"></i> Download LDIF</a>
            </div>
        </div>
    </div>
    <div class="container mt-5">  
    <?php
        // Display success message if set
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">';
            echo $_SESSION['success_message'];
            echo '</div>';
            unset($_SESSION['success_message']); // Clear the session variable
        }
        
        // Display error message if set
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION['error_message'];
            echo '</div>';
            unset($_SESSION['error_message']); // Clear the session variable
        }
        ?>
        <h2>LDAP Entry Form</h2>
        <form method="post" action="process_form.php">
            <div class="row mb-3">
                <label for="cn" class="col-sm-3 col-form-label">
                    <i class="fas fa-user"></i> Common Name (CN):
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="cn" name="cn" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="sn" class="col-sm-3 col-form-label">
                    <i class="fas fa-user"></i> Surname (SN):
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="sn" name="sn" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="givenName" class="col-sm-3 col-form-label">
                    <i class="fas fa-user"></i> Given Name:
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="givenName" name="givenName" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="mail" class="col-sm-3 col-form-label">
                    <i class="fas fa-envelope"></i> Email:
                </label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="mail" name="mail" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="mobile" class="col-sm-3 col-form-label">
                    <i class="fas fa-mobile-alt"></i> Mobile:
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="mobile" name="mobile" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="ou" class="col-sm-3 col-form-label">
                    <i class="fas fa-sitemap"></i> Organizational Unit (OU):
                </label>
                <div class="col-sm-9">
                    <select id="ou" name="ou" class="form-select ">
                        <option value="Infromation Technology">Information Technology</option>
                        <option value="Accounts">Accounts</option>
                        <option value="Human Resource">Human Resource</option>
                        <option value="Construction">Construction</option>
                        <option value="Branch">Branch</option>
                        <option value="projects">Project Site</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-9 offset-sm-3">
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-5"> 
    <h2>Import LDAP Entries from CSV</h2>
<form method="post" action="import_csv.php" enctype="multipart/form-data">
    <div class="row mb-3">
        <label for="csv_file" class="col-sm-3 col-form-label">Upload CSV File:</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-9 offset-sm-3">
            <input type="submit" value="Import CSV" class="btn btn-primary">
        </div>
    </div>
</form>
<div class="row mb-3">
            <div class="col-sm-9 offset-sm-3">
                <a href="sample_template.csv" download class="btn btn-secondary">Download Sample CSV Template</a>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
