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

    // Collect form data
    $genre = escape_input($_POST['genre']);
    $name = escape_input($_POST['nom']);
    $prenom = escape_input($_POST['Prenom']);
    $naissance = escape_input($_POST['naissance']);
    $ville = escape_input($_POST['ville']);
    $provenance = escape_input($_POST['provenance']);
    $arrivee = escape_input($_POST['arrivee']);
    $chambre = escape_input($_POST['chambre']);
    $cartid = escape_input($_POST['cartid']);
    $name_description = escape_input($_POST['name_description']);
    $pere_nom_prenom = escape_input($_POST['pere_nom_prenom']);
    $pere_date_naissance = escape_input($_POST['pere_date_naissance']);
    $pere_ville = escape_input($_POST['pere_ville']);
    $pere_tele = escape_input($_POST['pere_tele']);
    $pere_email = escape_input($_POST['pere_email']);
    $pere_identification = escape_input($_POST['pere_identification']);
    $mere_nom_prenom = escape_input($_POST['mere_nom_prenom']);
    $mere_date_naissance = escape_input($_POST['mere_date_naissance']);
    $mere_ville = escape_input($_POST['mere_ville']);
    $mere_tele = escape_input($_POST['mere_tele']);
    $mere_email = escape_input($_POST['mere_email']);
    $mere_identification = escape_input($_POST['mere_identification']);
    $nom_ecole = escape_input($_POST['nom_ecole']);
    $niveau_scolaire = escape_input($_POST['niveau_scolaire']);
    $adaptation = escape_input($_POST['adaptation']);
    $note_semestre1 = escape_input($_POST['note_semestre1']);
    $note_semestre2 = escape_input($_POST['note_semestre2']);
    //$total = escape_input($_POST['total']);
    $total1 = escape_input($_POST['total1']);
    $total2 = escape_input($_POST['total2']);
    $total3 = escape_input($_POST['total3']);
    $totaltronc = escape_input($_POST['totaltronc']);
    $total1bac = escape_input($_POST['total1bac']);
    $total2bac = escape_input($_POST['total2bac']);
    $bourse = escape_input($_POST['bourse']);
    $tutorat = escape_input($_POST['tutorat']);
    $medicaments = escape_input($_POST['medicaments']);
    $etat_de_sante = escape_input($_POST['etat_de_sante']);
    $sante_description = escape_input($_POST['sante_description']);

      
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
    $update_query = "UPDATE profil SET genre = '$genre', nom = '$name', prenom = '$prenom', naissance = '$naissance', ville = '$ville', provenance = '$provenance', arrivee = '$arrivee', chambre = '$chambre', cartid = '$cartid', name_description = '$name_description', pere_nom_prenom = '$pere_nom_prenom', pere_date_naissance = '$pere_date_naissance', pere_ville = '$pere_ville', pere_tele = '$pere_tele', pere_email = '$pere_email', pere_identification = '$pere_identification', mere_nom_prenom = '$mere_nom_prenom', mere_date_naissance = '$mere_date_naissance', mere_ville = '$mere_ville', mere_tele = '$mere_tele', mere_email = '$mere_email', mere_identification = '$mere_identification', nom_ecole = '$nom_ecole', niveau_scolaire = '$niveau_scolaire', adaptation = '$adaptation', note_semestre1 = '$note_semestre1', note_semestre2 = '$note_semestre2', total1 = '$total1', total2 = '$total2', total3 = '$total3', totaltronc = '$totaltronc', total1bac = '$total1bac', total2bac = '$total2bac', bourse = '$bourse', tutorat = '$tutorat', medicaments = '$medicaments', etat_de_sante = '$etat_de_sante', sante_description = '$sante_description', profile_picture = '$profile_picture' WHERE id = $record_id";
    
    if (mysqli_query($conn, $update_query)) {
        $success_message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                  Les données ont été modifiées avec succès
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';

        // Clear the session variable holding the record ID
        unset($_SESSION['record_id']);
    } else {
        $error_message = "Erreur lors de la modification des données: " . mysqli_error($conn);
    }
    
}

