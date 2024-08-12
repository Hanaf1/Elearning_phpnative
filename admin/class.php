<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
if ($_SESSION['role'] !== 'Admin') {
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
          <a href="class.php" class="nav_link active"> <i class="bi bi-file-earmark-diff-fill"></i><span class="nav_name">Class</span> </a>
          <a href="listPerson.php" class="nav_link"><i class="bi bi-people"></i><span class="nav_name">List Anggota</span> </a>
          <a href="addPerson.php" class="nav_link"> <i class="bi bi-person-add"></i><span class="nav_name">Tambah Siswa</span> </a>
        </div>
      </div>
      <a href="../logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>
  <div>
    <h4 class="text-center">Admin</h4>
    <hr>
    <!-- ... (your existing code) -->

    <div class="container mt-5">
      <button type="button" class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#addClassModal">
        <i class="bi bi-plus"></i> Add Class
      </button>

      <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="processAdmin.php" method="post">
                <div class="mb-3">
                  <label for="newClassName" class="form-label">Class Name:</label>
                  <input type="text" class="form-control" id="newClassName" name="newClassName" required>
                </div>
                <button type="submit" class="btn btn-success" name="addClass">Add Class</button>
              </form>
            </div>
          </div>
        </div>
      </div>

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
                    <!-- Icons for CRUD operations -->
                    <a href="subject.php?material=<?= $course_id ?>" class="btn btn-primary btn-sm">
                      <i class="bi bi-arrow-right-square"></i> More
                    </a>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?= $course_id ?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $course_id ?>">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Update Modal -->
            <div class="modal fade" id="updateModal<?= $course_id ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $course_id ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel<?= $course_id ?>">Edit Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="processAdmin.php" method="post">
                      <input type="hidden" name="course_id" value="<?= $course_id ?>">
                      <div class="mb-3">
                        <label for="updatedCourseName" class="form-label">Updated Course Name:</label>
                        <input type="text" class="form-control" id="updatedCourseName" name="updatedCourseName" value="<?= $course_name ?>" required>
                      </div>
                      <button type="submit" class="btn btn-primary" name="updateClass">Update</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal<?= $course_id ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $course_id ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $course_id ?>">Delete Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure you want to delete this class?</p>
                    <form action="processAdmin.php" method="post">
                      <input type="hidden" name="course_id" value="<?= $course_id ?>">
                      <button type="submit" name="deleteClass" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                      </form>
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

    <!-- ... (your existing code) -->




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
</body>

</html>