<?php

session_start();


require 'function.php';

if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

// Initialize $idCourse with a default value or handle it accordingly
$idCourse = null;

// Check if course_id is set in the jquery parameters
if (isset($_GET["course"])) {
  $idCourse = $_GET["course"];

  // You may want to sanitize and validate $idCourse here
  // For example, you can use intval() to ensure it's an integer
  $idCourse = intval($idCourse);

  // Save course in a cookie
  setcookie("course", $idCourse, time() + 3600, "/"); // Cookie expires in 1 hour
} elseif (isset($_COOKIE["course"])) {
  // Retrieve course from the cookie if it's set
  $idCourse = $_COOKIE["course"];
}

// photo

if ($idCourse !== null) {
  // Add a query to select the user's photo from the "users" table
  $photoQuery = "SELECT photo FROM users WHERE id_user = {$_SESSION['user_id']}";

  $photoResult = $conn->query($photoQuery);

  if (!$photoResult) {
    die("Error: " . $conn->error);
  }

  // Fetch the user's photo from the result set
  $photoRow = $photoResult->fetch_assoc();
  $image = $photoRow['photo'];


  // course 

  // Your existing code to select course materials
  $query = "SELECT material.MaterialID, material.Title, material.Content, material.CourseID, material.url_video, course_master.Name_Course AS NameCourse FROM material
  INNER JOIN course ON material.CourseID = course.CourseID
  INNER JOIN course_master ON course.CourseName = course_master.id_nameCourse
  WHERE material.CourseID = $idCourse";

  $result = $conn->query($query);

  if (!$result) {
    die("Error: " . $conn->error);
  }

  $conn->close();
} else {
  // Handle the case when course_id is not set
  // For example, redirect to an error page or show an error message
  echo "Error: course_id is not set.";
}



// The rest of your HTML and PHP code...

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Materi</title>
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
          <a href="index.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
          <a href="setting.php" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Setelan</span> </a>
        </div>
      </div>
      <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>
  <div class="container">
    <?php if ($result->num_rows > 0) : ?>
      <?php $courseInfo = $result->fetch_assoc(); ?>
      <h4 class="text-center"><?= $courseInfo['NameCourse'] ?></h4>
      <div class="d-flex justify-content-start">
        <div class="p-2 m-0"><a href="subject.php?course=<?= $idCourse ?>&material=<?= $_GET['material'] ?>" class="text-dark nav-link active">Materi</a></div>
        <div class="p-2 m-0"><a href="tugasSubject.php?course=<?= $idCourse ?>&material=<?= $_GET['material'] ?>" class="text-dark">Tugas</a></div>
      </div>
      <hr>
      <div class="row">
        <?php foreach ($result as $row) : ?>
          <?php
          $course_id = $row['MaterialID'];
          $course_name = $row['Title'];
          ?>
          <div class="col-md-4">
            <div class="card-deck mb-2">
              <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title"><?= $course_name ?></h5>
                  <a href="materi.php?material=<?= $course_id ?>" class="btn btn-primary">Materi</a>
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
  <script src="js/index.js"></script>
</body>

</html>