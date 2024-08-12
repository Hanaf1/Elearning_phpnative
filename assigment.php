<?php

session_start();

require 'function.php';

if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

// Initialize $idCourse with a default value or handle it accordingly
$assigment_id = null;


// Check if course_id is set in the query parameters
if (isset($_GET['assigment'])) {

  $assigment_id = intval($_GET['assigment']);


  $query = "SELECT * FROM upload_assignment
    INNER JOIN course ON upload_assignment.CourseID = course.CourseID
    INNER JOIN course_master ON course.CourseName = course_master.id_nameCourse
    WHERE upload_assignment.upload_id = $assigment_id";

  $result = $conn->query($query);

  // Fetch all rows into an array
  $resultArray = $result->fetch_all(MYSQLI_ASSOC);
  if (!$resultArray) {
    die("Error: " . $conn->error);
  }


  $conn->close();
} else {
  // Handle the case when course_id is not set
  // For example, redirect to an error page or show an error message
  echo "Error: course_id is not set.";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="assets/favicon.ico">
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
    <?php if (!empty($resultArray)) : ?>
      <?php $courseInfo = $resultArray[0]; ?>
      <h2 class="mt-5"><?= $courseInfo['Name_Course'] ?></h2>
      <hr>

      <?php foreach ($resultArray as $row) : ?>
        <?php
        $upload_id = $row['upload_id'];
        $course_name = $row['Title'];
        $Deadline = $row['Deadline'];
        $Deksripsi = $row['deksripsi'];
        ?>
        <p class="my-0"><?= $course_name ?></p>
        <p class="my-0"><b>Desksripsi Tugas : </b><?= $Deksripsi ?></p>
        <p class="my-0"><b>file tugas: </b><a href="<?= $row['file_path'] ?>"><?= (trim($row['file_path'], "uploads/")); ?></a></p>
        <p class="my-0"><b>Deadline: </b><?= $Deadline  ?></p>
        <form action="process_assigment.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Jawaban</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="detail_material"></textarea>
          </div>
          <div class="mb-3">
            <p class="my-0"><b>jika dibutuhkkan :</b></p>
            <label for="formFile" class="form-label my-0">File Upload</label>
            <input class="form-control" type="file" id="formFile" accept=".pdf, .png, .jpeg, .jpg" name="file_material">
          </div>
          <input name="id_upload" type="hidden" value="<?= $upload_id  ?>">
          <input name="CourseMaterial" type="hidden" value="<?= $_GET['material'] ?>">
          <input name="course" type="hidden" value="<?= $row["CourseID"]  ?>">
          <input name="id_user" type="hidden" value="<?= $_SESSION['user_id'] ?>">
          <button type="submit" class="btn btn-primary" name="submit_tugas">Submit</button>
        </form>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-center">No finished submissions available.</p>
    <?php endif; ?>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="js/index.js"></script>

</body>

</html>