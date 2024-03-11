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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 require '../phpmailer/phpmailer/src/PHPMailer.php'; 
 require '../phpmailer/phpmailer/src/SMTP.php'; 
 require '../phpmailer/phpmailer/src/Exception.php'; 



$error = false;

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    
    // Get the selected user type from the form
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $name_error = "Le nom doit contenir uniquement des lettres et des espaces";
        $error = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Veuillez saisir un identifiant de messagerie valide";
        $error = true;
    }
    if (strlen($password) < 6) {
        $password_error = "Le mot de passe doit contenir au moins 6 caractères";
        $error = true;
    }
    if (strlen($mobile) < 10) {
        $mobile_error = "Le numéro de portable doit comporter au moins 10 caractères";
        $error = true;
    }
    if ($password != $cpassword) {
        $cpassword_error = "Le mot de passe et la confirmation du mot de passe ne correspondent pas";
        $error = true;
    }

    if (!$error) {
        $query = "INSERT INTO users(name, email, mobile, password, user_type) VALUES(?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $mobile, $hashed_password, $user_type);

        if (mysqli_stmt_execute($stmt)) {

            $mail = new PHPMailer(true);
            try {
                // SMTP configuration (adjust as needed)
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '{Email de société}a@gmail.com'; 
                $mail->Password = '{XXXXXXXXXX}'; 
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->isHTML(true);
                $mail->Subject = 'Bienvenue à {Nom de société} Data Management - Centre Lalla Amina';

                $style = file_get_contents('welcomeemail.php');
                $style = str_replace('{{name}}', $name, $style);
                $style = str_replace('{{email}}', $email, $style);
                $mail->Body = $style;

                $mail->setFrom('{Email de société}@gmail.com', '{Nom de société}');
                $mail->addAddress($email);

                $mail->send();
                $_SESSION['success_message'] = 'Le compte a été ajouté avec succès, et l\'e-mail de bienvenue a été envoyé avec succès.';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Le message n\'a pas pu être envoyé. Erreur de messagerie : ' . $mail->ErrorInfo . '<br>Message d\'exception : ' . $e->getMessage();
            }
            

            header("location: register");
            exit();
        } else {
          $_SESSION['error_message'] = "Erreur: " . $query . "" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}


if (isset($_SESSION['success_message'])) {
  echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
  unset($_SESSION['success_message']); 
}

if (isset($_SESSION['error_message'])) {
  echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
  unset($_SESSION['error_message']); 
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nom de société / Registre</title>
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

  <main>



    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Nom de société</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Créer un compte</h5>
                    <p class="text-center small">Saisissez les données personnelles du nouveau compte utilisateur</p>
                  </div>

                  <form class="row g-3 needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="col-12">
                      <label for="yourName" class="form-label">Votre nom</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">S'il vous plaît entrez votre nom!</div>
                      <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Votre e-mail</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">S'il vous plaît, mettez une adresse email valide!</div>
                      <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Votre téléphone mobile</label>
                      <input type="number" name="mobile" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">S'il vous plaît, mettez un numero mobile valide!</div>
                      <span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">S'il vous plait entrez votre mot de passe!</div>
                      <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirmer le mot de passe</label>
                      <input type="password" name="cpassword" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Veuillez confirmer votre mot de passe!</div>
                      <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Type de compte</label>
                      <select aria-label="Default select example" name="user_type" class="form-control" id="user_type" required>
                        <option value="Admin">Admin</option>
                      </select>
                    </div>

                    <div class="col-12">
                      <input class="btn btn-primary w-100" type="submit" name="signup" value="Créer un compte">
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Vous pouvez trouver tous les utilisateurs <a href="users">ici</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Conçu par <a href="">Houssam_nxy</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>