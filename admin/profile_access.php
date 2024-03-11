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
    $uid = $_GET['id'];
  
    // Query the database for the beneficiary based on their ID
    $beneficiary_query = "SELECT * FROM users WHERE uid = $uid";
    $result = mysqli_query($conn, $beneficiary_query);
    
    if (mysqli_num_rows($result) > 0) {
      // Fetch the beneficiary details
      $row = mysqli_fetch_assoc($result);
      
      $name = $row['name'];
      $type = $row['user_type'];
      $mail = $row['email'];
      $phone = $row['mobile'];
      $photo = $row['profile_image_users'];
  
      // Note: $description is not defined in your code
    } else {
      echo "<script>alert('Visiteur introuvable.');</script>";
      exit();
    }
  } else {
    echo "<script>alert('ID de visiteur non spécifié.');</script>";
    exit();
  }

  
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteQuery = "DELETE FROM users WHERE uid = $uid";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Deletion successful, redirect to a page or display a success message
        header("Location: users"); // Redirect to the desired page
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

// reset password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetPassword"])) {
    $newPassword = generateRandomPassword(); 
  
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  
    $updatePasswordQuery = "UPDATE users SET password = '$hashedPassword' WHERE uid = $uid";
    $updateResult = mysqli_query($conn, $updatePasswordQuery);
  
    if ($updateResult) {
        $success_message = ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Mot de passe réinitialisé avec succès. Nouveau mot de passe : '.$newPassword.'
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
    } else {
      $error_message = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-octagon me-1"></i>
                                        Échec de la réinitialisation du mot de passe.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
    }
  }
  
  // Function to generate a random password
  function generateRandomPassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
      $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
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
      <h1>Utilisateurs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Compte</li>
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
              <label for="inputText" class="col-sm-4 col-form-label">ID</label>
              <div class="col-sm-8">
                <p><?php echo $uid; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Nom d'utilisateur</label>
              <div class="col-sm-8">
                <p><?php echo $name; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Courriel</label>
              <div class="col-sm-8">
                <p><?php echo $mail; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Numéro de téléphone</label>
              <div class="col-sm-8">
                <p><?php echo $phone; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Type d'utilisateur</label>
              <div class="col-sm-8">
                <p><?php echo $type; ?></p>
              </div>
            </div>



            <div class="row mb-3">
              <label for="inputimg" class="col-sm-4 col-form-label">Image de l'utilisateur</label>
              <div class="col-sm-8">
                <p><a href="#" data-bs-toggle="modal" data-bs-target="#verticalycentered" style="text-decoration: none;color: Black;"><i>Cliquez pour voir l'image</i></a></p>

                <div class="modal fade" id="verticalycentered" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="body_profile_img" style="text-align: center;">
                            <img src="<?php echo empty($photo) ? '../up/user.png' : $photo; ?>" alt="profile" width="200" style="border-radius: 3px;">
                        </div> 
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                      </div>
                    </div>
                  </div>
                </div><!-- End Vertically centered Modal-->

              </div>
            </div>

            <br>
            <hr>
            <br>


            <div class="row mb-3" style="width: 100%;text-align: center;">
              <label for="delet" class="col-sm-12 col-form-label">
                <input data-bs-toggle="modal" data-bs-target="#remove" value="Supprimer" class="btn" style="color: red;border: 1px solid red; border-radius: 3px;">
                <input type="submit" name="resetPassword" value="Passe par défaut" class="btn" style="color: green;border: 1px solid green; border-radius: 3px;">
                
              </label>
                <div class="col-sm-8">

                    <div class="modal fade" id="remove" tabindex="1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">La dernière étape</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr, Mr/Mme? Une fois que vous avez supprimé ce compte, vous ne pouvez plus revenir en arrière.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
                        </div>
                        </div>
                    </div>
                    </div><!-- End Vertically centered Modal-->

                </div>

            

            </div>

            


            
        </div>
      </div>
        

      </div>
    </section>      

  </main>

  
  <?php include 'footer.php'; ?>

</body>

</html>