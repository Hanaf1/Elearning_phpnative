<?php
ob_start();
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

$photoQuery = "SELECT photo FROM users WHERE id_user = {$_SESSION['user_id']}";

$photoResult = $conn->query($photoQuery);

if (!$photoResult) {
  die("Error: " . $conn->error);
}

// Fetch the user's photo from the result set
$photoRow = $photoResult->fetch_assoc();
$image = '../' . $photoRow['photo'];


// Ambil ID Pengguna dari sesi
$assignment = intval($_GET['assignment']);

$query = "SELECT assignment.*, users.username AS username
    FROM assignment
    INNER JOIN users ON assignment.UserID  = users.id_user
    WHERE assignment.AssignmentID = '$assignment'";


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
  <title>Jawaban Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="../assets/favicon.ico">
</head>
<style>
  .nav-link.active {
    border-bottom: 2px solid #007bff !important;
  }

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
    overflow: hidden;
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

<body id="body-pd">
  <header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="header_img"> <img src="<?= $image ?: 'https://via.placeholder.com/150' ?>" class="img-fluid" alt=""></div>
  </header>
  <div class="l-navbar" id="nav-bar">
    <nav class="nav">
      <div><a href="#" class="nav_logo text-white"><i class="bi bi-house-fill"></i><span class="nav_logo-name">RBC - LABS</span></a>
        <div class="nav_list">
          <a href="teacher.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
          <a href="setting.php" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Setelan</span> </a>
        </div>
      </div>
      <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>
  <div class=" mt-5">
    <h2 class="text-align-center">Detail Jawaban Siswa</h2>
    <hr>
    <div class="container mt-5">
      <div class="modal fade" id="gradeModalUngraded" tabindex="-1" role="dialog" aria-labelledby="gradeModalUngradedLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="gradeModalUngradedLabel">Berikan Nilai untuk Ungraded</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="processGrade.php" method="post">
                <div class="form-group">
                  <label for="gradeInputUngraded">Nilai:</label>
                  <input type="number" class="form-control" name="grade" id="gradeInputUngraded" placeholder="Masukkan nilai" min="0" max="100" step="1">
                  <input type="hidden" name="assignmentId" value="<?= $_GET['assignment'] ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-2" name="inputNilai">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php foreach ($result as $row) : ?>
        <div class="container mt-3">
          <table class="table table-bordered">
            <thead>
              <tr class="table-info">
                <th scope="col" class="col-4">Nama Siswa</th>
                <th scope="col" class="col-8"><?= $row['username'] ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="col-4">Jawaban</th>
                <td class="col-8"><?= $row['deskripsi'] ?></td>
              </tr>
              <?php
              $file_path = $row['file_path'];
              $url = str_replace('uploads/', '', $file_path);
              ?>
              <tr>
                <th scope="row" class="col-4">File</th>
                <td class="col-8"><a href="../uploads/<?= $url ?>"><?= $url ?></a></td>
              </tr>
              <tr>
                <th scope="row" class="col-4">Nilai</th>
                <td class="col-8">
                  <?php if (isset($row['Grade'])) : ?>
                    <span><?= $row['Grade'] ?><span> <span class="badge text-bg-primary" data-toggle="modal" data-target="#gradeModalUngraded" style="cursor: pointer;"> Ganti Nilai</span></span></span>
                  <?php else : ?>
                    <span class="badge text-bg-primary" data-toggle="modal" data-target="#gradeModalUngraded" style="cursor: pointer;">Beri Nilai</span>
                  <?php endif; ?>
                </td>

              </tr>
            </tbody>
          </table>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="../js/index.js"></script>
  <script>
    $(document).ready(function() {
      $('.badge.text-bg-primary').click(function() {
        $('#gradeModalUngraded').modal('show');
      });
    });
  </script>

</body>

</html>