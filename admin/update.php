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


if (isset($_GET['id'])) {
    $record_id = $_GET['id'];

    
    if (!is_numeric($record_id) || $record_id <= 0) {
        echo "<script>alert('Identifiant de bénéficiaire invalide!');</script>";
        echo "<script>window.location.href='index';</script>";
        exit;
    }

    // ID
    $select_query = "SELECT * FROM profil WHERE id='$record_id'";
    $result = mysqli_query($conn, $select_query);

    // Check
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
    } else {
        echo "<script>alert('Fiche bénéficiaire introuvable !');</script>";
        echo "<script>window.location.href='index';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID du bénéficiaire non fourni !');</script>";
    echo "<script>window.location.href='index';</script>";
    exit;
}

if (isset($_POST['submit'])) {

    // injection
    function escape_input($input) {
        global $conn;
        return mysqli_real_escape_string($conn, $input);
    }

    // data
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

     
    $upload_dir = "../up/";
    $profile_picture = "";
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $profile_picture = $upload_dir . uniqid('img_') . '.' . $file_ext;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    // insert
    $update_query = "UPDATE profil SET genre = '$genre', nom = '$name', prenom = '$prenom', naissance = '$naissance', ville = '$ville', provenance = '$provenance', arrivee = '$arrivee', chambre = '$chambre', cartid = '$cartid', name_description = '$name_description', pere_nom_prenom = '$pere_nom_prenom', pere_date_naissance = '$pere_date_naissance', pere_ville = '$pere_ville', pere_tele = '$pere_tele', pere_email = '$pere_email', pere_identification = '$pere_identification', mere_nom_prenom = '$mere_nom_prenom', mere_date_naissance = '$mere_date_naissance', mere_ville = '$mere_ville', mere_tele = '$mere_tele', mere_email = '$mere_email', mere_identification = '$mere_identification', nom_ecole = '$nom_ecole', niveau_scolaire = '$niveau_scolaire', adaptation = '$adaptation', note_semestre1 = '$note_semestre1', note_semestre2 = '$note_semestre2', total1 = '$total1', total2 = '$total2', total3 = '$total3', totaltronc = '$totaltronc', total1bac = '$total1bac', total2bac = '$total2bac', bourse = '$bourse', tutorat = '$tutorat', medicaments = '$medicaments', etat_de_sante = '$etat_de_sante', sante_description = '$sante_description', profile_picture = '$profile_picture' WHERE id = $record_id";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Les données ont été modifiées avec succès');</script>";                      
        echo "<script>window.location.href='index';</script>";

         
        unset($_SESSION['record_id']);
    } else {
        $error_message = "Erreur lors de la modification des données: " . mysqli_error($conn);
        echo "<script>alert(".$error_message.");</script>";  
    }
}

?>

