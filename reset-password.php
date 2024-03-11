<?php
session_start();

require_once "admin/conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 require 'phpmailer/phpmailer/src/PHPMailer.php'; 
 require 'phpmailer/phpmailer/src/SMTP.php'; 
 require 'phpmailer/phpmailer/src/Exception.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sendmail"])) {
    // Validate email
    $email = trim($_POST["email"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Sanitize the email for database query
        $email = mysqli_real_escape_string($conn, $email);

        // Check if the email exists in the database
        $checkEmailQuery = "SELECT name FROM users WHERE email = '$email'";
        $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

        if ($checkEmailResult) {
            if (mysqli_num_rows($checkEmailResult) > 0) {
                // Email exists, proceed with the password reset
                $userData = mysqli_fetch_assoc($checkEmailResult);
                $username = $userData['name'];

                // Generate a more secure reset token
                $resetToken = bin2hex(random_bytes(32));

                // Save the reset token in the database for this user
                $updateTokenQuery = "UPDATE users SET reset_token = '$resetToken' WHERE email = '$email'";
                $updateTokenResult = mysqli_query($conn, $updateTokenQuery);

                if ($updateTokenResult) {
                    // Create a reset link
                    $resetLink = "http://localhost:8888/cla/new-password.php?token=$resetToken";

                    // Create a new PHPMailer instance
                    $mail = new PHPMailer(true);

                    try {
                        // SMTP configuration (adjust as needed)
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = '{Email de société}@gmail.com'; // Replace with your Gmail username
                        $mail->Password = '{XXXXXXXXXXXX}'; // Replace with your Gmail password
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;
                        $mail->isHTML(true);
                        $mail->Subject = 'Réinitialiser le mot de passe';

                        // Include the email style content
                        $style = file_get_contents('emailstyle.php');
                        // Replace placeholders with actual data
                        $style = str_replace('{{name}}', $username, $style);
                        $style = str_replace('{{email}}', $email, $style);
                        $style = str_replace('{{action_url}}', $resetLink, $style);
                        $mail->Body = $style;

                        $mail->setFrom('{Email de société}@gmail.com', '{Nom de société}');
                        $mail->addAddress($email);
                        
                        $mail->send();

                        echo '<div class="alert alert-success" role="alert">
                                Un lien de réinitialisation a été envoyé à votre adresse e-mail.
                              </div>';
                    } catch (Exception $e) {
                        
                        echo '<div class="alert alert-danger" role="alert">
                                Le message n\'a pas pu être envoyé. Erreur de messagerie : ' . $mail->ErrorInfo . '<br>
                                Message d\'exception : ' . $e->getMessage() . '
                              </div>';
                    }
                } else {
                    // Bootstrap danger alert
                    echo '<div class="alert alert-danger" role="alert">
                            Erreur lors de la mise à jour du jeton de réinitialisation dans la base de données.
                          </div>';
                }
            } else {
                // Bootstrap danger alert
                echo '<div class="alert alert-danger" role="alert">
                        L\'adresse e-mail n\'existe pas dans la base de données.
                      </div>';
            }
        } else {
            // Handle database query error
            // Bootstrap danger alert
            echo '<div class="alert alert-danger" role="alert">
                    Erreur de requête SQL: ' . mysqli_error($conn) . '
                  </div>';
        }
    } else {
        // Bootstrap danger alert
        echo '<div class="alert alert-danger" role="alert">
                Adresse e-mail invalide.
              </div>';
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nom de société / Reset</title>
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
               

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-8">Problèmes de connexion ?</h5>
                    <p class="text-center small">Entrez votre adresse e-mail et nous vous enverrons un lien pour récupérer votre compte.</p>
                  </div>

                  <form class="row g-3 needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="col-12">
                      <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="E-mail" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <input class="btn btn-primary w-100" type="submit" name="sendmail" value="Réinitialisation">
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

 


</body>

</html>