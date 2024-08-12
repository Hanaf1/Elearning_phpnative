<?php
require '../function.php';
if (isset($_POST["inputNilai"])) {
  $assignmentId = $_POST["assignmentId"];
  $grade = $_POST["grade"];

  // Assuming DatabaseHandler::editData updates a row in the 'assignment' table
  $updatedRowCount = DatabaseHandler::editData('assignment', ['Grade' => $grade], 'AssignmentID', $assignmentId);

  if ($updatedRowCount > 0) {
    // Grade updated successfully
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Grade updated successfully!'
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error when updating grade'
    ];
  }

  // Redirect back to the detailAssignment.php page
  header("Location: detailAssignment.php?assignment=$assignmentId");
  exit();
}
