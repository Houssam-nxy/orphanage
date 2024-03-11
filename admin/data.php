<?php

session_start();


// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: urgent.php');
  exit;
}



// Database connection details
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'profil_utilisateur';

// Create a database connection
$connection = mysqli_connect($host, $username, $password, $database);

if ($connection) {
    if (isset($_POST['delete'])) {
        // Perform the delete operation
        $deleteQuery = "DELETE FROM profil";
        $deleteResult = mysqli_query($connection, $deleteQuery);

        // Table 1
        $deleteQuery1 = "DELETE FROM messages";
        $deleteResult1 = mysqli_query($connection, $deleteQuery1);

        // Table 1
        $deleteQuery2 = "DELETE FROM visites";
        $deleteResult2 = mysqli_query($connection, $deleteQuery2);

        // Table 1
        $deleteQuery3 = "DELETE FROM archives";
        $deleteResult3 = mysqli_query($connection, $deleteQuery3);


        if ($deleteResult && $deleteResult1 ) {
            $success_message = ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                      Les données ont été supprimées avec succès.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
        } else {
            $error_message_sp = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-octagon me-1"></i>
                                      Échec de la suppression des données.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
        }
    }

    if (isset($_POST['download_sql'])) {
        // Perform the SQL download
        $filename = 'data.sql';

        // Get the table structure
        $tableStructureQuery = "SHOW CREATE TABLE profil";
        $tableStructureResult = mysqli_query($connection, $tableStructureQuery);

        if ($tableStructureResult && mysqli_num_rows($tableStructureResult) > 0) {
            $tableStructureRow = mysqli_fetch_row($tableStructureResult);
            $tableStructure = $tableStructureRow[1];

            // Get the table data
            $tableDataQuery = "SELECT * FROM profil";
            $tableDataResult = mysqli_query($connection, $tableDataQuery);

            if ($tableDataResult && mysqli_num_rows($tableDataResult) > 0) {
                // Create the SQL file and write the table structure
                $sqlFile = fopen($filename, 'w');
                fwrite($sqlFile, $tableStructure . ";\n\n");

                // Write the data rows
                while ($row = mysqli_fetch_assoc($tableDataResult)) {
                    $values = implode("','", $row);
                    $insertQuery = "INSERT INTO profil VALUES ('$values');";
                    fwrite($sqlFile, $insertQuery . "\n");
                }

                // Close the SQL file handle
                fclose($sqlFile);

                // Provide the file download to the user
                $filesize = filesize($filename);

                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Content-Length: ' . $filesize);

                readfile($filename);
            } else {
                $warning_message = ' <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                          Aucune donnée trouvée.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>';

            }

            // Free the result set
            mysqli_free_result($tableDataResult);
        } else {
            $error_message_tb = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-octagon me-1"></i>
                                    Échec de l’obtention de la structure de la table.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
        }

        // Free the result set
        mysqli_free_result($tableStructureResult);
    }


    // Close the database connection
    mysqli_close($connection);
} else {
    $error_message_db = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-octagon me-1"></i>
                                      Échec de la connexion à la base de données.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nom de société</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logo1.png" rel="icon">
  <link href="../assets/img/logo1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
                             
</head>

<body>

  <?php include 'navbar.php'; ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Urgent</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
          <li class="breadcrumb-item active">Urgent</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">

        <?php if (isset($success_message)): ?>
            <?php echo $success_message; ?>
        <?php endif; ?>

        <?php if (isset($error_message_sp)): ?>
            <?php echo $error_message_sp; ?>
        <?php endif; ?>

        <?php if (isset($error_message_sp)): ?>
            <?php echo $error_message_sp; ?>
        <?php endif; ?>

        <?php if (isset($error_message_tb)): ?>
            <?php echo $error_message_tb; ?>
        <?php endif; ?>

        <?php if (isset($error_message_db)): ?>
            <?php echo $error_message_db; ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">

            <form action="" method="post">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Gestion des données</h5>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Puis-je uniquement télécharger les données sans les supprimer ?</h4>
                    <p>Oui, vous avez la possibilité de télécharger les données au format SQL sans les supprimer. Il vous suffit de cliquer sur les boutons respectifs (Télécharger SQL) pour lancer le téléchargement.</p>
                    <hr>
                    <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p><br>
                    <input type="submit" class="btn btn-success" name="download_sql" value="Télécharger SQL">
                </div>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Comment puis-je supprimer les données ?</h4>
                    <p>Pour supprimer les données, cliquez sur le bouton "Supprimer les Données". Cela supprime toutes les données de la base de données.</p>
                    <hr>
                    <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p><br>
                    <input type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered" value="Supprimer les Données" />
                </div>

                <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-danger">La dernière étape</h5>
                      <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Êtes-vous certain, Mr/Mme? Une fois que vous aurez supprimé toutes vos données, il n'y aura pas de retour en arrière possible.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                      <input type="submit" class="btn btn-danger" name="delete" value="Supprimer les Données">
                    </div>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->




                </div>
            </div>
            </form>


            </div>
        </div>
    </section>      

  </main><!-- End #main -->

  
  <?php include 'footer.php'; ?>

</body>

</html>