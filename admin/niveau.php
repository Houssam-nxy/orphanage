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



$sql = "SELECT niveau_scolaire, COUNT(*) AS count FROM profil GROUP BY niveau_scolaire";
$result = $conn->query($sql);
$niveaux = array();
$niveauCounts = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $niveaux[] = $row['niveau_scolaire'];
    $niveauCounts[] = $row['count'];
  }
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
      <h1>Graphique</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item">Graphique</li>
          <li class="breadcrumb-item active">Niveau</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <p>Répartition au niveau scolaire</p>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Graphique</h5>

              <!-- Pie Chart -->
              <div id="pieChart"></div>

              <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#pieChart"), {
                    series: <?php echo json_encode($niveauCounts); ?>,
                    chart: {
                      height: 350,
                      type: 'pie',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: <?php echo json_encode($niveaux); ?>
                  }).render();
                });
              </script>
              <!-- End Pie Chart -->
            </div>
          </div>
        </div>
      </div>
    </section>


  </main><!-- End #main -->

  <?php include 'footer.php'; ?>


</body>

</html>