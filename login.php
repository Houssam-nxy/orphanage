<?php
session_start();

require_once "admin/conn.php";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <i class="bi bi-exclamation-octagon me-1"></i>
                          Veuillez entrer un identifiant de courrier électronique valide
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
    }

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email . "'");

    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['uid'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_mobile'] = $row['mobile'];
                $_SESSION['user_password'] = $password;
                $_SESSION['user_type'] = $row['user_type']; 

                if ($row['user_type'] === 'admin') {
                    header("Location: admin/index");
                    exit;
                } else if ($row['user_type'] === 'standard') {
                    header("Location: standard/index");
                    exit;
                } else {
                    $error_message1 = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <i class="bi bi-exclamation-octagon me-1"></i>
                                  Nous ne savons pas votre type de compte utilisateur !!!
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                }
            } else {
                $error_message1 = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <i class="bi bi-exclamation-octagon me-1"></i>
                                  Email ou mot de passe incorrect!!!
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
            }
        } else {
            $error_message2 = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                Email ou mot de passe incorrect!!!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
        }
    } else {
        // database error 
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nom de société / Login</title>
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

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo1.png" alt="LOGO">
                  <span class="d-none d-lg-block">Nom de société</span>
                </a>
              </div><!-- End Logo -->

              
              <div class="card mb-3">

                <div class="card-body">

                <br>
                <?php if (isset($email_error)): ?>
                  <?php echo $email_error; ?>
                <?php endif; ?>

                <?php if (isset($password_error)): ?>
                  <?php echo $password_error; ?>
                <?php endif; ?>

                <?php if (isset($error_message1)): ?>
                  <?php echo $error_message1; ?>
                <?php endif; ?>

                <?php if (isset($error_message2)): ?>
                  <?php echo $error_message2; ?>
                <?php endif; ?>

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Identifiez-vous</h5>
                    <p class="text-center small">Entrez votre nom et votre mot de passe</p>
                  </div>

                  <form class="row g-3 needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="col-12">
                    <label for="yourUsername" class="form-label">Nom d'utilisateur</label>
                      <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Votre nom d'utilisateur" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="password" name="password" class="form-control" id="yourPassword" placeholder="*****" required>
                      <div class="invalid-feedback">Veuillez saisir votre mot de passe !</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <input class="btn btn-primary w-100" type="submit" name="login" value="Login">
                    </div>
                    <div class="col-12">
                        <p class="text-center small"><a href="reset-password"> Mot de passe oublié ? </a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Conçu par <a href="https://github.com/Houssam-nxy">Houssam_nxy</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

 


</body>

</html>