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


$photoQuery = "SELECT photo FROM users WHERE id_user = {$_SESSION['user_id']}";

$photoResult = $conn->query($photoQuery);

if (!$photoResult) {
  die("Error: " . $conn->error);
}

// Fetch the user's photo from the result set
$photoRow = $photoResult->fetch_assoc();
$image = '../' . $photoRow['photo'];


$classquery = "SELECT studylevel FROM ";

// Ambil ID Pengguna dari sesi
$Course = intval($_GET['material']);

$query = "SELECT course.*, course_master.Name_Course, studylevel.StudyLevelID As StudyLevelID, course_master.Course_BG As BackgroundImg
FROM course
INNER JOIN studyaccess ON course.StudyLevelID = studyaccess.StudyLevelID
INNER JOIN course_master ON course.CourseName = course_master.id_nameCourse
INNER JOIN studylevel ON course.StudyLevelID = studylevel.StudyLevelID
WHERE course.StudyLevelID = $Course;";

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
  <title>Pelajaran</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="../assets/favicon.ico">
</head>
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
      padding-left: calc(var(--nav-width) + 0.5rem)
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
          <a href="class.php" class="nav_link"> <i class="bi bi-file-earmark-diff-fill"></i><span class="nav_name">Class</span> </a>
          <a href="listPerson.php" class="nav_link"><i class="bi bi-people"></i><span class="nav_name">List Anggota</span> </a>
          <a href="addPerson.php" class="nav_link"> <i class="bi bi-person-add"></i><span class="nav_name">Tambah Siswa</span> </a>
        </div>
      </div>
      <a href="../logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>
  <div class=" mt-5">
    <h2 class="text-align-center">List Pelajaran</h2>

    <hr>
    <div class="container mt-5">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSubject">Tambah Pelajaran</button>
      <?php
      if ($result->num_rows > 0) {
        $counter = 0; // Initialize the counter variable
        while ($row = $result->fetch_assoc()) {
          $img = trim(str_replace(["\r", "\n"], '', $row['BackgroundImg']));
          $img = '../' . $img;
          if ($counter % 3 == 0) {
            echo '<div class="row">';
          }

          echo '<div class="col-lg-4">';
          echo '<div class="jumbotron mb-5 border rounded" loading="lazy" style="background-image: url(\'' . $img . '\'); background-size: cover; background-position: center; background-repeat: no-repeat; widht:500px; height:300px;">';
          $course_id = $row['CourseID'];
          setcookie("course_id", $course_id, time() + 3600, "/");
          echo '<div>';
          echo '<p class="display-5 text-white my-0">' . $row['Name_Course'] . '</p>';
          echo '<p class="display-5 text-white">Kelas : ' . $row['StudyLevelID'] . '</p>';
          echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteClassModal' . $counter . '" onclick="setDeleteClassData(' . $Course . ')">Delete</button>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          // Delete Class Modal
          echo '<div class="modal fade" id="deleteClassModal' . $counter . '" tabindex="-1" aria-labelledby="deleteClassModalLabel' . $counter . '" aria-hidden="true">';
          echo '<div class="modal-dialog">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="deleteClassModalLabel' . $counter . '">Delete Class</h5>';
          echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<p>Are you sure you want to delete this class?</p>';
          echo '</div>';
          echo '<div class="modal-footer">';
          echo '<form action="processSubject.php" method="post">';
          echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
          echo '<input type="hidden" name="level" value="' . $Course . '">';
          echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
          echo '<button type="submit" class="btn btn-danger" name="deleteSubject">Delete</button>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          if ($counter % 3 == 2 || $counter == $result->num_rows - 1) {
            echo '</div>';
          }
          $counter++;
        }
      } else {
        echo '<p class="text-center">No classes available.</p>';
      }

      ob_end_flush();
      ?>
      <!-- Add Class Modal -->
      <div class="modal fade" id="addSubject" tabindex="-1" aria-labelledby="addSubjectLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addSubjectLabel">Add Subject</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="processSubject.php" method="post">
                <input type="hidden" name="level" value="<?= $Course ?>">
                <div class="mb-3">
                  <label for="subjectSelect" class="form-label">Subject:</label>
                  <select class="form-select" id="subjectSelect" name="subjectSelect" required>
                    <?php
                    $subjects = [
                      1 => 'Bahasa Indonesia',
                      2 => 'Matematika',
                      3 => 'IPA',
                      4 => 'IPS',
                      5 => 'PKN',
                      6 => 'PJOK',
                      7 => 'Bahasa Inggris',
                    ];
                    foreach ($subjects as $value => $subject) {
                      echo '<option value="' . $value . '">' . $subject . '</option>';
                    }
                    ?>
                  </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="tambahPelajaran">Tambah Pelajaran</button>
              </form>
            </div>
          </div>
        </div>
      </div>



    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="../js/index.js"></script>
</body>

</html>