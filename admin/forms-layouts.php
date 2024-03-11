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



$query = "SELECT * FROM users WHERE uid = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $nom = $_POST['nom'];
    $sujet = $_POST['sujet'];
    $message = $_POST['message'];
    $profile_image = $_POST['profile_image'];  // Add this line

    // Prepare and execute SQL query
    $insert_query = "INSERT INTO messages (nom, sujet, message, profile_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $nom, $sujet, $message, $profile_image);

    if ($stmt->execute()) {
        $success_message =' <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <i class="bi bi-check-circle me-1"></i>
                                Article sauvegardé avec succès / Vous pouvez le voir <a href="message">ici</a>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
    } else {
        // error
        $error_message = "Error: " . $stmt->error;
        $error_message1 = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <i class="bi bi-exclamation-octagon me-1"></i>
                              <?php echo $error_message; ?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
    }

    $stmt->close();
    $conn->close();
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


<style>
  textarea{
      height: 80px;
  }

</style>

  <?php include 'navbar.php'; ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Articles</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Articles</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">

      <?php if (isset($success_message)): ?>
        <?php echo $success_message; ?>
      <?php endif; ?>

      <?php if (isset($error_message1)): ?>
        <?php echo $success_message1; ?>
      <?php endif; ?>

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Écrivez votre formulaire ici</h5>

              <!-- Horizontal Form -->

              

              <form action="" method="post" enctype="multipart/form-data">

              <input type="hidden" name="profile_image" class="form-control" value="<?php echo $row['profile_image_users']; ?>">

                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Votre Nom</label>
                  <div class="col-sm-10">
                    <input type="text" name="nomview" class="form-control" id="inputText" value="<?php echo $row['name']; ?>" disabled>
                    <input type="hidden" name="nom" class="form-control" id="inputText" value="<?php echo $row['name']; ?>" >
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Objet</label>
                  <div class="col-sm-10">
                    <input type="text" name="sujet" class="form-control" id="inputtext">
                  </div>
                </div>

                <div class="row mb-3">
                    <label for="message" class="col-sm-2 col-form-label">Message</label>
                    <div class="col-sm-10">
                        <textarea name="message" class="form-control tinymce-editor" ></textarea>
                    </div>
                </div>
                <br><br>
                
                <div class="text-center">
                  
                  <button type="submit" name="submit" class="btn btn-primary">Publier</button>
                  <button type="reset" class="btn btn-secondary"><a href="index" style="text-decoration: none;color: #fff;">Annuler</a></button>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

        

        </div>
      </div>
    </section>      

  </main><!-- End #main -->

  
  <?php include 'footer.php'; ?>

</body>

</html>