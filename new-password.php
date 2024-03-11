<?php
session_start();

require_once "admin/conn.php";



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["newlogin"])) {
    // Validate password and confirmation
    $newPassword = trim($_POST["newpassword"]);
    $confirmPassword = trim($_POST["con_password"]);

    // Add any additional validation checks if needed

    // Check if passwords match
    if ($newPassword != $confirmPassword) {
        $password_error = "Les mots de passe ne correspondent pas.";
    } else {
        // Retrieve token from the query parameters
        $token = isset($_POST['token']) ? $_POST['token'] : null;


        if ($token) {
            // Check if the token exists in the database
            $checkTokenQuery = "SELECT email FROM users WHERE reset_token = ?";
            $stmt = mysqli_prepare($conn, $checkTokenQuery);

            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "s", $token);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if the token is valid
            if ($result && mysqli_num_rows($result) > 0) {
                // Token is valid, proceed with updating the password
                $userData = mysqli_fetch_assoc($result);
                $email = $userData['email'];

                // Update the password in the database
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatePasswordQuery = "UPDATE users SET password = ?, reset_token = NULL WHERE email = ?";
                $stmt = mysqli_prepare($conn, $updatePasswordQuery);

                // Bind the parameters
                mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);

                // Execute the statement
                $updateResult = mysqli_stmt_execute($stmt);

                if ($updateResult) {
                    // Password updated successfully
                    echo '<div class="alert alert-success" role="alert">
                            Le mot de passe a été réinitialisé avec succès.
                          </div>';
                } else {
                    // Bootstrap danger alert
                    echo '<div class="alert alert-danger" role="alert">
                            Erreur lors de la réinitialisation du mot de passe. Erreur: ' . mysqli_stmt_error($stmt) . '
                          </div>';
                }
            } else {
                // Bootstrap danger alert
                echo '<div class="alert alert-danger" role="alert">
                        Token invalide.
                      </div>';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Bootstrap danger alert
            echo '<div class="alert alert-danger" role="alert">
                    Token non fourni.
                  </div>';
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nom de société / Rest</title>
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

                <?php if (isset($password_error)): ?>
                  <?php echo $password_error; ?>
                <?php endif; ?>

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-7">Créez un mot de passe fort</h5>
                    <p class="text-center small">Réinitialisez votre mot de passe maintenant</p>
                  </div>

                    <form id="resetForm" class="row g-3 needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <!-- Add a hidden input field to store and pass the token value -->
                        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">

                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Nouveau mot de passe</label>
                            <div class="input-group mb-3">
                                <input type="password" name="newpassword" class="form-control" placeholder="Votre mot de passe" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="con_password" class="form-control" id="yourPassword" placeholder="confirmation" required>
                        </div>

                        <div class="col-12">
                            <input class="btn btn-primary w-100" type="submit" name="newlogin" value="Réinitialisation">
                        </div>
                        <div class="col-12">
                            <p class="text-center small"><a href="login.php"> Revenir à l’écran de connexion </a></p>
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

 
  <script>

</script>





</body>

</html>