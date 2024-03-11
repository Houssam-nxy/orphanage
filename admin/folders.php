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
  <link href="assets/img/logo1.png" rel="icon">
  <link href="assets/img/logo1.png" rel="apple-touch-icon">

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

  <!-- Add the following line to include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

<style>
    .all_folders{
        width: 100%;
        
    }
    .solo-fold-css{
        display: flex;
        flex-wrap: wrap;
    }
    .one-fold-css{
        padding: 5px;
    }
    .sel-folder{
        cursor: pointer;
        box-sizing:border-box;
        width: 100px;
        text-align: center;
        
    }
</style>

<?php include 'navbar.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dossiers Personnels des Bénéficiaires</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Accueil</a></li>
                <li class="breadcrumb-item active">Bénéficiaires' Documentation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ici, vous trouverez l'ensemble des dossiers des bénéficiaires.</h5>
                        
                        
                        <form method="post" action="">
                            <div class="all_folders">
                                <div class="solo-fold-css">
                                    <?php

                                    $foldsql = "SELECT * FROM profil";
                                    $resultat_foldsql = mysqli_query($conn, $foldsql);

                                    if($resultat_foldsql->num_rows > 0){
                                        while($rowfold = $resultat_foldsql->fetch_assoc()){
                                            echo '<div class="one-fold-css">';
                                            echo '<a id="gofolder" href="profil_donnee?id=' . $rowfold['id'] . '" target="_self">';
                                            echo '<div class="sel-folder">';
                                            echo '<img src="../assets/img/folder1.png" alt="folder" width="50px">';
                                            echo '<p>'.$rowfold["nom"] .'</p>';
                                            echo '</div>';
                                            echo '</a>';
                                            echo '</div>';
                                        }

                                    }else{
                                        echo 'Pas de données disponibles.';
                                    }
                                    
                                    
                                    ?>
                                </div>                                
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<script>
jQuery(function($) {
    $('#gofolder').click(function() {
        return false;
    }).dblclick(function() {
        window.location = this.href;
        return false;
    });
});
</script>

<?php include 'footer.php'; ?>

</body>

</html>
