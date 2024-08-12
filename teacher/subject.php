<?php

session_start();


require '../function.php';

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


// Initialize $idCourse with a default value or handle it accordingly
$idCourse = null;

// Check if course_id is set in the query parameters
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
  $image = '../' . $photoRow['photo'];


  // course 

  // Your existing code to select course materials
  $query = "SELECT material.*, course_master.Name_Course AS NameCourse FROM material
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



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subject</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="../assets/favicon.ico">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/trix/dist/trix.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trix"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
          <a href="teacher.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
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
        <div class="p-2 m-0"><a href="tugas.php?course=<?= $idCourse ?>&material=<?= $_GET['material'] ?>" class="text-dark">Tugas</a></div>
      </div>
      <hr>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
        Add Material
      </button>
      <br>

      <!-- Modal ADD -->
      <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Materi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../processGuru.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="CourseID" value="<?= $idCourse ?>">
              <input type="hidden" name="CourseMaterial" value="<?= $_GET['material'] ?>">
              <div class="modal-body">
                <div class="mt-3">
                  <div class="mb-3">
                    <label for="Title" class="col-form-label">Judul Materi:</label>
                    <input type="text" class="form-control" id="Title" name="Title">
                  </div>
                  <div class="mb-3">
                    <label for="material" class="col-form-label">Materi:</label>
                    <input id="material" type="hidden" name="material">
                    <trix-editor input="material" style="height: 150px; resize: vertical;"></trix-editor>
                  </div>

                  <div class="mb-3">
                    <label for="file_path" class="col-form-label">File:</label>
                    <caption>PDF, PPTX min 5mb</caption>
                    <input type="file" class="form-control" id="file_path" name="file_path">
                  </div>

                  <div class="mb-3">
                    <label for="url_video" class="col-form-label">URLyoutube:</label>
                    <input type="text" class="form-control" id="url_video" name="url_video">
                  </div>

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_material">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <div class="row mt-2">


        <?php foreach ($result as $row) : ?>
          <?php
          $materialID = $row['MaterialID'];
          $course_name = $row['Title'];
          $Content = $row['Content'];
          $modalId = 'confirmDelete_' . $materialID;
          $updateID = 'update_' . $materialID;
          ?>
          <div class="col-md-4">
            <div class="card-deck mb-2">
              <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title"><?= $course_name ?></h5>
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="material.php?material=<?= $materialID ?>" class="btn btn-primary">Materi</a>
                    <div>
                      <button type="button" class="btn btn-link text-dark" data-bs-toggle="modal" data-bs-target="#<?= $updateID ?>">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button type="button" class="btn btn-link text-dark" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                        <i class="bi bi-trash"></i>
                      </button>

                      <!-- Modal update -->
                      <div class="modal fade" id="<?= $updateID ?>" tabindex="-1" aria-labelledby="<?= $updateID ?>Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="<?= $updateID ?>">Edit Materi</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="../processGuru.php" method="post" enctype="multipart/form-data">
                              <div class="modal-body">
                                <div class="mt-3">
                                  <div class="mb-3">
                                    <label for="Title" class="col-form-label">Judul Materi:</label>
                                    <input type="text" class="form-control" id="Title" name="Title" value="<?= $course_name ?>">
                                  </div>
                                  <!-- Replace the textarea with the Trix editor -->
                                  <div class="mb-3">
                                    <label for="material<?= $materialID ?>" class="col-form-label">Materi:</label>
                                    <input id="material<?= $materialID ?>" type="hidden" name="material" value="<?= $row['Content']?>">
                                    <trix-editor input="material<?= $materialID ?>" style="height: 150px; resize: vertical;"></trix-editor>
                                  </div>
                                  <?php
                                  $file_path = $row['file_path'];
                                  $url = str_replace('uploads/', '', $file_path);
                                  ?>
                                  <div class="mb-3">
                                    <label for="file_path" class="col-form-label">File:</label>
                                    <caption>PDF, PPTX min 5mb</caption>
                                    <a href="../uploads/<?= $url ?>"><?= $url ?></a>
                                    <input type="file" class="form-control" id="file_path" name="file_path">
                                  </div>
                                  <div class="mb-3">
                                    <label for="url_video" class="col-form-label">URL youtube:</label>
                                    <input type="text" class="form-control" id="url_video" name="url_video" value="<?= $row['url_video'] ?>">
                                  </div>
                                  <input type="hidden" name="CourseID" value="<?= $idCourse ?>">
                                  <input type="hidden" name="MaterialID" value="<?= $materialID ?>">
                                  <input type="hidden" name="CourseMaterial" value="<?= $_GET['material'] ?>">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="change_material">Save changes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>



                      <!-- Modal for confirmation delete-->
                      <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="<?= $modalId ?>Label">Confirm Deletion</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete this material?
                            </div>
                            <div class="modal-footer">
                              <form action="processMaterial.php" method="post" class="d-inline">
                                <button type="submit" name="deleteMaterial" class="btn btn-danger">
                                  Confirm Delete
                                  <input type="hidden" name="MaterialID" value="<?= $materialID ?>">
                                  <input type="hidden" name="CourseID" value="<?= $idCourse ?>">
                                  <input type="hidden" name="CourseMaterial" value="<?= $_GET['material'] ?>">
                                </button>
                              </form>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script>
            document.addEventListener('DOMContentLoaded', function() {

              var trixEditor<?= $row['MaterialID'] ?> = new Trix.Editor(document.getElementById('Material<?= $row['MaterialID'] ?>'));

              // Get the material ID from the data attribute
              var materialID<?= $row['MaterialID'] ?> = <?= $row['MaterialID'] ?>;

              // Get the content associated with the material ID
              var content<?= $row['MaterialID'] ?> = <?= json_encode($row['Content']) ?>;

              // Set the content for the Trix editor
              trixEditor<?= $row['MaterialID'] ?>.loadHTML(content<?= $row['MaterialID'] ?>);

            });
          </script>

        <?php endforeach; ?>
      <?php else : ?>
        <p class="text-center">No classes available.</p>
      <?php endif; ?>



      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
      <script src="../js/index.js"></script>
</body>

</html>