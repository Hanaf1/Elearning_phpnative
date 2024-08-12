<?php
session_start();
require 'function.php';

if (isset($_POST["add_assignment"])) {
  $courseID = $_POST["CourseID"];
  $title = $_POST["Title"];
  $description = $_POST["description"]; // Assuming Trix editor stores content in 'description'
  $deadline = $_POST["deadline"];
  $CourseName = $_POST["CourseMaterial"];
  $userId = $_POST["user_id"]; // You need to replace this with the actual user ID

  // File upload
  $fieldName = 'file_path';
  $uploadDirectory = 'uploads/';

  // Initialize file path
  $filePath = null;

  // Check if a file is uploaded
  if ($_FILES[$fieldName]['size'] > 0) {
    $filePath = DatabaseHandler::uploadFile($fieldName, $uploadDirectory, $userId);

    if (!is_string($filePath)) {
      // File upload failed
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => $filePath // Contains the error message from uploadFile method
      ];

      // Redirect back to the tugas.php page
      header("Location: teacher/tugas.php?course=$courseID&material=$CourseName");
      exit();
    }
  }

  // Explicitly set $filePath to NULL if no file is uploaded
  if ($filePath === null) {
    $filePath = NULL;
  }

  // Proceed with database insertion
  $insertQuery = "INSERT INTO upload_assignment (CourseID, Title, deksripsi, file_path, upload_time, Deadline) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?)";
  $stmt = $conn->prepare($insertQuery);

  // Format the deadline before binding
  $deadline = date('Y-m-d', strtotime($deadline));

  $stmt->bind_param("issss", $courseID, $title, $description, $filePath, $deadline);

  if ($stmt->execute()) {
    // Assignment added successfully
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Assignment added successfully!'
    ];
  } else {
    // Error adding assignment
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error when adding assignment: ' . $stmt->error
    ];
  }

  $stmt->close();
  $conn->close();

  // Redirect back to the tugas.php page
  header("Location: teacher/tugas.php?course=$courseID&material=$CourseName");
  exit();
}