<?php
session_start();
// Menghubungkan ke file koneksi.php
require 'function.php';

// Memeriksa apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Melakukan query untuk mengambil data pengguna berdasarkan email
  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    // Pengguna ditemukan, verifikasi kata sandi

    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    if (password_verify($password, $hashedPassword)) {
      // Kata sandi benar, lanjutkan dengan proses login
      $role = $row['role'];
      // Set session role
      $_SESSION['email'] = $email;
      $_SESSION['role'] = $role;
      $_SESSION['user_id'] = $row['id_user'];

      // Mengarahkan pengguna ke halaman sesuai dengan peran (role)
      if ($role == 'Student') {
        header("Location: index.php");
        exit();
      }
      else if($role == "Admin"){
        header("Location: admin/class.php");
        exit();
      } else {
        header('Location: teacher/teacher.php');
        exit();
      }
    } else {
      // Kata sandi salah
      $error = "The email or password is incorrect. or you don't have an account yet";
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $error .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
  } else {
    // Pengguna tidak ditemukan
    $error = "The email or password is incorrect. or you don't have an account yet";
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $error .
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Login Form</title>
  <link rel="icon" type="image/png" href="assets/favicon.ico">
  <style>
    .h-custom {
      height: calc(100% - 73px);
    }

    @media (max-width: 768px) {
      .img-fluid {
        width: 35%;
        /* Adjust the size as needed */
        margin-bottom: 20px;
        /* Add some spacing between image and form on mobile */
      }
    }
  </style>
</head>

<body>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5 text-center order-md-1">
          <img src="assets/RBC.png" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-7 col-lg-6 col-xl-4 order-md-2">
          <form method="POST">
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
              <p class="lead fw-normal mb-0 me-3">Sign in </p>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4 mt-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" />
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Login</button>

          </form>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>

</html>