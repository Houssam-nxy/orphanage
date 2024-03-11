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
      <h1>Archives des bénéficiaires </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Détails</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        
      <div class="col-lg-12">
        <div class="col-lg-19">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tableaux de données</h5>
              <p>Cette table <code>affiche les détails</code> des utilisateurs enregistrés tels que noms, villes, dates de naissance, etc., offrant un aperçu complet.</p>

              <!-- Table with stripped rows -->
              <?php


              // Fetch user data from the database
              $query = "SELECT * FROM archives ORDER BY id DESC"; 
              $result = mysqli_query($conn, $query);

              // Check if there are any results
              if (mysqli_num_rows($result) > 0) {
                  ?>
                  <table class="table datatable">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nom</th>
                              <th scope="col">Position</th>
                              <th scope="col">Âge</th>
                              <th scope="col">date d'archivage</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      // Loop through the results and populate the table rows
                      while ($row = mysqli_fetch_assoc($result)) {
                          ?>
                          <tr>
                              <th scope="row"><?php echo $row['id']; ?></th>
                              <td><a href="archives_profiles?id=<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></a></td>
                              <td><?php echo $row['ville']; ?></td>
                              <td><?php echo $row['naissance']; ?></td>
                              <td><?php echo $row['archiving_date']; ?></td>
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

              ?>
              <!-- End Table with stripped rows -->

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