<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is already logged in, redirect to the urgent.php page
    header('Location: data');
    exit;
}


// Check if the login form is submitted
if (isset($_POST['submit_login'])) {
    $passcode = $_POST['passcode']; // Get the passcode entered by the user

    // Verify the passcode
    $hashedPasscode = '$2y$10$hJk7.438FMtZzSaXvklkrunNzxscAZfKjvwRebbqAJVeBBUAVOJhe'; // Replace with the hashed passcode

    if (password_verify($passcode, $hashedPasscode)) {
        // Passcode is correct, set session variables and redirect to the urgent.php page
        $_SESSION['loggedin'] = true;
        header('Location: data');
        exit;
    } else {
      $error = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <i class="bi bi-exclamation-octagon me-1"></i>
                        Code d accès invalide. Veuillez réessayer.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
}

// Generate a hashed passcode
$passcode = 'Houssam_nxy'; // Replace with your desired passcode
$hashedPasscode = password_hash($passcode, PASSWORD_DEFAULT);
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

  <?php include 'navbar.php'; ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Urgent</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Urgent</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">

      <?php if (isset($error)) { ?>
        <?php echo $error; ?>
      <?php } ?>

      <div class="row">
        <div class="col-lg-12">





        <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class='bx bx-info-circle'></i> Avertissement</h5>
              <p>Veuillez ne pas essayer d'ouvrir cette section car elle contient des informations sensibles. Une seule personne autorisée peut y accéder pour assurer sa sécurité, et uniquement en cas d'urgence.</p>

              <!-- Browser Default Validation -->
              <form method="POST" action="" class="row g-3">

                <div class="col-md-12">
                  <label for="validationDefault01" class="form-label">Nom complet</label>
                  <input type="text" class="form-control" id="validationDefault01" placeholder="Votre nom complet est défini par défaut" value="" disabled required>
                </div>
                <div class="col-md-12">
                  <label for="validationDefault05" class="form-label">Mot de passe</label>
                  <input name="passcode" type="password" class="form-control" id="validationDefault05" required>
                </div>
                <div class="col-12">
                  <input class="btn btn-primary" type="submit" name="submit_login" value="Démarrer">
                </div>

              </form>

              
            </div>
          </div>
        
          

        

        </div>
      </div>
    </section>      

  </main><!-- End #main -->

  
  <?php include 'footer.php'; ?>

</body>

</html>