// Check if the beneficiary ID was provided as a GET parameter
if(isset($_GET['id'])) {
    $record_id = $_GET['id'];
  
    // Query the beneficiary record with the given ID
    $select_query = "SELECT * FROM profil WHERE id='$record_id'";
    $result = mysqli_query($conn, $select_query);
  
    // Check if the beneficiary record was found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $genre = $row['genre'];
        $name = $row['nom'];
        $prenom = $row['prenom'];
        $naissance = $row['naissance'];
        $ville = $row['ville'];
        $provenance = $row['provenance'];
        $arrivee = $row['arrivee'];
        $chambre = $row['chambre'];
        $cartid = $row['cartid'];
        $name_description = $row['name_description'];
        $pere_nom_prenom = $row['pere_nom_prenom'];
        $pere_date_naissance = $row['pere_date_naissance'];
        $pere_ville = $row['pere_ville'];
        $pere_tele = $row['pere_tele'];
        $pere_email = $row['pere_email'];
        $pere_identification = $row['pere_identification'];
        $mere_nom_prenom = $row['mere_nom_prenom'];
        $mere_date_naissance = $row['mere_date_naissance'];
        $mere_ville = $row['mere_ville'];
        $mere_tele = $row['mere_tele'];
        $mere_email = $row['mere_email'];
        $mere_identification = $row['mere_identification'];
        $nom_ecole = $row['nom_ecole'];
        $niveau_scolaire = $row['niveau_scolaire'];
        $adaptation = $row['adaptation'];
        $note_semestre1 = $row['note_semestre1'];
        $note_semestre2 = $row['note_semestre2'];
        $total = $row['total'];
        $total1 = $row['total1'];
        $total2 = $row['total2'];
        $total3 = $row['total3'];
        $totaltronc = $row['totaltronc'];
        $total1bac = $row['total1bac'];
        $total2bac = $row['total2bac'];
        $bourse = $row['bourse'];
        $tutorat = $row['tutorat'];
        $medicaments = $row['medicaments'];
        $etat_de_sante = $row['etat_de_sante'];
        $sante_description = $row['sante_description'];
        $profile_picture =  $row['profile_picture'];

    } else {
      echo "<script>alert('Enregistrement du bénéficiaire introuvable!');</script>";
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
      <?php echo $success_message1; ?>
    <?php endif; ?>

    

  <div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Données personnelles</h5>

          <!-- General Form Elements -->
          <form action="update?id=<?php echo $record_id; ?>" method="post" enctype="multipart/form-data">

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
                <input name="nom" type="text" class="form-control" placeholder="" required value="<?php echo $name; ?>">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Prénom</label>
              <div class="col-sm-8">
                <input name="Prenom" type="text" class="form-control" placeholder="El" value="<?php echo $prenom; ?>">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Naissance</label>
              <div class="col-sm-8">
                <input name="naissance" type="date" class="form-control" value="<?php echo $naissance; ?>">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Ville</label>
              <div class="col-sm-8">
                <input name="ville" type="text" class="form-control" placeholder="Rabat" value="<?php echo $ville; ?>">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Identification</label>
              <div class="col-sm-8">
                <input name="cartid" type="text" class="form-control" placeholder="AA909192" value="<?php echo $cartid; ?>">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Provenance</label>
              <div class="col-sm-8">
                <input type="text" list="provenance" name="provenance" class="form-control" placeholder="Rabat" value="<?php echo $provenance; ?>">
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
                <input name="arrivee" type="date" class="form-control" value="<?php echo $arrivee; ?>">
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label" >Chambre</label>
              <div class="col-sm-8">
                <input name="chambre" type="text" class="form-control" placeholder="A1,B1,C1,MA1" value="<?php echo $chambre; ?>">
              </div>
            </div>

  


            <div class="row mb-3">
              <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <textarea name="name_description" class="form-control" style="height: 100px" placeholder="Optionnel*"><?php echo $name_description; ?></textarea>
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
                            <img class="img-rounded mt-5" width="200px" src="<?php echo empty($profile_picture) ? '../up/unk.png' : $profile_picture; ?>" id="profile_picture_preview" style="border-radius: 5px;">
                        </label>
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
                      <div class="col-md-6"><label class="labels">Nom et Prénom</label><input type="text" name="pere_nom_prenom" class="form-control" placeholder="Karim Ben" value="<?php echo $pere_nom_prenom; ?>"></div>
                      <div class="col-md-6"><label class="labels">Date de naissance</label><input type="date" name="pere_date_naissance" class="form-control" value="<?php echo $pere_date_naissance; ?>" ><br></div>
                      
                      <div class="col-md-6"><label class="labels">Ville</label><input type="text" name="pere_ville" class="form-control" placeholder="Rabat " value="<?php echo $pere_ville; ?>"></div>
                      <div class="col-md-6"><label class="labels">Identification</label><input type="text" name="pere_identification" class="form-control" placeholder="AA151914" value="<?php echo $pere_identification; ?>"><br></div>
                    
                      <div class="col-md-12"><label class="labels">Numéro de téléphone</label><input type="number" name="pere_tele" class="form-control" placeholder="0612131415" value="<?php echo $pere_tele; ?>"><br></div>
                      <div class="col-md-12"><label class="labels">Adresse e-mail</label><input type="email" name="pere_email" class="form-control" placeholder="xyz@gmail.com" value="<?php echo $pere_email; ?>"><br></div>
                    
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
                      <div class="col-md-6"><label class="labels">Nom et Prénom</label><input type="text" name="mere_nom_prenom" class="form-control" placeholder="Farah El " value="<?php echo $mere_nom_prenom; ?>"></div>
                      <div class="col-md-6"><label class="labels">Date de naissance</label><input type="date" name="mere_date_naissance" class="form-control" value="<?php echo $mere_date_naissance; ?>"><br></div>
                      
                      <div class="col-md-6"><label class="labels">Ville</label><input type="text" name="mere_ville" class="form-control" placeholder="Rabat " value="<?php echo $mere_ville; ?>"></div>
                      <div class="col-md-6"><label class="labels">Identification</label><input type="text" name="mere_identification" class="form-control" placeholder="AA151919" value="<?php echo $mere_identification; ?>"><br></div>
                    
                      <div class="col-md-12"><label class="labels">Numéro de téléphone</label><input type="number" name="mere_tele" class="form-control" placeholder="0612131415" value="<?php echo $mere_tele; ?>"><br></div>
                      <div class="col-md-12"><label class="labels">Adresse e-mail</label><input type="email" name="mere_email" class="form-control" placeholder="xyz@gmail.com" value="<?php echo $mere_email; ?>"><br></div>
                    
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
                            <input type="text" list="niveau" name="niveau_scolaire" class="form-control" placeholder="Hors-scolaire" value="<?php echo $niveau_scolaire; ?>" >
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
                              <option value="<?php echo $adaptation; ?>"><?php echo $adaptation; ?></option>
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
                      <div class="col-md-6"><label class="labels">Note 1er semestre</label><input type="text" class="form-control" name="note_semestre1" placeholder="x/20" value="<?php echo $note_semestre1; ?>"></div>
                      <div class="col-md-6"><label class="labels">Note 2eme semestre</label><input type="text" class="form-control" name="note_semestre2" placeholder="x/20" value="<?php echo $note_semestre2; ?>"><br></div> 
                      
                      <hr>
                      <h5 class="card-title"><span><i> - Collège</i></span></h5>
                      <div class="col-md-6"><label class="labels">1<sup><small>er</small></sup> Année Collège</label><input type="text" class="form-control" name="total1" placeholder="x/20" value="<?php echo $total1; ?>" ><br></div>
                      <div class="col-md-6"><label class="labels">2<sup><small>ème</small></sup> Année Collège</label><input type="text" class="form-control" name="total2" placeholder="x/20" value="<?php echo $total2; ?>" ><br></div>
                      <div class="col-md-12"><label class="labels">3<sup><small>ème </small></sup> Année Collège Régional</label><input type="text" class="form-control" name="total3" placeholder="x/20" value="<?php echo $total3; ?>" ><br></div>
                      <hr>

                      <h5 class="card-title"><span><i> - Lycée</i></span></h5>
                      <div class="col-md-12"><label class="labels">Tronc commun</label><input type="text" class="form-control" name="totaltronc" placeholder="x/20" value="<?php echo $totaltronc; ?>" ><br></div>
                      <div class="col-md-6"><label class="labels">1<sup><small>er</small></sup> Année Bac Régional<sup><small>er</small></sup></label><input type="text" class="form-control" name="total1bac" placeholder="x/20" value="<?php echo $total1bac; ?>" ><br></div>
                      <div class="col-md-6"><label class="labels">2<sup><small>ème</small></sup> Année Bac National</label><input type="text" class="form-control" name="total2bac" placeholder="x/20" value="<?php echo $total2bac; ?>" ><br></div>
                  
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
                        <input type="text" class="form-control" name="bourse" placeholder="Par mois" aria-label="Par mois" aria-describedby="basic-addon2" value="<?php echo $bourse; ?>">
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
                        <input type="text" list="Soutien" name="tutorat" class="form-control" placeholder="Soutien scolaire" value="<?php echo $tutorat; ?>">
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
                    
                    <div class="col-md-12"><label class="labels">Médicaments</label><input type="text" name="medicaments" list="medicaments" class="form-control" placeholder="DOLIPRANE" value="<?php echo $medicaments; ?>">
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
                        <select class="form-control" name="etat_de_sante" placeholder="Male" value="<?php echo $etat_de_sante; ?>">
                            <option value="<?php echo $etat_de_sante; ?>"><?php echo $etat_de_sante; ?></option>
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
                      <div class="col-md-12"><label class="labels">Description</label><textarea class="form-control" name="sante_description" style="height: 100px" placeholder="Optionnel*" value="<?php echo $sante_description; ?>"></textarea><br></div>
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