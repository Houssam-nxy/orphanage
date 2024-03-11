<?php

include('conn.php');





$query = "SELECT * FROM users WHERE uid = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?> 
 
 <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index" class="logo d-flex align-items-center">
        <img src="../assets/img/logo1.png" alt="">
        <span class="d-none d-lg-block">NXY</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!--<div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!--<li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li> End Search Icon-->

    

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo empty($row['profile_image_users']) ? '../up/user.png' : $row['profile_image_users']; ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2" style="text-transform: uppercase;"><?php echo $row['name']; ?> </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6 style="text-transform: uppercase;"><?php echo $row['name']; ?></h6>
              <span>PÉDAGOGIQUE</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!--<li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Besoin d'aide?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>-->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile">
                <i class='bx bx-face'></i>
                <span>Paramètres et confidentialité</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Se déconnecter</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">GESTION</li>
    <br>

      <li class="nav-item">
        <a class="nav-link collapsed" href="index">
          <i class="bi bi-grid"></i>
          <span>Tableau de bord</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-add"></i><span>Bénéficiaire</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="profil">
              <i class="bi bi-circle"></i><span>Ajouter</span>
            </a>
          </li>
          <li>
            <a href="list">
              <i class="bi bi-circle"></i><span>Liste</span>
            </a>
          </li>
          
          
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#Remarques-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Remarques</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="Remarques-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="forms-layouts">
              <i class="bi bi-circle"></i><span>Rédiger un article</span>
            </a>
          </li>
          <li>
            <a href="message">
              <i class="bi bi-circle"></i><span>Articles</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#visits-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bx-calendar"></i><span>Visites</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="visits-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="visits">
              <i class="bi bi-circle"></i><span>Ajouter</span>
            </a>
          </li>
          <li>
            <a href="list_visitor">
              <i class="bi bi-circle"></i><span>Liste</span>
            </a>
          </li>
          
          
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Graphiques</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="effectif">
              <i class="bi bi-circle"></i><span>Effectif</span>
            </a>
          </li>
          <li>
            <a href="niveau">
              <i class="bi bi-circle"></i><span>Éducation</span>
            </a>
          </li>
          <li>
            <a href="total">
              <i class="bi bi-circle"></i><span>Évaluation</span>
            </a>
          </li>
          <li>
            <a href="resultat">
              <i class="bi bi-circle"></i><span>Résultat</span>
            </a>
          </li>
          <li>
            <a href="sante">
              <i class="bi bi-circle"></i><span>Santé</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="folders">
          <i class='bx bx-folder'></i>
          <span>Dossiers</span>
        </a>
      </li><!-- End chambres Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="chambre">
          <i class='bx bx-bed'></i>
          <span>Chambres</span>
        </a>
      </li><!-- End chambres Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="success">
          <i class='bx bx-filter-alt'></i>
          <span>Succès</span>
        </a>
      </li><!-- End Réussite Page Nav -->

      <br>

      <li class="nav-heading">Paramètres</li>


      <li class="nav-item">
        <a class="nav-link collapsed" href="archives">
          <i class="bi bi-archive"></i>
          <span>Archives</span>
        </a>
      </li><!-- End archives Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users">
          <i class='bi bi-person'></i>
          <span>Accès</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile">
          <i class='bx bx-face'></i>
          <span>Profil</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="urgent">
          <i class="bi bi-exclamation-triangle"></i>
          <span>Urgent</span>
        </a>
      </li><!-- End urgent Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="register">
          <i class='bx bx-user-plus'></i>
          <span>Compte</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <!--<li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li> End F.A.Q Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->