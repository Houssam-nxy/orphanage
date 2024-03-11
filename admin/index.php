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




// Retrieve messages
$sql_messages = "SELECT * FROM messages ORDER BY timestamp DESC";
$result_messages = mysqli_query($conn, $sql_messages);

// Retrieve beneficiaries
$sql_beneficiaries = "SELECT * FROM profil";
$result_beneficiaries = mysqli_query($conn, $sql_beneficiaries);

$sqlFemme = "SELECT COUNT(*) AS count FROM profil WHERE genre = 'Femme'";
$resultFemme = mysqli_query($conn, $sqlFemme);
$rowFemme = mysqli_fetch_assoc($resultFemme);
$femmeCount = $rowFemme['count'];


$sqlHomme = "SELECT COUNT(*) AS count FROM profil WHERE genre = 'Homme'"; 
$resultHomme = mysqli_query($conn, $sqlHomme);
$rowHomme = mysqli_fetch_assoc($resultHomme);
$hommeCount = $rowHomme['count'];

$totalScores = (int)$femmeCount + (int)$hommeCount;


$query = "SELECT * FROM users WHERE uid = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

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
      <h1>Tableau de bord</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Tableau de bord</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Bénéficiaires <span>| Instable</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $totalScores; ?></h6>
                      <span class="text-success small pt-1 fw-bold"><i class='bx bx-male-female' ></i></span><span class="text-muted small pt-2 ps-1">Mâle & Femelle</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Homme <span>| Instable</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $hommeCount; ?></h6>
                      <span class="text-success small pt-1 fw-bold"><i class='bx bx-male-sign'></i></span><span class="text-muted small pt-2 ps-1">Mâle</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Femme <span>| Instable</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $femmeCount; ?></h6>
                      <span class="text-success small pt-1 fw-bold"><i class='bx bx-female-sign'></i></span><span class="text-muted small pt-2 ps-1">Femelle</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Datatables -->


      <div class="col-lg-12">
        <div class="col-lg-19">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Datatables</h5>
              <p>Cette table <code>affiche les détails</code> des utilisateurs enregistrés tels que noms, villes, dates de naissance, etc., offrant un aperçu complet.</p>

              <!-- Table with stripped rows -->
              <?php


              
              $query = "SELECT * FROM profil ORDER BY id DESC"; 
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
                              <th scope="col">Date de début</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      // Loop through the results and populate the table rows
                      while ($row = mysqli_fetch_assoc($result)) {
                          ?>
                          <tr>
                              <th scope="row"><?php echo $row['id']; ?></th>
                              <td><a href="profil_donnee?id=<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></a></td>
                              <td><?php echo $row['ville']; ?></td>
                              <td><?php echo $row['naissance']; ?></td>
                              <td><?php echo $row['timestamp']; ?></td>
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

              // Close the database connection
              mysqli_close($conn);
              ?>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
            
            <!-- End Datatables -->





            

          </div>
        </div><!-- End Left side columns -->

        
        <!-- Right side columns -->
        <div class="col-lg-4">


      <!-- ############################### -->
        <!-- Recent Activity -->
      <!-- ############################### -->

          <!-- News & Updates Traffic -->
          <div class="card">

            <div class="card-body pb-0">
              <h5 class="card-title">Actualités &amp; mises à jour <span>| Nouveau</span></h5>

              <div class="news">

              <?php while ($row = mysqli_fetch_assoc($result_messages)) { ?>

                <div class="post-item clearfix" data-bs-toggle="modal" data-bs-target="#fullscreenModal<?= $row["id"] ?>" style="cursor: pointer;">
                  <img src="<?php echo empty($row['profile_image']) ? '../up/user.png' : $row['profile_image']; ?>" alt="">
                  <h4><a href="#"><?= $row["nom"] ?></a></a></h4>
                  <p>Sujet,<br><strong> <?= $row["sujet"] ?></strong></p>
                </div>

                <div class="modal fade" id="fullscreenModal<?= $row["id"] ?>" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title"><?= $row["sujet"] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <?= $row["message"] ?>
                    </div>
                    <div class="modal-footer">
                      <form action="" method="post">
                        <input type="hidden" name="noteId" value="<?= $row['id'] ?>">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Annuler</button>
                      </form>
                      </div>
                </div>
                </div>
              </div><!-- End Full Screen Modal-->

                <br>
                <?php } ?>

              </div><!-- End sidebar recent posts-->

            </div>
          </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <?php include 'footer.php'; ?>


</body>

</html>