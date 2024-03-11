<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  
include('conn.php'); 

// check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login");
    exit;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve data from the form
    $beneficiaire = $_POST['nom'];
    $visiteur = $_POST['visiteur'];
    $cin_visiteur = $_POST['cin'];
    $type_visiteur = $_POST['type_visiteur'];
    $lieu = $_POST['lieu'];
    $date_heure = $_POST['DT'];
    $description = $_POST['description'];

    // Insert data into the SQL table
    $sql = "INSERT INTO visites (beneficiaire, visiteur, cin_visiteur, type_visiteur, lieu, date_heure, description)
            VALUES ('$beneficiaire', '$visiteur', '$cin_visiteur', '$type_visiteur', '$lieu', '$date_heure', '$description')";

    if ($conn->query($sql) === TRUE) {
        header("Location: list_visitor");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
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
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
                             
</head>

<body>

  <?php include 'navbar.php'; ?>
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Visites</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Visites</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">

    <?php if (isset($success_message)): ?>
      <?php echo $success_message; ?>
    <?php endif; ?>

    <?php if (isset($error_message1)): ?>
      <?php echo $success_message1; ?>
    <?php endif; ?>

      <div class="row">
        <div class="col-lg-12">





        <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class='bx bx-calendar'></i> Formulaire de visites</h5>
              <p>Remplissez les informations nécessaires ci-dessous pour enregistrer une nouvelle visite.</p><br>

                    <!-- General Form Elements -->
                    <form action="" method="post" enctype="multipart/form-data">


                        <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Bénéficiaire</label>
                        <div class="col-sm-8">
                            <input name="nom" type="text" class="form-control" placeholder="Fayçal" required value="">
                        </div>
                        </div>


                        <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Visiteur</label>
                        <div class="col-sm-8">
                            <input name="visiteur" type="text" class="form-control" placeholder="Meryem" required value="">
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">CIN Visiteur</label>
                        <div class="col-sm-8">
                            <input name="cin" type="text" class="form-control" placeholder="AB121314" required value="">
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">type de visiteur</label>
                        <div class="col-sm-8">
                        <input type="text" list="type_v" name="type_visiteur" class="form-control" placeholder="Famille" value="" >
                            <datalist id="type_v">
                                <option value="Famille">
                                <option value="Ami">
                                <option value="autre">
                            </datalist>
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Lieu</label>
                        <div class="col-sm-8">
                            <input name="lieu" type="text" class="form-control" placeholder="Maisonnette B1" value="">
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Date et l'heure</label>
                        <div class="col-sm-8">
                            <input name="DT" type="datetime-local" class="form-control" placeholder="Fahd" value="">
                        </div>
                        </div>

            


                        <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                            <textarea name="description" class="form-control" style="height: 100px" placeholder="Optionnel*"></textarea>
                        </div>
                        </div>
                        
                        <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Enregistrer</label>
                        <div class="col-sm-8">
                            <input type="submit" name="submit" class="btn btn-primary" value="Sauvegarder la visite">
                        </div>
                        </div>

        

        </div>
      </div>
    </section>      

  </main><!-- End #main -->

  
  <?php include 'footer.php'; ?>

</body>

</html>