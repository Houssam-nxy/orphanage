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



// Handle form submission to save data and profile image
if (isset($_POST["submit"])) {
  // Retrieve form data
  $fullName = mysqli_real_escape_string($conn, $_POST["fullName"]);
  $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);

  // Insert data into the database
  $query = "UPDATE users SET name = '$fullName', email = '$email', mobile = '$phone' WHERE uid = {$_SESSION['user_id']}";
  $result = mysqli_query($conn, $query);

  if (!$result) {
    // Handle the error, such as displaying an error message
    $error_message1 = "Error updating profile: " . mysqli_error($conn);
$error_message10 = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-1"></i>
                    ' . $error_message1 . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
  } else {
    // Data saved successfully, you can redirect to the profile page or display a success message

    // Handle profile image upload
    if ($_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = '../up/'; // Create a directory for uploaded images
      $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);

      // Move the uploaded image to the specified directory
      if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
        // Update the database to store the image path
        $imagePath = mysqli_real_escape_string($conn, $uploadFile);
        $imageQuery = "UPDATE users SET profile_image_users = '$imagePath' WHERE uid = {$_SESSION['user_id']}";
        $imageResult = mysqli_query($conn, $imageQuery);

        if (!$imageResult) {
            // Handle the error, such as displaying an error message
            $error_message2 = "Error updating profile image: " . mysqli_error($conn);
            $error_message20 = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            ' . $error_message2 . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        }
      } else {
        // Handle the error, such as displaying an error message
        $error_message30 = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <i class="bi bi-exclamation-octagon me-1"></i>
                                Error uploading profile image.
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
      }
    }

    header("Location: users-profile");
    exit;
  }
}

if (isset($_POST["delete"])) {
  $deleteQuery = "DELETE FROM users WHERE uid = {$_SESSION['user_id']}";
  $deleteResult = mysqli_query($conn, $deleteQuery);

  if ($deleteResult) {
      session_destroy();
      header("Location: ../login");
      exit;
  } else {
      // Handle the error, such as displaying an error message
      $error_message_delete = "Erreur lors de la suppression du compte: " . mysqli_error($conn);
  }
}

if (isset($_POST["changePassword"])) {
  $currentPassword = mysqli_real_escape_string($conn, $_POST["currentPassword"]);
  $newPassword = mysqli_real_escape_string($conn, $_POST["newPassword"]);
  $renewPassword = mysqli_real_escape_string($conn, $_POST["renewPassword"]);

  // Fetch the current password hash from the database
  $query = "SELECT password FROM users WHERE uid = {$_SESSION['user_id']}";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  // Verify the current password
  if (password_verify($currentPassword, $row['password'])) {
    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the database with the new hashed password
    $passwordQuery = "UPDATE users SET password = '$hashedPassword' WHERE uid = {$_SESSION['user_id']}";
    $passwordResult = mysqli_query($conn, $passwordQuery);

    if (!$passwordResult) {
      // Handle the error, such as displaying an error message
      $error_message4 = "Error updating password: " . mysqli_error($conn);
    } else {
      // Password changed successfully, you can redirect or display a success message
      $success_message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              <i class="bi bi-check-circle me-1"></i>
                              Le mot de passe a été changé avec succès
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
      header("Location: users-profile");
      exit;
    }
  } else {
    // Handle the error, such as setting an error message
    $error_message50 = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <i class="bi bi-exclamation-octagon me-1"></i>
                            Mot de passe actuel incorrect.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
  }
}

// Fetch user data from the database for displaying in the profile overview
$query = "SELECT * FROM users WHERE uid = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nom de société / Profil </title>
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


</head>

<body>

<?php include 'navbar.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index">Accueil</a></li>
          <li class="breadcrumb-item active">Profil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">

    <?php if (isset($error_message10)): ?>
      <?php echo $error_message10; ?>
    <?php endif; ?>

    <?php if (isset($error_message20)): ?>
      <?php echo $error_message20; ?>
    <?php endif; ?>

    <?php if (isset($error_message30)): ?>
      <?php echo $error_message30; ?>
    <?php endif; ?>

    <?php if (isset($error_message4)): ?>
      <?php echo $error_message4; ?>
    <?php endif; ?>

    <?php if (isset($error_message50)): ?>
      <?php echo $error_message50; ?>
    <?php endif; ?> 

    <?php if (isset($success_message)): ?>
      <?php echo $success_message; ?>
    <?php endif; ?> 



      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center"><br>

              <img src="<?php echo empty($row['profile_image_users']) ? '../up/user.png' : $row['profile_image_users']; ?>" alt="Profile" class="rounded-circle"><br>
              <h2>ADMIN</h2>
              <h6>PÉDAGOGIQUE</h6>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Aperçu</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le profil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Modifier le mot de passe</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
              
                  <h5 class="card-title">Détails du profil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom et prénom</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Téléphone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['mobile']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">E-mail</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['email']; ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="" method="POST" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Photo du profil</label>
                    <div class="col-md-8 col-lg-9">
                    <label for="profile_picture">
                        <img name="profileImage" class="img-rounded mt-30" width="150px" src="<?php echo empty($row['profile_image_users']) ? '../up/user.png' : $row['profile_image_users']; ?>" id="profile_picture_preview" style="border-radius: 3px;">
                    </label>
                    <input class="form-control" type="file" name="profileImage" id="profile_picture" style="display: none;">

                    </div>
                  </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom et prénom</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $row['name']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Téléphone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $row['mobile']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">E-mail</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="<?php echo $row['email']; ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <input type="button" class="btn btn-danger" value="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" />
                      <input type="submit" class="btn btn-primary" value="Sauvegarder" name="submit" />

                      <div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Confirmation de suppression de compte</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <!--<div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirmez votre mot de passe pour supprimer le compte</label>
                                <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" required>
                              </div>
                              <div class="text-danger" id="passwordMismatchMessage" style="display: none;">
                                Mot de passe incorrect. Veuillez réessayer.
                              </div>-->
                              <div class="text-muted">
                                <small>Attention: La suppression du compte est irréversible.</small>
                              </div>
                            </div>
                            <div class="modal-footer text-center">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                              <input type="submit" name="delete" class="btn btn-danger" value="Supprimer" onclick="confirmDelete();" />
                            </div>
                          </div>
                        </div>
                      </div>

                      <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));

                        deleteConfirmationModal._element.addEventListener('show.bs.modal', function() {
                          document.getElementById('passwordMismatchMessage').style.display = 'none';
                        });
                      });

                      function confirmDelete() {
                        const confirmPassword = document.getElementById('confirmPassword').value;
                        const predefinedPassword = "<?php echo htmlspecialchars($row['password'], ENT_QUOTES, 'UTF-8'); ?>";

                        if (confirmPassword === predefinedPassword) {
                          document.getElementById('passwordMismatchMessage').style.display = 'none';
                          document.getElementById('deleteConfirmationModal').modal('hide');
                        } else {
                          document.getElementById('passwordMismatchMessage').style.display = 'block';
                        }
                      }
                      </script>



                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>


                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="" method="POST">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="currentPassword" type="text" class="form-control" id="currentPassword" value="" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newPassword" type="text" class="form-control" id="newPassword" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmer le nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewPassword" type="text" class="form-control" id="renewPassword" required>
                      </div>
                    </div>

                    <div class="text-center">
                      <input type="submit" class="btn btn-primary" name="changePassword" value="Modifier le mot de passe">
                    </div>
                  </form><!-- End Change Password Form -->
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include 'footer.php'; ?>

</body>

</html>