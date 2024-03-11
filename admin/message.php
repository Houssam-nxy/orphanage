

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


include 'navbar.php';


// Handle delete action
if (isset($_POST['delete'])) {
  $noteId = $_POST['noteId']; 
  $deleteSql = "DELETE FROM messages WHERE id = '$noteId'";
  mysqli_query($conn, $deleteSql);
}

// Retrieve user information
$query = "SELECT * FROM users WHERE uid = {$_SESSION['user_id']}";
$userResult = mysqli_query($conn, $query);
$userRow = mysqli_fetch_assoc($userResult);

// Retrieve messages
$sql = "SELECT * FROM messages ORDER BY timestamp DESC";
$result = mysqli_query($conn, $sql);


?>

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
      <div class="row">
        <div class="col-lg-">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ici, vous trouverez tous les articles.</h5>

              <!--  #  -->

              

              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                  <div class="d-flex">
                      <div class="flex-shrink-0">
                          <img src="<?php echo empty($row['profile_image']) ? '../up/user.png' : $row['profile_image']; ?>" class="media-object" style="width: 40px">
                      </div>
                      <div class="flex-grow-1 ms-3">
                          <h5 class="media-heading">
                              <strong>
                                  <a href="" data-bs-toggle="modal" data-bs-target="#fullscreenModal<?= $row["id"] ?>">
                                      <?php echo $row["nom"]; ?>
                                  </a>
                              </strong><br>
                              <small class="text-muted" style="font-size: 15px;">
                                  <i> Publié le <?php echo $row['timestamp']; ?></i>
                              </small>
                          </h5>
                          <p><?php echo $row["sujet"]; ?></p>
                      </div>
                  </div>

                  <div class="modal fade" id="fullscreenModal<?= $row["id"] ?>" tabindex="-1">
                      <div class="modal-dialog modal-fullscreen">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title"><?php echo $row["sujet"]; ?></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <?php echo $row["message"]; ?>
                              </div>
                              <div class="modal-footer">
                                  <form action="" method="post">
                                      <input type="hidden" name="noteId" value="<?= $row['id'] ?>">
                                      <button type="submit" class="btn btn-secondary" name="delete">Supprimer</button>
                                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div><!-- End Full Screen Modal-->

                  <hr><br>
              <?php } ?>
              <!-- # -->

            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include 'footer.php'; ?>

</body>

</html>