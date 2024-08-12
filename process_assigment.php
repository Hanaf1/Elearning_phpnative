<?php
session_start();
require 'function.php';

if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}
if (isset($_POST['submit_tugas'])) {
  // Assuming you have sanitized and validated your form data
  $detail = $_POST["detail_material"];
  $id_user = $_POST["id_user"];
  $assignment = $_POST["id_upload"];
  $course = $_POST["course"];
  $courseMaterial = $_POST["CourseMaterial"];

  // File handling
  $fileName = isset($_FILES["file_material"]) ? $_FILES["file_material"]["name"] : null;
  $timestamp = time();

  // Check if a file is selected
  if (!empty($fileName)) {
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = "file_" . $timestamp . "." . $fileExtension;  // Generating a new unique filename
    $targetDir = "uploads/";  // Adjust the directory as needed
    $targetFilePath = $targetDir . $newFileName;

    // Upload file to the server with the new name
    if (move_uploaded_file($_FILES["file_material"]["tmp_name"], $targetFilePath)) {
      // Insert data into the database with the new file path and current timestamp
      $insertQuery = "INSERT INTO assignment (deskripsi, file_path, SubmissionDate, UserID, assigment, Course) VALUES (?, ?, NOW(), ?, ?, ?)";

      $stmt = $conn->prepare($insertQuery);
      $stmt->bind_param("sssss", $detail, $targetFilePath, $id_user, $assignment, $course);

      if ($stmt->execute()) {
        $_SESSION['notification'] = [
          'type' => 'success',
          'message' => 'jawaban diterima ',
        ];
      } else {
        $_SESSION['notification'] = [
          'type' => 'danger',
          'message' => 'Error inserting assignment: ' . $stmt->error
        ];
      }

      // Redirect to finished.php
      header("Location: finished.php?course=$course&material=$courseMaterial");
      exit();
    } else {
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error uploading the file.'
      ];
    }
  } else {
    // Insert data into the database without a file path, but with the current timestamp
    $insertQuery = "INSERT INTO assignment (deskripsi, SubmissionDate, UserID, assigment, Course) VALUES (?, NOW(), ?, ?, ?)";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $detail, $id_user, $assignment, $course);

    if ($stmt->execute()) {
      $_SESSION['notification'] = [
        'type' => 'success',
        'message' => 'jawaban diterima ',
      ];
    } else {
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error inserting assignment: ' . $stmt->error
      ];
    }
    // Redirect to finished.php
    header("Location: finished.php?course=$course&material=$courseMaterial");
    exit();
  }
}

if (isset($_POST['edit_tugas'])) {
  // Assuming you have sanitized and validated your form data
  $detail = $_POST["jawaban"];
  $id_user = $_POST["id_user"];
  $assignment = $_POST["id_upload"];
  $course = $_POST["course"];
  $courseMaterial = $_POST["CourseMaterial"];
  $assignmentId = $_POST["AssignmentID"];

  // File handling
  $fileName = isset($_FILES["file_material"]) ? $_FILES["file_material"]["name"] : null;
  $timestamp = time();

  // Check if a file is selected
  if (!empty($fileName)) {
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = "file_" . $timestamp . "." . $fileExtension;  // Generating a new unique filename
    $targetDir = "uploads/";  // Adjust the directory as needed
    $targetFilePath = $targetDir . $newFileName;

    // Upload file to server with the new name
    if (move_uploaded_file($_FILES["file_material"]["tmp_name"], $targetFilePath)) {
      // Update data in the database with the new file path and current timestamp
      $updateQuery = "UPDATE assignment SET deskripsi = ?, file_path = ?, SubmissionDate = NOW() WHERE AssignmentID = ?";

      $stmt = $conn->prepare($updateQuery);
      $stmt->bind_param("sss", $detail, $targetFilePath, $assignmentId);

      if ($stmt->execute()) {
        $_SESSION['notification'] = [
          'type' => 'success',
          'message' => 'Success update jawaban',
        ];
      } else {
        $_SESSION['notification'] = [
          'type' => 'danger',
          'message' => 'Error updating assignment: ' . $stmt->error
        ];
      }
    } else {
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error uploading the file.'
      ];
    }
  } else {
    // Update data in the database without changing the file path, but with the current timestamp
    $updateQuery = "UPDATE assignment SET deskripsi = ?, SubmissionDate = NOW() WHERE AssignmentID = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ss", $detail, $assignmentId);

    if ($stmt->execute()) {
      $_SESSION['notification'] = [
        'type' => 'success',
        'message' => 'Success update jawaban',
      ];
    } else {
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error updating assignment: ' . $stmt->error
      ];
    }
  }

  header("Location: finished.php?course=$course&material=$courseMaterial");
  exit();
}
