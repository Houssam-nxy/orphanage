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
    .all_imgs {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .all_info {
      text-align: center;
      width: 100%;
    }

    .info-person H5{
        padding-left: 7%;
        width: 100px;
        text-align: start;
    }

    .person {
      display: flex;
      flex-wrap: wrap;
      padding: .5rem;
      justify-content: center;
      text-align: center; /* Adjusted to center text */
      align-items: center;
      width: 50%; /* Adjusted width for three items in a row */
    }

    .person img {
      padding: .5rem;
      border: 1px solid black;
      border-radius: 3px;
      width: 150px; 
      height: 170px;
    }

    .info-person {
      padding-top: 5%;
    }
</style>

<?php include 'navbar.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Chambres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Accueil</a></li>
                <li class="breadcrumb-item active">Chambres</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ici, vous trouverez toutes les chambres occupées.</h5>
                        <form method="post" action="">
                            <div class=""
                                style="justify-content: center;text-align: center;align-items: center;width: 100%;">
                                <div class="">
                                    <br><input name="nom" type="text" class="form-control" placeholder="C9"
                                        required value="">
                                </div>
                                <div class="">
                                    <br>
                                    <input type="submit" name="submit" class="btn btn-primary" value="scanner"><br>
                                </div>
                            </div>

                            <div>
                                <br>
                                <hr>
                                <br>

                                <?php

                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                                    // Get the user input
                                    $searchTerm = $_POST['nom'];

                                    // Prepare the SQL query to search for the specified chambre
                                    $sql = "SELECT * FROM profil WHERE chambre = ?";

                                    // Use prepared statements to prevent SQL injection
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('s', $searchTerm);
                                    $stmt->execute();

                                    // Get the result set
                                    $result = $stmt->get_result();

                                    // Check if any rows are returned
                                    if ($result->num_rows > 0) {
                                        // Display the images for each row found
                                        echo '<div class="all_imgs">';

                                        while ($row = $result->fetch_assoc()) {
                                            // Display each person's information
                                            echo '<div class="person">';
                                            echo '<img src="' . $row['profile_picture'] . '" alt="" width="150">';
                                            echo '<div class="info-person"><H5>' . $row['prenom'] . '<br>' . $row['nom'] . '</H5></div>';
                                            echo '</div>';
                                        
                                            /*/ Display the icon only if there are two images
                                            if ($result->num_rows === 2) {
                                                echo '<div class="icon-person"><H1><i class="bx bx-data"></i></H1></div>';
                                            }

                                            // Display the second image with empty border
                                            echo '<div class="person"><img src="" alt="" width="150" style="border: 1px solid transparent;"></div>';
                                        */
                                        }

                                        echo '</div>'; // Close the container div
                                    } else {
                                        // No matching rows found
                                        echo 'Aucune chambre correspondante trouvée.';
                                    }

                                    // Close the statement and connection
                                    $stmt->close();
                                    $conn->close();
                                }
                                ?>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include 'footer.php'; ?>

</body>

</html>
