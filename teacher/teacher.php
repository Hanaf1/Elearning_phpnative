<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
if ($_SESSION['role'] !== 'Teacher') {
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
$idPengguna = intval($_SESSION['user_id']);

// Get the current day of the week
$currentDay = strtolower(date("l"));

// Query untuk mengambil data kelas yang diikuti oleh pengguna pada hari ini
$query = "SELECT * FROM studylevel";

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
  <title>home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" type="image/png" href="../assets/favicon.ico">
</head>

<body id="body-pd">
  <header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="header_img">
      <img src="<?= $image ?: 'https://via.placeholder.com/150' ?>" class="img-fluid" alt="">
    </div>
  </header>
  <div class="l-navbar" id="nav-bar">
    <nav class="nav">
      <div> <a href="#" class="nav_logo text-white"><i class="bi bi-house-fill"></i><span class="nav_logo-name">RBC - LABS</span></a>
        <div class="nav_list">
          <a href="teacher.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
          <a href="setting.php" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Setelan</span> </a>
        </div>
      </div>
      <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>
  <div>
    <h4 class="text-center"><?= date("l") ?></h4>
    <hr>
    <div class="container mt-5">
      <?php if ($result->num_rows > 0) : ?>
        <div class="row">
          <?php foreach ($result as $row) : ?>
            <?php
            $course_id = $row['StudyLevelID'];
            $course_name = $row['LevelName'];
            ?>
            <div class="col-md-4">
              <div class="card-deck mb-2">
                <div class="card" style="width: 18rem;">
                  <div class="card-body">
                    <h5 class="card-title"><?= $course_name ?></h5>
                    <a href="teacherClass.php?material=<?= $course_id ?>" class="btn btn-primary">More</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <p class="text-center">No classes available.</p>
      <?php endif; ?>

    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
</body>

</html>