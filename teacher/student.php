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
$Course = intval($_GET['material']);

$query = "SELECT studyaccess.AccessID, users.username AS username
          FROM studyaccess
          INNER JOIN users ON studyaccess.UserID = users.id_user
          WHERE studyaccess.StudyLevelID= '$Course'";


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
  <title>Class</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" type="image/png" href="../assets/favicon.ico">
</head>
<style>
  .nav-link.active {
    border-bottom: 2px solid #007bff !important;
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
  <div>
    <div class="d-flex gap-2">
      <a href="teacherClass.php?material=<?= $_GET['material'] ?>" class="text-dark">Class</a>
      <a href="student.php?material=<?= $_GET['material'] ?>" class="text-dark nav-link active">Student</a>
    </div>

    <hr>
    <div class="container mt-5">
      <h2>List Nama Siswa</h2>
      <table class="table table-bordered table-sm" style="width: 50%;">
        <thead class="table-primary">
          <tr>
            <th scope="col" class="col-1">No Siswa</th>
            <th scope="col" class="col-5">Nama Siswa</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $row) : ?>
            <tr>
              <td><?= $row['AccessID'] ?></td>
              <td><?= $row['username'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="../js/index.js"></script>
</body>

</html>