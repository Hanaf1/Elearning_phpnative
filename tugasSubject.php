<?php
session_start();
require 'function.php';

if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

$idUser = $_SESSION['user_id']; // Get the current user's ID

// Initialize $idCourse with a default value or handle it accordingly
$idCourse = null;

// Check if course_id is set in the query parameters
if (isset($_GET["course"])) {
  $idCourse = $_GET["course"];

  // You may want to sanitize and validate $idCourse here
  // For example, you can use intval() to ensure it's an integer
  $idCourse = intval($idCourse);

  // Save course_id in a cookie
  setcookie("course_id", $idCourse, time() + 3600, "/"); // Cookie expires in 1 hour
} elseif (isset($_COOKIE["course"])) {
  // Retrieve course_id from the cookie if it's set
  $idCourse = $_COOKIE["course"];
}

// Now you can use $idCourse and $idUser in your query
if ($idCourse !== null) {
  $photoQuery = "SELECT photo FROM users WHERE id_user = $idUser";

  $photoResult = $conn->query($photoQuery);

  if (!$photoResult) {
    die("Error: " . $conn->error);
  }

  // Fetch the user's photo from the result set
  $photoRow = $photoResult->fetch_assoc();
  $image = $photoRow['photo'];

  $query = "SELECT upload_assignment.*, course.CourseName, course_master.Name_Course
              FROM upload_assignment
              INNER JOIN course ON upload_assignment.courseID = course.CourseID
              INNER JOIN course_master ON course.CourseName = course_master.id_nameCourse
              WHERE upload_assignment.courseID = $idCourse";


  // Fetch assignments from the upload_material table that are not finished
  $result = $conn->query($query);

  // Fetch all rows into an array
  $resultArray = $result->fetch_all(MYSQLI_ASSOC);



  // Menyaring tugas yang belum dikerjakan
  $unfinishedAssignments = array_filter($resultArray, function ($row) use ($idUser, $conn) {
    $uploadID = $row['upload_id'];

    // Periksa apakah ada catatan di tabel assignment untuk pengguna dan tugas
    $assignmentQuery = "SELECT * FROM assignment WHERE UserID = $idUser AND assigment = $uploadID";
    $assignmentResult = $conn->query($assignmentQuery);

    return !$assignmentResult->num_rows; // Jika tidak ada catatan ditemukan, tugas belum dikerjakan
  });

  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Assigment</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="assets/favicon.ico">
  <style>
    .nav-link.active {
      border-bottom: 2px solid #007bff !important;
    }
  </style>
</head>

<body id="body-pd">
  <header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="header_img"> <img src="<?= $image ?: 'https://via.placeholder.com/150' ?>" class="img-fluid" alt=""></div>
  </header>
  <div class="l-navbar" id="nav-bar">
    <nav class="nav">
      <div> <a href="#" class="nav_logo text-white"><i class="bi bi-house-fill"></i><span class="nav_logo-name">RBC - LABS</span></a>
        <div class="nav_list">
          <a href="index.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
          <a href="setting.php" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Setelan</span> </a>
        </div>
      </div>
      <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>

  <div class="container">
    <h4 class="text-center"><?= $_GET['material'] ?></h4>
    <div class="d-flex justify-content-start">
      <div class="p-2 m-0"><a href="subject.php?course=<?= $idCourse ?>&material=<?= $_GET['material'] ?>" class="text-dark nav-link">Materi</a></div>
      <div class="p-2 m-0"><a href="tugasSubject.php?course=<?= $idCourse ?>&material=<?= $_GET['material'] ?>" class="text-dark nav-link active">Tugas</a></div>
      <div class="p-2 m-0"><a href="finished.php?course=<?= $idCourse ?>&material=<?= $_GET['material'] ?>" class="text-dark nav-link">Finished</a></div>
    </div>
    <hr>
    <?php if (!empty($unfinishedAssignments)) : ?>

      <div class="row">
        <?php foreach ($unfinishedAssignments as $row) : ?>
          <?php
          $upload_id = $row['upload_id'];
          $course_name = $row['Title'];
          $Deadline = $row['Deadline'];
          $Deksripsi = $row['deksripsi'];
          ?>
          <div class="col-md-4">
            <div class="card-deck mb-2">
              <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title"><?= $course_name ?></h5>
                  <p class="mb-0"><b>Deskripsi Tugas : </b><?= $Deksripsi ?></p>
                  <p class="mt-0"><b>Deadline: </b><?= $Deadline  ?></p>
                  <a href="assigment.php?assigment=<?= $upload_id ?>&material=<?= $_GET['material'] ?>" class="btn btn-primary">Kerjakan</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p class="text-center">Tidak ada tugas yang belum dikerjakan.</p>
    <?php endif; ?>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="js/index.js"></script>



</body>

</html>