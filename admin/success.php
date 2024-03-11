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



$beneficiary_query = "SELECT * FROM profil";
$result = mysqli_query($conn, $beneficiary_query);

$intellectuels = [];
$survivants = [];
$perdants = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $totalScore = (intval($row['note_semestre1']) + intval($row['note_semestre2'])) / 2;

        if ($totalScore > 13) {
            $intellectuels[] = $row;
        } elseif ($totalScore >= 10 && $totalScore <= 12) {
            $survivants[] = $row;
        } else {
            $perdants[] = $row;
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


<style>
  .id_card {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    text-align: center;
  }

  .id_card div {
    padding: 1.1rem;
    width: 50%; 
  }

  .id_card img {
    border: 3px solid;
    border-radius: 5px;
    padding: 0.1rem;
    width: 100%;
    height: auto;
  }

  @media (max-width: 767px) {
    .id_card div {
      width: 100%; 
    }
  }
</style>


<?php include 'navbar.php';?>

  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Graphique</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Graphique</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">


      <div class="row">
        <div class="col-lg-6">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Intellectuels <sub>(+13/20)</sub></h5>
                <div>
                  <div class="id_card">
                    <?php
                    foreach ($intellectuels as $beneficiary) {
                        echo '<div style="padding: 1.1rem;">';
                        echo '<a href="profil_donnee?id=' . $beneficiary['id'] . '"><img src="' . (empty($beneficiary['profile_picture']) ? '../up/unk.png' : $beneficiary['profile_picture']) . '" alt="' . $beneficiary['nom'] . ' ' . $beneficiary['prenom'] . '" style="border: 3px solid green; border-radius: 5px; padding: .1rem;"></a>';
                        echo '<p style="text-align: center;">' . $beneficiary['nom'] . ' ' . $beneficiary['prenom'] . '</p>';
                        echo '</div>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Les perdants <sub>(-10/20)</sub></h5>
              <div>
                <div class="id_card">
                  <?php
                  foreach ($perdants as $beneficiary) {
                      echo '<div style="padding: 1.1rem;">';
                      echo '<a href="profil_donnee?id=' . $beneficiary['id'] . '"><img src="' . (empty($beneficiary['profile_picture']) ? '../up/unk.png' : $beneficiary['profile_picture']) . '" alt="' . $beneficiary['nom'] . ' ' . $beneficiary['prenom'] . '" style="border: 3px solid red; border-radius: 5px; padding: .1rem;"></a>';
                      echo '<p style="text-align: center;">' . $beneficiary['nom'] . ' ' . $beneficiary['prenom'] . '</p>';
                      echo '</div>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>

        <div class="col-lg-6">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Les survivants <sub>(10/20 - 12/20)</sub></h5>
                  <div>
                    <div class="id_card">
                      <?php
                      foreach ($survivants as $beneficiary) {
                          echo '<div style="padding: 1.1rem;">';
                          echo '<a href="profil_donnee?id=' . $beneficiary['id'] . '"><img src="' . (empty($beneficiary['profile_picture']) ? '../up/unk.png' : $beneficiary['profile_picture']) . '" alt="' . $beneficiary['nom'] . ' ' . $beneficiary['prenom'] . '" style="border: 3px solid orange; border-radius: 5px; padding: .1rem;"></a>';
                          echo '<p style="text-align: center;">' . $beneficiary['nom'] . ' ' . $beneficiary['prenom'] . '</p>';
                          echo '</div>';
                      }
                      ?>   
                    </div>
                  </div>
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