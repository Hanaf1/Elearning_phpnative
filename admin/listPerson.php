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



$query = "SELECT studyaccess.AccessID, studyaccess.StudyLevelID,  studylevel.LevelName, users.username AS username
FROM studyaccess
LEFT JOIN studylevel ON studyaccess.StudyLevelID = studylevel.StudyLevelID
INNER JOIN users ON studyaccess.UserID = users.id_user";



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
    <div class="header_img"> <img src="<?= $image ?: 'https://via.placeholder.com/150' ?>" class="img-fluid" alt=""></div>
  </header>
  <div class="l-navbar" id="nav-bar">
    <nav class="nav">
      <div><a href="#" class="nav_logo text-white"><i class="bi bi-house-fill"></i><span class="nav_logo-name">RBC - LABS</span></a>
        <div class="nav_list">
          <a href="class.php" class="nav_link"> <i class="bi bi-file-earmark-diff-fill"></i><span class="nav_name">Class</span> </a>
          <a href="listPerson.php" class="nav_link active"><i class="bi bi-people"></i><span class="nav_name">List Anggota</span> </a>
          <a href="addPerson.php" class="nav_link"> <i class="bi bi-person-add"></i><span class="nav_name">Tambah Siswa</span> </a>
        </div>
      </div>
      <a href="../logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
  </div>
  <div>
    <div class="d-flex gap-2">
      <a href="listPerson.php" class="text-dark nav-link active">Murid</a>
      <a href="listGuru.php" class="text-dark nav-link">Guru</a>
    </div>

    <hr>
    <div class="container mt-5">
      <h2>List Nama Siswa</h2>
      <table class="table table-bordered table-sm" style="width: 50%;">
        <thead class="table-primary">
          <tr>
            <th scope="col" class="col-1">No Siswa</th>
            <th scope="col" class="col-5">Nama Siswa</th>
            <th scope="col" class="col-5">Kelas</th>
            <th scope="col" class="col-1">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $row) : ?>
            <tr>
              <td><?= $row['AccessID'] ?></td>
              <td><?= $row['username'] ?></td>
              <td><?= ($row['LevelName'] !== null) ? $row['LevelName'] : 'Belum Dapat Kelas' ?></td>
              <td class="d-flex justify-content-between">
                <!-- Update Form -->
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['AccessID'] ?>" title="Update">
                  <i class="bi bi-pencil"></i>
                </button>
                <!-- Delete Form -->
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['AccessID'] ?>" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>

            <!-- Update Modal -->
            <div class="modal fade" id="updateModal<?= $row['AccessID'] ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $row['AccessID'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel<?= $row['AccessID'] ?>">Update Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="processAdmin.php" method="post">
                      <input type="hidden" name="AccessID" value="<?= $row['AccessID'] ?>">
                      <div class="mb-3">
                        <label for="updatedUsername" class="form-label">Updated Username:</label>
                        <input type="text" name="updatedUsername" id="updatedUsername" class="form-control" value="<?= $row['username'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label for="updatedKelas" class="form-label">Updated Kelas:</label>
                        <select name="updatedKelas" id="updatedKelas" class="form-select" required>
                          <?php for ($i = 1; $i <= 9; $i++) : ?>
                            <option value="<?= $i ?>" <?php echo ($i == $row['StudyLevelID']) ? 'selected' : ''; ?>>Kelas <?= $i ?></option>
                          <?php endfor; ?>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary" name="updateSiswa">Update</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>


            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal<?= $row['AccessID'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['AccessID'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $row['AccessID'] ?>">Delete Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure you want to delete <?= $row['username'] ?>?</p>
                    <form action="processAdmin.php" method="post">
                      <input type="hidden" name="AccessID" value="<?= $row['AccessID'] ?>">
                      <button type="submit" class="btn btn-danger" name="deleteSiswa">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
</body>

</html>