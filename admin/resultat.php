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


// Fetch beneficiary data from the database
$query = "SELECT id, nom, prenom, note_semestre1, note_semestre2 FROM profil";
$result = mysqli_query($conn, $query);

// Initialize arrays for beneficiary names and total scores
$beneficiaryNames = [];
$totalScores = [];

while ($row = mysqli_fetch_assoc($result)) {
    $beneficiaryNames[] = $row['nom'] . ' ' . $row['prenom'];

    // Check if either note_semestre1 or note_semestre2 is zero or empty
    if (!empty($row['note_semestre1']) && !empty($row['note_semestre2'])) {
        $score1 = (int)$row['note_semestre1'];
        $score2 = (int)$row['note_semestre2'];

        if ($score1 !== 0 && $score2 !== 0) {
            $average = ($score1 + $score2) / 2;
            $totalScores[] = $average;
        }
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
          <li class="breadcrumb-item active">Résultats</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <p>Tableau d'évaluation des bénéficiaires</p>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Graphique</h5>

                <!-- Area Chart -->
                <div id="areaChart"></div>

                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                <script>
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350,
                        },
                        series: [{
                            name: 'Résultat',
                            data: <?php echo json_encode($totalScores); ?>,
                        }],
                        xaxis: {
                            categories: <?php echo json_encode($beneficiaryNames); ?>,
                        },
                    };

                    var chart = new ApexCharts(document.querySelector('#areaChart'), options);
                    chart.render();
                </script>

                <!-- End Area Chart -->
            </div>
          </div>
        </div>
      </div>
    </section>


  </main>

  <?php include 'footer.php'; ?>


</body>

</html>