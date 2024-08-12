<?php

session_start();

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

require('../function.php');

// Periksa koneksi database
if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

if (isset($_SESSION['notification'])) {
  $notification = $_SESSION['notification'];
  $type = $notification['type'];
  $message = $notification['message'];

  // Display Bootstrap alert
  echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
      $message
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";

  // Clear the notification from the session
  unset($_SESSION['notification']);
}


// Ambil ID Pengguna dari sesi
$idPengguna = intval($_SESSION['user_id']);

// Query untuk mengambil data kelas yang diikuti oleh pengguna
$query = "SELECT username, photo FROM users WHERE id_user = $idPengguna";

$result = $conn->query($query);

if (!$result) {
  die("Error: " . $conn->error);
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Setting</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="../assets/favicon.ico">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

    :root {
      --header-height: 3rem;
      --nav-width: 68px;
      --first-color: #4723D9;
      --first-color-light: #AFA5D9;
      --white-color: #F7F6FB;
      --body-font: 'Nunito', sans-serif;
      --normal-font-size: 1rem;
      --z-fixed: 100
    }

    *,
    ::before,
    ::after {
      box-sizing: border-box
    }

    body {
      position: relative;
      margin: var(--header-height) 0 0 0;
      padding: 0 1rem;
      font-family: var(--body-font);
      font-size: var(--normal-font-size);
      transition: .5s
    }

    a {
      text-decoration: none
    }

    .header {
      width: 100%;
      height: var(--header-height);
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem;
      background-color: var(--white-color);
      z-index: var(--z-fixed);
      transition: .5s
    }

    .header_toggle {
      color: var(--first-color);
      font-size: 1.5rem;
      cursor: pointer
    }

    .header_img {
      width: 35px;
      height: 35px;
      display: flex;
      justify-content: center;
      border-radius: 50%;
      overflow: hidden
    }

    .header_img img {
      width: 40px
    }

    .l-navbar {
      position: fixed;
      top: 0;
      left: -30%;
      width: var(--nav-width);
      height: 100vh;
      background-color: var(--first-color);
      padding: .5rem 1rem 0 0;
      transition: .5s;
      z-index: var(--z-fixed)
    }

    .nav {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow: hidden
    }

    .nav_logo,
    .nav_link {
      display: grid;
      grid-template-columns: max-content max-content;
      align-items: center;
      column-gap: 1rem;
      padding: .5rem 0 .5rem 1.5rem
    }

    .nav_logo {
      margin-bottom: 2rem
    }

    .nav_logo-icon {
      font-size: 1.25rem;
      color: var(--white-color)
    }

    .nav_logo-name {
      color: var(--white-color);
      font-weight: 700
    }

    .nav_link {
      position: relative;
      color: var(--first-color-light);
      margin-bottom: 1.5rem;
      transition: .3s
    }

    .nav_link:hover {
      color: var(--white-color)
    }

    .nav_icon {
      font-size: 1.25rem
    }

    .show {
      left: 0
    }

    .body-pd {
      padding-left: calc(var(--nav-width) + 1rem)
    }

    .active {
      color: var(--white-color)
    }

    .active::before {
      content: '';
      position: absolute;
      left: 0;
      width: 2px;
      height: 32px;
      background-color: var(--white-color)
    }

    .height-100 {
      height: 100vh
    }

    .nav-link.active {
      border-bottom: 2px solid #007bff !important;
    }

    .modal {
      z-index: 1051;
      /* Adjust this value as needed, make sure it's higher than the z-index of the sidebar */
    }

    .modal-open .l-navbar {
      left: 0 !important;
    }


    @media screen and (max-width: 768px) {
      body {
        margin: calc(var(--header-height) + 1rem) 0 0 0;
        padding-left: calc(var(--nav-width) + 2rem)
      }

      .header {
        height: calc(var(--header-height) + 1rem);
        padding: 0 2rem 0 calc(var(--nav-width) + 2rem)
      }

      .header_img {
        width: 40px;
        height: 40px
      }

      .header_img img {
        width: 45px
      }

      .l-navbar {
        left: 0;
        padding: 1rem 1rem 0 0
      }



      .body-pd {
        padding-left: calc(var(--nav-width) + 188px)
      }



    }
  </style>
</head>

<body id="body-pd">
  <?php if ($result->num_rows > 0) : ?>
    <?php foreach ($result as $row) : ?>
      <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_img">
          <?php
          $img = '../' .  $row['photo'];

          $profileImage = ($img !== null) ? $img : 'https://via.placeholder.com/150';
          ?>
          <img src="<?= $profileImage ?>" alt="">
        </div>
      </header>
      <div class="l-navbar" id="nav-bar">
        <nav class="nav">
          <div><a href="#" class="nav_logo text-white"><i class="bi bi-house-fill"></i><span class="nav_logo-name">RBC - LABS</span></a>
            <div class="nav_list">
              <a href="teacher.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
              <a href="setting.php" class="nav_link active"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Setelan</span> </a>
            </div>
          </div>
          <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
      </div>


      <div class="content-wrapper">

        <div>
          <h4 class="text-center">Setting</h4>
          <hr>
          <div class="card">
            <h1 class="card-header">Profil</h1>
            <div class="card-body">
              <!-- Slightly larger circle -->
              <img src="<?= $img ?>" class="card-img-top rounded-circle img-fluid" alt="Profile Image" style="width: 130px; height: 130px;">
              <h5 class="card-title">username: <?= $row['username'] ?> </h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changes">
                Changes
              </button>
            </div>
          </div>
        </div>




      <?php endforeach; ?>
      <!-- Modal -->
      <div class="modal fade" id="changes" tabindex="-1" aria-labelledby="changesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Changes Data Profile</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../editPhototeacher.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="user_id" value="<?= $idPengguna ?>">
              <div class="modal-body">
                <div class="mt-3">
                  <label for="image_profile">Photo</label>
                  <img src="<?= $img ?>" class="card-img-top rounded-circle img-fluid" alt="Profile Image" style="width: 130px; height: 130px;">
                  <input type="file" name="image_profile" id="image_profile" accept=".jpg, .png, .jpeg">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit_setting">Save changes</button>
              </div>
            </form>

          </div>
        </div>
      </div>

      </div>
    <?php endif ?>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>



</body>

</html>