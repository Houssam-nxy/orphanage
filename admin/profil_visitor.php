<?php

session_start();
include('conn.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login");
    exit;
} else if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') { // Check user role
  header("Location: ../unauthorized");
  exit;
}



if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Query the database for the beneficiary based on their ID
  $beneficiary_query = "SELECT * FROM visites WHERE id = $id";
  $result = mysqli_query($conn, $beneficiary_query);
  
  if (mysqli_num_rows($result) > 0) {
    // Fetch the beneficiary details
    $row = mysqli_fetch_assoc($result); // Fetch the row
    
    $beneficiaire = $row['beneficiaire'];
    $visiteur = $row['visiteur'];
    $cin_visiteur = $row['cin_visiteur'];
    $type_visiteur = $row['type_visiteur'];
    $lieu = $row['lieu'];
    $date_heure = $row['date_heure'];
    $description = $row['description'];


  } else {
    echo "<script>alert('visiteur introuvable.');</script>";
    exit();
  }
} else {
  echo "<script>alert('ID de visiteur non spécifié.');</script>";
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
  $deleteQuery = "DELETE FROM visites WHERE id = $id";
  $deleteResult = mysqli_query($conn, $deleteQuery);

  if ($deleteResult) {
      // Deletion successful, redirect to a page or display a success message
      header("Location: list_visitor"); // Redirect to the desired page
      exit();
  } else {
      // Deletion failed, display an error message
      $error_message = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <i class="bi bi-exclamation-octagon me-1"></i>
                                      Échec de la suppression.
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
  }
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
  <link href="assets/img/logo1.png" rel="icon">
  <link href="assets/img/logo1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
                             
</head>

<body>


<style>
  label{
    font-weight: bold;
  }     
</style>

  <?php include 'navbar.php'; ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Visites</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Visites</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">

    <?php if (isset($success_message)): ?>
      <?php echo $success_message; ?>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
      <?php echo $error_message; ?>
    <?php endif; ?>

      <div class="row">
        <div class="col-lg-12">





        <div class="card">
        <div class="card-body">
          <h5 class="card-title">Données personnelles</h5>

          <!-- General Form Elements -->
          <form action="" method="post" enctype="multipart/form-data">

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Bénéficiaire</label>
              <div class="col-sm-8">
                <p><?php echo $beneficiaire; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Visiteur</label>
              <div class="col-sm-8">
                <p><?php echo $visiteur; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">CIN Visiteur</label>
              <div class="col-sm-8">
                <p><?php echo $cin_visiteur; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">type de visiteur</label>
              <div class="col-sm-8">
                <p><?php echo $type_visiteur; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Lieu</label>
              <div class="col-sm-8">
                <p><?php echo $lieu; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Date et l'heure</label>
              <div class="col-sm-8">
                <p><?php echo $date_heure; ?></p>
              </div>
            </div>


            <div class="row mb-3">
              <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <p><a href="#" data-bs-toggle="modal" data-bs-target="#verticalycentered" style="text-decoration: none;color: Black;"><i>Cliquez pour voir la description</i></a></p>

                <div class="modal fade" id="verticalycentered" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Description</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <?php echo $description; ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                      </div>
                    </div>
                  </div>
                </div><!-- End Vertically centered Modal-->

              </div>
            </div>


            <div class="row mb-3">
              <div class="col-sm-12">
                <br>
              <input data-bs-toggle="modal" data-bs-target="#remove" value="Supprimer" type="submit" name="delete" class="btn" style="color: red;border: 1px solid red; border-radius: 3px;">
              </div>
            </div>


            
        </div>
      </div>
        

      </div>
    </section>      

  </main><!-- End #main -->

  
  <?php include 'footer.php'; ?>

</body>

</html>