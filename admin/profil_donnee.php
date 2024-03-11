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



if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Query the database for the beneficiary based on their ID
  $beneficiary_query = "SELECT * FROM profil WHERE id = $id";
  $result = mysqli_query($conn, $beneficiary_query);
  
  if (mysqli_num_rows($result) > 0) {
    // Fetch the beneficiary details
    $row = mysqli_fetch_assoc($result); // Fetch the row

    $genre = $row['genre'];
    $name = $row['nom'];
    $prenom = $row['prenom'];
    $naissance = $row['naissance'];
    $ville = $row['ville'];
    $provenance = $row['nam_du_centre'];
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
    $profile_picture = $row['profile_picture'];


  } else {
    echo "<script>alert('Bénéficiaire introuvable.');</script>";
    header("Location: list");
    exit();
  }
} else {
  echo "<script>alert('ID de bénéficiaire non spécifié.');</script>";
  exit();
}



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check which action was selected
  if (isset($_POST['action'])) {
      $action = $_POST['action'];
      switch ($action) {
          case 'ARCHIVER':
              // Archive the profile
              // Insert the profile data into the archives table
              $archive_query = "INSERT INTO archives (genre, nom, prenom, naissance, ville, provenance, arrivee, chambre, cartid, name_description, pere_nom_prenom, pere_date_naissance, pere_ville, pere_tele, pere_email, pere_identification, mere_nom_prenom, mere_date_naissance, mere_ville, mere_tele, mere_email, mere_identification, nom_ecole, niveau_scolaire, adaptation, note_semestre1, note_semestre2, total1, total2, total3, totaltronc, total1bac, total2bac, bourse, tutorat, medicaments, etat_de_sante, sante_description, profile_picture) 
              VALUES ('$genre', '$name', '$prenom', '$naissance', '$ville', '$provenance', '$arrivee', '$chambre', '$cartid', '$name_description', '$pere_nom_prenom', '$pere_date_naissance', '$pere_ville', '$pere_tele', '$pere_email', '$pere_identification', '$mere_nom_prenom', '$mere_date_naissance', '$mere_ville', '$mere_tele', '$mere_email', '$mere_identification', '$nom_ecole', '$niveau_scolaire', '$adaptation', '$note_semestre1', '$note_semestre2', '$total1', '$total2', '$total3', '$totaltronc', '$total1bac', '$total2bac', '$bourse', '$tutorat', '$medicaments', '$etat_de_sante', '$sante_description', '$profile_picture')";

              if (mysqli_query($conn, $archive_query)) {
                  // Archive successfully inserted, now you can delete the original profile
                  $remove_query = "DELETE FROM profil WHERE id='$id'";
                  if (mysqli_query($conn, $remove_query)) {
                      $success_message = ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                                              <i class="bi bi-check-circle me-1"></i>
                                                Profil archivé avec succès!
                                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                  } else {
                      $error_message = "Erreur lors de l\\'archivage du profil: " . mysqli_error($conn);
                      $error_message1 = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="bi bi-exclamation-octagon me-1"></i>
                                            <?php echo $error_message; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                  }
              } else {
                $error_message = "Erreur lors de l\\'archivage du profil: " . mysqli_error($conn);
                $error_message1 = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      <i class="bi bi-exclamation-octagon me-1"></i>
                                      <?php echo $error_message; ?>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
              }
              break;
          case 'MODIFIER':
              // Redirect to the modify beneficiary page with the ID parameter
              if (isset($_GET['id'])) {
                  $id = $_GET['id'];
                  echo "<script>window.location.href='modifier?id=$id';</script>";
              } else {
                  echo "L'identifiant du bénéficiaire est manquant.";
              }
              break;
          case 'SUPPRIMER':
              // Delete the profile logic here
              $remove_query = "DELETE FROM profil WHERE id='$id'";
              if (mysqli_query($conn, $remove_query)) {
                  // Delete the profile picture file
                  $profile_picture = $beneficiary['profile_picture'];
                  unlink("" . $profile_picture);
                  echo "<script>alert('Bénéficiaire supprimé avec succès!');</script>";
                  echo "<script>window.location.href='index';</script>";
              } else {
                  echo "<script>alert('Erreur lors de la suppression du profil.');</script>";
              }
              break;
          default:
              // Handle any other actions or errors here
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
  label{
    text-align: right;
    font-weight: bold;
  }
  p {
    margin-top: 1.5%;
    margin-bottom: 1rem;
  }       
</style>

<?php include 'navbar.php';?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Données</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item">Données</li>
          <li class="breadcrumb-item active">Données</li>
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
          <form action="" method="post" enctype="multipart/form-data">

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Genre</label>
              <div class="col-sm-8">
                <p><?php echo $genre; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Nom</label>
              <div class="col-sm-8">
                <p><?php echo $name; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Prénom</label>
              <div class="col-sm-8">
                <p><?php echo $prenom; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Naissance</label>
              <div class="col-sm-8">
                <p><?php echo $naissance; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Identification</label>
              <div class="col-sm-8">
                <p><?php echo $cartid; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Ville</label>
              <div class="col-sm-8">
                <p><?php echo $ville; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Provenance</label>
              <div class="col-sm-8">
                <p><?php echo $provenance; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label">Arrivée</label>
              <div class="col-sm-8">
                <p><?php echo $arrivee; ?></p>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-4 col-form-label" >Chambre</label>
              <div class="col-sm-8">
                <p><?php echo $chambre; ?></p>
              </div>
            </div>


            <div class="row mb-3">
              <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <p><a href="#" data-bs-toggle="modal" data-bs-target="#verticalycentered" style="text-decoration: none;color: Black;"><i>Cliquez pour voir la description</i></a></p>

                <div class="modal fade" id="verticalycentered" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Description</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <?php echo $name_description; ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                      </div>
                    </div>
                  </div>
                </div><!-- End Vertically centered Modal-->

              </div>
            </div>


            


            
        </div>
      </div>


      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Les résultats de la progression académique pour le bénéficiaire</h5>

          <!-- Line Chart -->
          <div id="lineChart"></div>

          <!-- Line Chart -->
          <div id="lineChart"></div>

          <script>
          document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#lineChart"), {
              series: [{
                name: "1er Semestre / 2eme Semestre",
                data: [<?php echo $note_semestre1; ?>, <?php echo $note_semestre2; ?>]
              }],
              chart: {
                height: 350,
                type: 'line',
                zoom: {
                  enabled: false
                }
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'straight'
              },
              grid: {
                row: {
                  colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                  opacity: 0.5
                },
              },
              xaxis: {
                categories: ['1er Semestre', '2eme Semestre'],
              }
            }).render();
          });
        </script>
          <!-- End Line Chart -->



        </div>
      </div>


      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Les résultats de la progression académique pour le bénéficiaire</h5>

          <!-- Line Chart -->
          <div id="lineChart_n"></div>

          <!-- Line Chart -->
          <div id="lineChart_n"></div>

          <script>
          document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#lineChart_n"), {
              series: [{
                name: "1er Semestre / 2eme Semestre",
                data: [<?php echo $total1; ?>, <?php echo $total2; ?>, <?php echo $total3; ?>, <?php echo $totaltronc; ?>, <?php echo $total1bac; ?>, <?php echo $total2bac; ?>,]
              }],
              chart: {
                height: 350,
                type: 'line',
                zoom: {
                  enabled: false
                }
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'straight'
              },
              grid: {
                row: {
                  colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                  opacity: 0.5
                },
              },
              xaxis: {
                categories: ['1er Année Collège', '2ème Année Collège', '3ème Année Collège', 'Tronc commun', '1er Année Bac', '2ème Année Bac'],
              }
            }).render();
          });
        </script>
          <!-- End Line Chart -->



        </div>
      </div>

      <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class='bx bxs-cog' ></i> paramètres</h5>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_n">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_n" aria-expanded="false" aria-controls="collapse_n">
                  paramètres
                  </button>
                </h2>
                <div id="collapse_n" class="accordion-collapse collapse" aria-labelledby="heading_n" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    
                  <div class="row mt-12">
                      <div class="col-md-12">
                          <label class="labels">paramètres<br></label>
                          <div class="row mb-3">
                              <div class="col-sm-8">
                                  <form action="" method="post" enctype="multipart/form-data">
                                      <select class="form-select" aria-label="Default select example" name="action">

                                          <option selected>Menus de paramètres</option>
                                          <option value="ARCHIVER">ARCHIVER</option>
                                          <option value="MODIFIER">MODIFIER</option>
                                          <option value="SUPPRIMER">SUPPRIMER</option>
                                      </select>
                                      <br>
                                      <input type="submit" class="btn btn-primary" value="Appliquer">
                                  </form>
                              </div>
                          </div>
                          <br>
                      </div>
                  </div>

                  </div>
                </div>
              </div>
            
            </div><!-- End Default Accordion Example -->
          </div>
        </div>

    </div>

      <div class="col-lg-6">


        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class='bx bxs-download' ></i> TÉLÉCHARGEMENT</h5>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading_tele">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_tele" aria-expanded="false" aria-controls="collapse_tele">
                    Microsoft 
                  </button>
                </h2>
                <div id="collapse_tele" class="accordion-collapse collapse" aria-labelledby="heading_tele" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <button type="button" class="btn btn-primary" id="downloadButton" onclick="downloadBeneficiary(<?php echo $id; ?>)"><i class="bi bi-folder"></i> Word</button>
                  
                  </div>
                </div>
              </div>
            
            </div><!-- End Default Accordion Example -->
          </div>
        </div>

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
                            <img class="img-rounded mt-5" width="200px" src="<?php echo empty($profile_picture) ? '../up/unk.png' : $profile_picture; ?>" id="profile_picture_preview">
                        </label>
                        <br><br>
                        <span class="font-weight-bold">Bénéficiaire</span>
                        <span class="text-black-50">Nom de société</span>
                    </div>

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
                      <div class="col-md-6"><label class="labels">Nom et Prénom</label><p><?php echo $pere_nom_prenom; ?></p></div>
                      <div class="col-md-6"><label class="labels">Date de naissance</label><p><?php echo $pere_date_naissance; ?><p><br></div>
                      
                      <div class="col-md-6"><label class="labels">Ville</label><p><?php echo $pere_ville; ?></p></div>
                      <div class="col-md-6"><label class="labels">Identification</label><p><?php echo $pere_identification; ?></p><br></div>
                    
                      <div class="col-md-12"><label class="labels">Numéro de téléphone</label><p><?php echo $pere_tele; ?></p><br></div>
                      <div class="col-md-12"><label class="labels">Adresse e-mail</label><p><?php echo $pere_email; ?></p><br></div>
                    
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
                      <div class="col-md-6"><label class="labels">Nom et Prénom</label><p><?php echo $mere_nom_prenom; ?></p></div>
                      <div class="col-md-6"><label class="labels">Date de naissance</label><p><?php echo $mere_date_naissance; ?></p><br></div>
                      
                      <div class="col-md-6"><label class="labels">Ville</label><p><?php echo $mere_ville; ?></p></div>
                      <div class="col-md-6"><label class="labels">Identification</label><p><?php echo $mere_identification; ?></p><br></div>
                    
                      <div class="col-md-12"><label class="labels">Numéro de téléphone</label><p><?php echo $mere_tele; ?></p><br></div>
                      <div class="col-md-12"><label class="labels">Adresse e-mail</label><p><?php echo $mere_email; ?></p><br></div>
                    
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
                        <div class="col-md-6"><label class="labels">Établissement</label><p><?php echo $nom_ecole; ?></p></div>
                        <div class="col-md-6"><label class="labels">Niveau</label><p><?php echo $niveau_scolaire; ?></p><br></div>
                        <div class="col-md-12"><label class="labels">Adaptation</label><p><?php echo $adaptation; ?></p></div>
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
                      <div class="col-md-6"><label class="labels">Note 1er semestre</label><p><?php echo $note_semestre1; ?>/20</p></div>
                      <div class="col-md-6"><label class="labels">Note 2eme semestre</label><p><?php echo $note_semestre2; ?>/20</p><br></div>                   
                      <hr>

                      <h5 class="card-title"><span><i> - Collège</i></span></h5>

                      <div class="col-md-6"><label class="labels">1<sup><small>er</small></sup> Année Collège</label><p><?php echo $total1; ?>/20</p><br></div>
                      <div class="col-md-6"><label class="labels">2<sup><small>ème</small></sup> Année Collège</label><p><?php echo $total2; ?>/20</p><br></div>
                      <div class="col-md-12"><label class="labels">3<sup><small>ème </small></sup> Année Collège Régional</label><p><?php echo $total3; ?>/20</p><br></div>
                      <hr>

                      <h5 class="card-title"><span><i> - Lycée</i></span></h5>
                    
                      <div class="col-md-12"><label class="labels">Tronc commun</label><p><?php echo $totaltronc; ?>/20</p><br></div>
                      <div class="col-md-6"><label class="labels" style="text-align: left;">1<sup><small>er</small></sup> Année Bac Régional<sup><small>er</small></sup></label><p><?php echo $total1bac; ?>/20</p><br></div>
                      <div class="col-md-6"><label class="labels" style="text-align: left;">2<sup><small>ème</small></sup> Année Bac National</label><p><?php echo $total2bac; ?>/20</p><br></div>
                    
                  
                  
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
                      <p><?php echo $bourse; ?> DH/Mois</p>
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
                    
                    <div class="col-md-12"><label class="labels">Soutien scolaire</label><p><?php echo $tutorat; ?></p></div>

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
                    
                    <div class="col-md-12"><label class="labels">Médicaments</label><p><?php echo $medicaments; ?></p></div>

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
                      <p><?php echo $etat_de_sante; ?></p>
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
                      <div class="col-md-12"><label class="labels">Description</label><p><?php echo $sante_description; ?></p><br></div>
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





<script>
function downloadBeneficiary(id) {
  // Redirect to the download script with the beneficiary ID as a query parameter
  window.location.href = 'download?id=' + id;
}
function downloadBeneficiaryexcel(id) {
  // Redirect to the download script with the beneficiary ID as a query parameter
  window.location.href = 'excel?id=' + id;
}
</script>


</body>

</html>