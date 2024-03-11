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



$success_message = $error_message = "";

if (isset($_POST['submit'])) {

    // Escape user input to prevent SQL injection
    function escape_input($input) {
        global $conn;
        return mysqli_real_escape_string($conn, $input);
    }

    // Function to check and escape input
    function safeInput($input) {
        global $conn;
        return !empty($input) ? mysqli_real_escape_string($conn, $input) : null;
    }

    // Collect form data
    $genre = safeInput($_POST['genre']);
    $name = safeInput($_POST['nom']);
    $prenom = safeInput($_POST['Prenom']);
    $naissance = safeInput($_POST['naissance']);
    $ville = safeInput($_POST['ville']);
    $provenance = safeInput($_POST['nam_du_centre']);
    $arrivee = safeInput($_POST['arrivee']);
    $chambre = safeInput($_POST['chambre']);
    $cartid = safeInput($_POST['cartid']);
    $name_description = safeInput($_POST['name_description']);
    $pere_nom_prenom = safeInput($_POST['pere_nom_prenom']);
    $pere_date_naissance = safeInput($_POST['pere_date_naissance']);
    $pere_ville = safeInput($_POST['pere_ville']);
    $pere_tele = safeInput($_POST['pere_tele']);
    $pere_email = safeInput($_POST['pere_email']);
    $pere_identification = safeInput($_POST['pere_identification']);
    $mere_nom_prenom = safeInput($_POST['mere_nom_prenom']);
    $mere_date_naissance = safeInput($_POST['mere_date_naissance']);
    $mere_ville = safeInput($_POST['mere_ville']);
    $mere_tele = safeInput($_POST['mere_tele']);
    $mere_email = safeInput($_POST['mere_email']);
    $mere_identification = safeInput($_POST['mere_identification']);
    $nom_ecole = safeInput($_POST['nom_ecole']);
    $niveau_scolaire = safeInput($_POST['niveau_scolaire']);
    $adaptation = safeInput($_POST['adaptation']);
    $note_semestre1 = safeInput($_POST['note_semestre1']);
    $note_semestre2 = safeInput($_POST['note_semestre2']);
    //$total = safeInput($_POST['total']);
    $total1 = safeInput($_POST['total1']);
    $total2 = safeInput($_POST['total2']);
    $total3 = safeInput($_POST['total3']);
    $totaltronc = safeInput($_POST['totaltronc']);
    $total1bac = safeInput($_POST['total1bac']);
    $total2bac = safeInput($_POST['total2bac']);
    $bourse = safeInput($_POST['bourse']);
    $tutorat = safeInput($_POST['tutorat']);
    $medicaments = safeInput($_POST['medicaments']);
    $etat_de_sante = safeInput($_POST['etat_de_sante']);
    $sante_description = safeInput($_POST['sante_description']);

    // Upload profile picture
    $upload_dir = "../up/";
    $profile_picture = "";
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $profile_picture = $upload_dir . uniqid('img_') . '.' . $file_ext;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    // SQL query to insert beneficiary data
    $beneficiary_query = "INSERT INTO profil (
        genre, nom, prenom, naissance, ville, nam_du_centre, arrivee, chambre, cartid, name_description,
        pere_nom_prenom, pere_date_naissance, pere_ville, pere_tele, pere_email, pere_identification,
        mere_nom_prenom, mere_date_naissance, mere_ville, mere_tele, mere_email, mere_identification,
        nom_ecole, niveau_scolaire, adaptation, note_semestre1, note_semestre2,
        total1, total2, total3, totaltronc, total1bac, total2bac, bourse, tutorat, medicaments,
        etat_de_sante, sante_description, profile_picture
    ) VALUES (
        '$genre', '$name', '$prenom', '$naissance', '$ville', '$provenance', '$arrivee', '$chambre', '$cartid', '$name_description',
        '$pere_nom_prenom', '$pere_date_naissance', '$pere_ville', '$pere_tele', '$pere_email', '$pere_identification',
        '$mere_nom_prenom', '$mere_date_naissance', '$mere_ville', '$mere_tele', '$mere_email', '$mere_identification',
        '$nom_ecole', '$niveau_scolaire', '$adaptation', '$note_semestre1', '$note_semestre2',
        '$total1', '$total2', '$total3', '$totaltronc', '$total1bac', '$total2bac', '$bourse', '$tutorat', '$medicaments',
        '$etat_de_sante', '$sante_description', '$profile_picture'
    )";

    if (mysqli_query($conn, $beneficiary_query)) {
      $success_message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                             <i class="bi bi-check-circle me-1"></i>
                             Le bénéficiaire a été enregistré avec succès
                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>';
  } else {
      $error_message = "Erreur lors de l'ajout du bénéficiaire: " . mysqli_error($conn);
      $error_message1 = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            ' . $error_message . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
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

<?php include 'navbar.php';?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Remplir Le Formulaire</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item">Données</li>
          <li class="breadcrumb-item active">Formule</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

    <?php if (isset($success_message)): ?>
      <?php echo $success_message; ?>
    <?php endif; ?>

    <?php if (isset($error_message1)): ?>
      <?php echo $error_message1; ?>
    <?php endif; ?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <i class="bi bi-info-circle me-1"></i>
      Toutes les données sont enregistrées pour cette année uniquement. Veuillez les mettre à jour chaque année. Nous vous remercions pour votre compréhension.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Données personnelles</h5>

          <!-- General Form Elements -->
          <form action="" method="post" enctype="multipart/form-data">

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Genre</label>
              <div class="col-sm-8">
                <select name="genre" class="form-control" placeholder="Homme" value="">
                    <option>Homme</option>
                    <option>Femme</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Nom</label>
              <div class="col-sm-8">
                <input name="nom" type="text" class="form-control" placeholder="Fahd" required value="">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Prénom</label>
              <div class="col-sm-8">
                <input name="Prenom" type="text" class="form-control" placeholder="El">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Naissance</label>
              <div class="col-sm-8">
                <input name="naissance" type="date" class="form-control">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Ville</label>
              <div class="col-sm-8">
                <input name="ville" type="text" class="form-control" placeholder="Rabat">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Identification</label>
              <div class="col-sm-8">
                <input name="cartid" type="text" class="form-control" placeholder="AA909192">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Provenance</label>
              <div class="col-sm-8">
                <input type="text" list="provenance" name="nam_du_centre" class="form-control" placeholder="Rabat" value="" >
                <datalist id="provenance">
                    <option value="Rabat">
                    <option value="Fes">
                    <option value="Taroudant">
                </datalist>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Arrivée</label>
              <div class="col-sm-8">
                <input name="arrivee" type="date" class="form-control">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label" >Chambre</label>
              <div class="col-sm-8">
                <input name="chambre" type="text" class="form-control" placeholder="A1,B1,C1,MA1">
              </div>
            </div>

  


            <div class="row mb-3">
              <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <textarea name="name_description" class="form-control" style="height: 100px" placeholder="Optionnel*"></textarea>
              </div>
            </div>
            
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Profil</label>
              <div class="col-sm-8">
                <input type="submit" name="submit" class="btn btn-primary" value="Enregistrer le profil">
              </div>
            </div>


            
        </div>
      </div>

    </div>

      <div class="col-lg-6">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class='bx bxs-image-add' ></i> UPLOADER DES FICHIERS</h5>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_0" aria-expanded="false" aria-controls="collapse_0">
                    Image
                  </button>
                </h2>
                <div id="collapse_0" class="accordion-collapse collapse" aria-labelledby="heading_0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <label for="profile_picture">
                            <img class="img-rounded mt-5" width="200px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" id="profile_picture_preview">
                        </label><br><br>
                        <input class="form-control" type="file" name="profile_picture" id="profile_picture" style="display: none;">
                        <span class="font-weight-bold">Bénéficiaire</span>
                        <span class="text-black-50">Nom de société</span>
                    </div>

                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        // Get the file input element
                        const fileInput = document.getElementById('profile_picture');
                  
                        // Get the image preview element
                        const imagePreview = document.getElementById('profile_picture_preview');
                  
                        // Add an event listener for when a file is selected
                        fileInput.addEventListener('change', function(event) {
                          const file = event.target.files[0];
                  
                          // Create a FileReader to read the selected file
                          const reader = new FileReader();
                  
                          // Set the image preview source once the file is loaded
                          reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                          };
                  
                          // Read the selected file as a data URL
                          reader.readAsDataURL(file);
                        });
                      });
                    </script>

                  </div>
                </div>
              </div>
            
            </div><!-- End Default Accordion Example -->
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class='bx bx-male-female' ></i> PARENTS</h5>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_a">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_a" aria-expanded="false" aria-controls="collapse_a">
                    Père
                  </button>
                </h2>
                <div id="collapse_a" class="accordion-collapse collapse" aria-labelledby="heading_a" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <div class="row mt-3">
                      <div class="col-md-6"><label class="labels">Nom et Prénom</label><input type="text" name="pere_nom_prenom" class="form-control" placeholder="Karim Ben" value=""></div>
                      <div class="col-md-6"><label class="labels">Date de naissance</label><input type="date" name="pere_date_naissance" class="form-control" value="" ><br></div>
                      
                      <div class="col-md-6"><label class="labels">Ville</label><input type="text" name="pere_ville" class="form-control" placeholder="Rabat " value=""></div>
                      <div class="col-md-6"><label class="labels">Identification</label><input type="text" name="pere_identification" class="form-control" placeholder="AA151914" value=""><br></div>
                    
                      <div class="col-md-12"><label class="labels">Numéro de téléphone</label><input type="number" name="pere_tele" class="form-control" placeholder="0612131415" value=""><br></div>
                      <div class="col-md-12"><label class="labels">Adresse e-mail</label><input type="email" name="pere_email" class="form-control" placeholder="xyz@gmail.com" value=""><br></div>
                    
                    </div>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_b">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_b" aria-expanded="false" aria-controls="collapse_b">
                    Mère
                  </button>
                </h2>
                <div id="collapse_b" class="accordion-collapse collapse" aria-labelledby="heading_b" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <div class="row mt-3">
                      <div class="col-md-6"><label class="labels">Nom et Prénom</label><input type="text" name="mere_nom_prenom" class="form-control" placeholder="Farah El " value=""></div>
                      <div class="col-md-6"><label class="labels">Date de naissance</label><input type="date" name="mere_date_naissance" class="form-control" value="" 
                      ><br></div>
                      
                      <div class="col-md-6"><label class="labels">Ville</label><input type="text" name="mere_ville" class="form-control" placeholder="Rabat " value=""></div>
                      <div class="col-md-6"><label class="labels">Identification</label><input type="text" name="mere_identification" class="form-control" placeholder="AA151919" value=""><br></div>
                    
                      <div class="col-md-12"><label class="labels">Numéro de téléphone</label><input type="number" name="mere_tele" class="form-control" placeholder="0612131415" value=""><br></div>
                      <div class="col-md-12"><label class="labels">Adresse e-mail</label><input type="email" name="mere_email" class="form-control" placeholder="xyz@gmail.com" value=""><br></div>
                    
                    </div>

                  </div>
                </div>
              </div>
            
            </div><!-- End Default Accordion Example -->
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class='bx bxs-graduation' ></i> PÉDAGOGIQUE</h5>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_c">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_c" aria-expanded="false" aria-controls="collapse_c">
                    Établissement
                  </button>
                </h2>
                <div id="collapse_c" class="accordion-collapse collapse" aria-labelledby="heading_c" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Établissement</label><input type="text" class="form-control" name="nom_ecole" placeholder="Université Mohammed V " value="" ></div>
                        <div class="col-md-6"><label class="labels">Niveau</label>
                            <input type="text" list="niveau" name="niveau_scolaire" class="form-control" placeholder="Hors-scolaire" value="" >
                            <datalist id="niveau">
                                <option value="Collège 1er année">
                                <option value="Collège 2ème année">
                                <option value="Collège 3ème année">
                                <option value="Tronc commun">
                                <option value="Baccalauréat 1er année">
                                <option value="Baccalauréat 2ème année">
                                <option value="Formation professionnelle">
                                <option value="Ecole supérieure">
                                <option value="Hors-scolaire">
                            </datalist><br>
                        </div>
                        <div class="col-md-12"><label class="labels">Adaptation</label>
                          <select class="form-select" name="adaptation">
                              <option value="Non">Non</option>
                              <option value="Oui">Oui</option>
                              <option value="En cour de préparation">En cour de préparation</option>
                          </select>
                      </div>
                    </div><br>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_c_a">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_c_a" aria-expanded="false" aria-controls="collapse_c_a">
                  Résultats
                  </button>
                </h2>
                <div id="collapse_c_a" class="accordion-collapse collapse" aria-labelledby="heading_c_a" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                  <div class="row mt-3">

                      <h5 class="card-title"><span> + Pour cette annee</span></h5>

                      <div class="col-md-6"><label class="labels">Note 1er semestre</label><input type="text" class="form-control" name="note_semestre1" placeholder="x/20" ></div>
                      <div class="col-md-6"><label class="labels">Note 2eme semestre</label><input type="text" class="form-control" name="note_semestre2" placeholder="x/20" ><br></div> 
                      
                      <hr>
                      <h5 class="card-title"><span><i> - Collège</i></span></h5>
                      <div class="col-md-6"><label class="labels">1<sup><small>er</small></sup> Année Collège</label><input type="text" class="form-control" name="total1" placeholder="x/20" value="" ><br></div>
                      <div class="col-md-6"><label class="labels">2<sup><small>ème</small></sup> Année Collège</label><input type="text" class="form-control" name="total2" placeholder="x/20" value="" ><br></div>
                      <div class="col-md-12"><label class="labels">3<sup><small>ème </small></sup> Année Collège Régional</label><input type="text" class="form-control" name="total3" placeholder="x/20" value="" ><br></div>
                      <hr>
                    
                      <h5 class="card-title"><span><i> - Lycée</i></span></h5>
                      <div class="col-md-12"><label class="labels">Tronc commun</label><input type="text" class="form-control" name="totaltronc" placeholder="x/20" value="" ><br></div>
                      <div class="col-md-6"><label class="labels">1<sup><small>er</small></sup> Année Bac Régional<sup><small>er</small></sup></label><input type="text" class="form-control" name="total1bac" placeholder="x/20" value="" ><br></div>
                      <div class="col-md-6"><label class="labels">2<sup><small>ème</small></sup> Année Bac National</label><input type="text" class="form-control" name="total2bac" placeholder="x/20" value="" ><br></div>
                    


                  </div>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_d">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_d" aria-expanded="false" aria-controls="collapse_d">
                     Bourse
                  </button>
                </h2>
                <div id="collapse_d" class="accordion-collapse collapse" aria-labelledby="heading_d" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <div class="col-md-12"><label class="labels">Bourse</label>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" name="bourse" placeholder="Par mois" aria-label="Par mois" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2">DH</span>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_e">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_e" aria-expanded="false" aria-controls="collapse_e">
                    Soutien scolaire
                  </button>
                </h2>
                <div id="collapse_e" class="accordion-collapse collapse" aria-labelledby="heading_e" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    
                    <div class="col-md-12"><label class="labels">Soutien scolaire</label>
                        <input type="text" list="Soutien" name="tutorat" class="form-control" placeholder="Soutien scolaire" value="">
                        <datalist id="Soutien">
                            <option value="Anglais - Math - Français - Physique">
                            <option value="Anglais - Math - Français">
                            <option value="Math - Français">
                            <option value="Français">
                            <option value="Math">
                            <option value="Anglais">
                            <option value="Physique">
                        </datalist>
                    </div>

                  </div>
                </div>
              </div>
            
            </div><!-- End Default Accordion Example -->
          </div>
        </div>


        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class='bx bxs-heart' ></i> SANTÉ</h5>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_f">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_f" aria-expanded="false" aria-controls="collapse_f">
                    Médicaments
                  </button>
                </h2>
                <div id="collapse_f" class="accordion-collapse collapse" aria-labelledby="heading_f" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    
                    <div class="col-md-12"><label class="labels">Médicaments</label><input type="text" name="medicaments" list="medicaments" class="form-control" placeholder="DOLIPRANE" value="">
                      <datalist id="medicaments">
                              <option value="aucun">
                      </datalist>
                      </div>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_g">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_g" aria-expanded="false" aria-controls="collapse_g">
                    Condition médicale
                  </button>
                </h2>
                <div id="collapse_g" class="accordion-collapse collapse" aria-labelledby="heading_g" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    
                    <div class="col-md-12"><label class="labels">Condition médicale</label>
                        <select class="form-control" name="etat_de_sante" placeholder="Male" value="">
                            <option>Bon</option>
                            <option>Moyen</option>
                            <option>Pire</option>
                        </select>
                    </div>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_h">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_h" aria-expanded="false" aria-controls="collapse_h">
                    Description
                  </button>
                </h2>
                <div id="collapse_h" class="accordion-collapse collapse" aria-labelledby="heading_h" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    
                    <div class="row mt-3">
                      <div class="col-md-12"><label class="labels">Description</label><textarea class="form-control" name="sante_description" style="height: 100px" placeholder="Optionnel*"></textarea><br></div>
                    </div>

                  </div>
                </div>
              </div>
            
            </div><!-- End Default Accordion Example -->
          </div>
        </div>

        </form>

      </div>





      </div>
    </section>

  </main><!-- End #main -->

  <?php include 'footer.php'; ?>



</body>

</html>