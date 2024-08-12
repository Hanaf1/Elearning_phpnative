<?php
session_start();
require 'function.php';

// Database connection
if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

$assigment_id = null;

if (isset($_GET['assigment'])) {
  $assigment_id = intval($_GET['assigment']);


  $query = "SELECT * FROM upload_assignment
    INNER JOIN course ON upload_assignment.CourseID = course.CourseID
    INNER JOIN course_master ON course.CourseName = course_master.id_nameCourse
    WHERE upload_assignment.upload_id = $assigment_id";

  $result = $conn->query($query);

  if (!$result) {
    die("Error in the first query: " . $conn->error);
  }

  $resultArray = $result->fetch_all(MYSQLI_ASSOC);
  if (!$resultArray) {
    die("No data found in the first query: " . $conn->error);
  }

  // Fetch additional data from the assignment table
  $assignmentQuery = "SELECT * FROM assignment WHERE assigment = $assigment_id";
  $assignmentResult = $conn->query($assignmentQuery);

  if (!$assignmentResult) {
    die("Error in the second query: " . $conn->error);
  }

  $assignmentArray = $assignmentResult->fetch_all(MYSQLI_ASSOC);

  // Check if the deadline has passed
  $currentDate = date('Y-m-d');
  $deadlinePassed = $currentDate > $resultArray[0]['Deadline'];
} else {
  echo "Error: assigment_id is not set.";
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengerjaan siswa</title>
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
      <div><a href="#" class="nav_logo text-white"><i class="bi bi-house-fill"></i><span class="nav_logo-name">RBC - LABS</span></a>
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
      <?php foreach ($resultArray as $row) : ?>
        <?php
        $upload_id = $row['upload_id'];
        $course_name = $row['Title'];
        $Deadline = $row['Deadline'];
        $Deksripsi = $row['deksripsi'];


        // Check if the deadline has passed
        $deadlinePassed = $currentDate > $resultArray[0]['Deadline'];

        // Set textarea value based on the deadline status
        $textareaValue = $deadlinePassed ? $assignmentArray[0]['deskripsi'] : '';
        ?>
        <h2 class="mt-5"><?= $row['Name_Course'] ?></h2>
        <hr>
        <p class="my-0"><b><?= $course_name ?></b></p>
        <p class="my-0"><b>Desksripsi Tugas : </b><?= $Deksripsi ?></p>
        <p class="my-0"><b>file tugas: </b><a href="<?= $row['file_path'] ?>"><?= (trim($row['file_path'], "uploads/")); ?></a></p>
        <p class="my-0"><b>Deadline: </b><?= $Deadline ?></p>
        <?php if ($deadlinePassed) : ?>
          <p class="my-0">
            <b>Grade: </b>
            <span class="<?= $assignmentArray[0]['Grade'] >= 60 ? 'text-success' : 'text-danger'; ?>">
              <?= $assignmentArray[0]['Grade'] ?>
            </span>
          </p>

        <?php endif; ?>
        <form action="process_assigment.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Jawaban</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="jawaban" <?= $deadlinePassed ? 'readonly' : '' ?>><?= $assignmentArray[0]['deskripsi'] ?></textarea>
          </div>
          <div class="mb-3">
            <p class="my-0"><b>jika dibutuhkan :</b></p>
            <label for="formFile" class="form-label my-0">File Upload</label>
            <a href="<?= $assignmentArray[0]['file_path'] ?>"><?= (trim($assignmentArray[0]['file_path'], "uploads/")); ?></a>
            <input class="form-control" type="file" id="formFile" accept=".pdf, .png, .jpeg, .jpg" name="file_material" <?= $deadlinePassed ? 'disabled' : '' ?>>
          </div>
          <?php if (!$deadlinePassed) : ?>
            <input name="AssignmentID" type="hidden" value="<?= $assignmentArray[0]['AssignmentID'] ?>">
            <input name="id_upload" type="hidden" value="<?= $upload_id ?>">
            <input name="course" type="hidden" value="<?= $row["CourseID"] ?>">
            <input name="CourseMaterial" type="hidden" value="<?= $_GET['material'] ?>">
            <input name="id_user" type="hidden" value="<?= $_SESSION['user_id'] ?>">
            <button type="submit" class="btn btn-primary" name="edit_tugas">Update</button>
          <?php endif; ?>
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