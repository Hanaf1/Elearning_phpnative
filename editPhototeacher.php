<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

require('function.php');

// Assuming that the form is submitted
if (isset($_POST['edit_setting'])) {
  // Get user ID from the form
  $idPengguna = intval($_POST['user_id']);

  // Get existing photo path from the database
  $querySelectOldPhoto = "SELECT photo FROM users WHERE id_user = $idPengguna";
  $resultOldPhoto = $conn->query($querySelectOldPhoto);

  if ($resultOldPhoto->num_rows > 0) {
    $oldPhoto = $resultOldPhoto->fetch_assoc()['photo'];
  } else {
    $oldPhoto = ""; // Set to an empty string if no existing photo
  }

  // Call the updateImage function to handle image update
  $fileField = 'image_profile'; // Adjust this based on your HTML form
  $uploadDirectory = 'uploads/';

  // Check file extension using pathinfo
  $fileInfo = pathinfo($_FILES[$fileField]['name']);
  $fileExtension = $fileInfo['extension'];

  $allowedExtensions = array('jpg', 'jpeg', 'png');

  if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Invalid file format. Please upload a JPG, JPEG, or PNG file.'
    ];
    header("Location: setting.php");
    exit();
  }

  $newImagePath = DatabaseHandler::updateImage($fileField, $uploadDirectory, $idPengguna, $oldPhoto);

  if (is_string($newImagePath) && strpos($newImagePath, 'error') !== false) {
    // An error occurred during the image update
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => $newImagePath
    ];
  } else {
    if (!empty($oldPhoto)) {
      unlink($oldPhoto); // This will delete the file
    }

    $queryUpdatePhoto = "UPDATE users SET photo = '$newImagePath' WHERE id_user = $idPengguna";
    $conn->query($queryUpdatePhoto);

    // Success message
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Profile photo updated successfully.'
    ];
  }

  // Redirect to the setting page
  header("Location: teacher/setting.php");
  exit();
}
