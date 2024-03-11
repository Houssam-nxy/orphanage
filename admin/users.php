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
      <h1>Gestion des accès utilisateurs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Utilisateurs</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section users">
      <div class="row">
        <div class="col-lg-19">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Accès</h5>
              <p>Cette table <code>affiche les détails</code> des utilisateurs enregistrés tels que noms, Gmail, etc., offrant un aperçu complet.</p>

              
              <?php
              $query = "SELECT * FROM users"; 
              $result = mysqli_query($conn, $query);

              if (mysqli_num_rows($result) > 0) {
                ?>
                <table class="table datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nom</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                      <tr>
                        <th scope="row"><?php echo $row['uid']; ?></th>
                        <td>
                          <a href="profile_access?id=<?php echo $row['uid']; ?>">
                            <?php echo $row['name']; ?>
                          </a>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
                <?php
              } else {
                echo "Pas de données disponibles.";
              }

              mysqli_close($conn);
              ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    

  </main>

<?php include('footer.php'); ?>

</body>

</html>