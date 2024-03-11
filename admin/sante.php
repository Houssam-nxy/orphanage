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



$sql = "SELECT etat_de_sante, COUNT(*) AS count FROM profil WHERE etat_de_sante IN ('Bon', 'Moyen', 'Pire') GROUP BY etat_de_sante";

$result = $conn->query($sql);

$healthConditions = array('Bon', 'Moyen', 'Pire');
$conditionCounts = array(0, 0, 0);
$conditionPercentages = array(0, 0, 0);

$totalCount = 0;
while ($row = $result->fetch_assoc()) {
    $index = array_search($row['etat_de_sante'], $healthConditions);
    if ($index !== false) {
        $conditionCounts[$index] = $row['count'];
        $totalCount += $row['count'];
    }
}

for ($i = 0; $i < count($healthConditions); $i++) {
    $conditionPercentages[$i] = ($totalCount > 0) ? ($conditionCounts[$i] / $totalCount) * 100 : 0;
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
          <li class="breadcrumb-item active">Santé</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <p>Répartition des conditions de santé</p>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Graphique</h5>

              <!-- Radial Bar Chart -->
              <div id="radialBarChart"></div>

              <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
              <script>
                  document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#radialBarChart"), {
                          series: <?php echo json_encode($conditionPercentages); ?>,
                          chart: {
                              height: 350,
                              type: 'donut',
                              toolbar: {
                                  show: true,
                                  tools: {
                                      download: true,
                                  },
                                  export: {
                                      csv: {
                                          filename: 'health-conditions-data',
                                          columnDelimiter: ',',
                                          headerCategory: 'Condition',
                                          headerValue: 'Percentage',
                                      },
                                      svg: {
                                          filename: 'health-conditions',
                                      },
                                      png: {
                                          filename: 'health-conditions',
                                      }
                                  },
                                  autoSelected: 'download'
                              }
                          },
                          labels: <?php echo json_encode($healthConditions); ?>
                      }).render();
                  });
              </script>

              <!-- End donut Bar Chart -->
              
            </div>
          </div>
        </div>
      </div>
    </section>


  </main><!-- End #main -->

  <?php include 'footer.php'; ?>


</body>

</html>