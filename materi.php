<?php
session_start();

require 'function.php';

if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}


// Add a query to select the user's photo from the "users" table
$photoQuery = "SELECT photo FROM users WHERE id_user = {$_SESSION['user_id']}";

$photoResult = $conn->query($photoQuery);

if (!$photoResult) {
  die("Error: " . $conn->error);
}

// Fetch the user's photo from the result set
$photoRow = $photoResult->fetch_assoc();
$image = $photoRow['photo'];

// Initialize $idMaterial with a default value or handle it accordingly
$idMaterial = null;


// Check if course_id is set in the query parameters
if (isset($_GET["material"])) {
  $idMaterial = $_GET["material"];

  $query = "SELECT * FROM material WHERE MaterialID = $idMaterial";

  $result = $conn->query($query);

  if (!$result) {
    die("Error: " . $conn->error);
  }

  $conn->close();
} else {
  // Handle the case when material_id is not set
  // For example, redirect to an error page or show an error message
  echo "Error: material_id is not set.";
}
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
      <?php $row = $result->fetch_assoc(); ?>
      <h4 class="text-center"><?= $row['Title'] ?></h4>
      <hr>

      <div class="border p-3">
        <?php
        $videoId = extractVideoIdFromUrl($row['url_video']);

        // Check if videoId is not empty before displaying the iframe
        if (!empty($videoId)) {
        ?>
          <label for="">video materi</label>
          <iframe src="https://www.youtube.com/embed/<?= $videoId ?>" width="100%" height="500" frameborder="0" allowfullscreen></iframe>
        <?php } ?>
        <?php if (!empty($row['file_path'])) { ?>
          <?php
          $file_path = $row['file_path'];
          $url = str_replace('uploads/', '', $file_path);
          ?>
          <label for="">file Materi</label>
          <div class="form-control"><a href="../uploads/<?= $url ?>"><?= $url ?></a></div>
        <?php } ?>
        <label for="">Materi</label>
        <div class="form-control"><?= html_entity_decode($row['Content']) ?></div>
      <?php endif; ?>
      </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="js/index.js"></script>
</body>

</html>

<?php
// Function to extract video ID from YouTube URL
function extractVideoIdFromUrl($url)
{
  $videoId = '';
  $pattern = '#(?:https?://)?(?:www\.)?(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})#';
  preg_match($pattern, $url, $matches);

  if (isset($matches[1])) {
    $videoId = $matches[1];
  }

  return $videoId;
}
?>