<?php

require_once '../vendor/autoload.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query the database for the beneficiary based on their ID
    include('conn.php');
    $beneficiary_query = "SELECT * FROM profil WHERE id = $id";
    $result = mysqli_query($conn, $beneficiary_query);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the beneficiary details
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
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
        $bourse = $row['bourse'];
        $tutorat = $row['tutorat'];
        $medicaments = $row['medicaments'];
        $etat_de_sante = $row['etat_de_sante'];
        $sante_description = $row['sante_description'];
        $profile_picture = $row['profile_picture'];
        

        $beneficiaryName = $row['nom'];

        // Create a new Word document
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Add a section to the document
        $section = $phpWord->addSection();

        // Create styles for formatting
        $headerStyle = new \PhpOffice\PhpWord\Style\Font();
        $headerStyle->setName('Arial');
        $headerStyle->setSize(16);
        $headerStyle->setBold(true);

        $bodyTextStyle = new \PhpOffice\PhpWord\Style\Font();
        $bodyTextStyle->setName('Arial');
        $bodyTextStyle->setSize(12);




        #----------------------------------------


        $profilePicturePath = $row['profile_picture'];


        // Create a table to layout the images
        $imageTable = $section->addTable();
        $imageTable->addRow();
        $imageTable->addCell(4000)->addImage($profilePicturePath, array('width' => 100, 'height' => 100, 'align' => 'left'));
        $imageTable->addCell(4000)->addImage('../assets/img/logo1.png', array('width' => 150, 'height' => 100, 'align' => 'right'));

        // Add spacing between the images
        $section->addTextBreak(2);

        // Add other text
        $section->addText("",);
        $section->addText("",);
        $section->addText(" \xC2\xA0❝\xC2\xA0", array('name' => 'Arial', 'size' => 24, 'bold' => true, 'color' => '000000'), array('align' => 'center'));
        $section->addText("Bénéficiaire", $headerStyle, array('align' => 'center'));
        $section->addText("Nom de société", $headerStyle, array('align' => 'center'));
        $section->addText(" \xC2\xA0❞\xC2\xA0", array('name' => 'Arial', 'size' => 24, 'bold' => true, 'color' => '000000'), array('align' => 'center'));


        







        #----------------------------------------

        $section->addText("",);
        $section->addText("",);
        $section->addText(" • Données personnelles : ", array('align' => 'left'));
        $section->addText("",);

        $table = $section->addTable();

        // Set common style for all cells in the table
        $cellStyle = array(
            'borderColor' => '000000', // Set black border color
            'borderSize'  => 1,        // Set border size
        );

        // First row with centered text

        $data = array(
            "ID"             => $id,
            "Nom et Prénom"  => $name . ' ' . $prenom,
            "Genre"          => $genre,
            "Âge"            => $naissance,
            "Ville"          => $ville,
            "Provenance"     => $provenance,
            "Arrivée"        => $arrivee,
            "Chambre"        => $chambre,
            "Identification" => $cartid,
        );

        foreach ($data as $item => $value) {
            $table->addRow();
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($item);
            
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($value);
        }

        #------------------------------------------


        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText(" • Informations sur le père : ", array('align' => 'left'));
        $section->addText("",);

        $table = $section->addTable();

        // Set common style for all cells in the table
        $cellStyle = array(
            'borderColor' => '000000', // Set black border color
            'borderSize'  => 1,        // Set border size
        );

        // Add your data to the table
        $data = array(
            "Nom et Prénom"          => $pere_nom_prenom,
            "Identification"         => $pere_identification,
            "Date de naissance"      => $pere_date_naissance,
            "Ville"                  => $pere_ville,
            "Numéro de téléphone"    => $pere_tele,
            "Adresse e-mail"         => $pere_email,
        );

        foreach ($data as $item => $value) {
            $table->addRow();
            $cell = $table->addCell(4000, $cellStyle); 
            $cell->addText($item);
            
            $cell = $table->addCell(4000, $cellStyle); 
            $cell->addText($value);
        }


        #------------------------------------------

        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText(" • Informations sur la mère : ", array('align' => 'left'));
        $section->addText("",);

        $table = $section->addTable();

        // Set common style for all cells in the table
        $cellStyle = array(
            'borderColor' => '000000', // Set black border color
            'borderSize'  => 1,        // Set border size
        );

        // Add data for Nom et Prénom
        $data = array(
            "Nom et Prénom"          => $mere_nom_prenom,
            "Identification"         => $mere_identification,
            "Date de naissance"      => $mere_date_naissance,
            "Ville"                  => $pere_ville, // Note: It seems there might be a typo here, please verify the variable
            "Numéro de téléphone"    => $mere_tele,
            "Adresse e-mail"         => $mere_email,
        );

        foreach ($data as $item => $value) {
            $table->addRow();
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($item);
            
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($value);
        }


        #------------------------------------------

        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText(" • Informations Pédagogique : ", array('align' => 'left'));
        $section->addText("",);
        
        $table = $section->addTable();
        
        // Set common style for all cells in the table
        $cellStyle = array(
            'borderColor' => '000000', // Set black border color
            'borderSize'  => 1,        // Set border size
        );
        
        // First row with centered text
        
        $data = array(
            "Établissement"     => $nom_ecole,
            "Niveau"            => $niveau_scolaire,
            "Adaptation"        => $adaptation,
            "Note 1er semestre" => $note_semestre1,
            "Note 2eme semestre"=> $note_semestre2,
            "Résultat"          => $total,
            "Bourse"            => $bourse,
            "Soutien scolaire"  => $tutorat,
        );
        
        foreach ($data as $item => $value) {
            $table->addRow();
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($item);
        
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($value);
        }
        



        #------------------------------------------


        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText(" • Information médicale : ", array('align' => 'left'));
        $section->addText("",);
        
        $table = $section->addTable();
        
        // Set common style for all cells in the table
        $cellStyle = array(
            'borderColor' => '000000', // Set black border color
            'borderSize'  => 1,        // Set border size
        );
        
        // First row with centered text
        
        $data = array(
            "Médicaments"        => $medicaments,
            "Condition médicale" => $etat_de_sante,
            
        );
        
        foreach ($data as $item => $value) {
            $table->addRow();
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($item);
        
            $cell = $table->addCell(4000, $cellStyle); // Adjust width as needed
            $cell->addText($value);
        }


        #------------------------------------------


        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("Descriptif médical ", $headerStyle, array('align' => 'center'));
        $section->addText("");
        $section->addText("");
        $section->addText($name_description, array('align' => 'left'));
        $section->addText("",);
        $section->addText("",);


        #------------------------------------------

        $section->addText("",);
        $section->addText("------------------------------------------------", $headerStyle, array('align' => 'center'));
        $section->addText("",);

        #------------------------------------------


        $section->addText("",);
        $section->addText("",);
        $section->addText("",);
        $section->addText("Description de $name $prenom", $headerStyle, array('align' => 'center'));
        $section->addText("");
        $section->addText("");
        $section->addText($sante_description, array('align' => 'left'));



        #------------------------------------------

        // Save the document
        $filename = $beneficiaryName . "_profil.docx";
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filename);

        // Force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));

        ob_clean();
        flush();
        readfile($filename);
        unlink($filename);
        exit();
    } else {
        echo "<script>alert('Bénéficiaire introuvable.');</script>";
    }
} else {
    echo "<script>alert('ID de bénéficiaire non spécifié.');</script>";
}
?>
