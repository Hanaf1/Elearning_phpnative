<?php
session_start();
require '../function.php';

if (isset($_POST["deleteAssignment"])) {
  $courseID = $_POST["CourseID"];
  $UploadID = $_POST["UploadID"]; // Assuming you have a MaterialID to uniquely identify the material to be deleted
  $CourseName = $_POST["CourseMaterial"];
  // Delete material from the database
  $deleteQuery = "DELETE FROM upload_assignment WHERE upload_id = ?";
  $stmt = $conn->prepare($deleteQuery);

  if ($stmt) {
    $stmt->bind_param("i", $UploadID); // Assuming MaterialID is an integer, adjust the type accordingly

    if ($stmt->execute()) {
      // Deletion successful
      $_SESSION['notification'] = [
        'type' => 'success',
        'message' => 'Material deleted successfully!'
      ];
    } else {
      // Deletion error
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error deleting material: ' . $stmt->error // Add specific error message
      ];
    }

    $stmt->close();
  } else {
    // Handle case where $stmt is not a valid prepared statement
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error preparing statement'
    ];
  }
  $conn->close();
  // Redirect back to the subject.php page
  header("Location: tugas.php?course=$courseID&material=$CourseName");
  exit();
}







?>