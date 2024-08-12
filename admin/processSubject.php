<?php

require('../function.php');

// Add subject
if (isset($_POST['tambahPelajaran'])) {
  $level = $_POST['level'];
  $subject = $_POST['subjectSelect'];

  // Perform the database query to add a new class using prepared statements
  $addClassQuery = "INSERT INTO course(CourseName, StudyLevelID) VALUES (?, ?)";
  $stmt = $conn->prepare($addClassQuery);

  if ($stmt) {
    $stmt->bind_param("ii", $subject, $level); // Assuming both columns are integers

    $addClassResult = $stmt->execute();

    if ($addClassResult) {
      $_SESSION['notification'] = [
        'type' => 'success',
        'message' => 'Class added successfully.',
      ];
    } else {
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error adding class: ' . $stmt->error,
      ];
    }

    $stmt->close();
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error preparing statement: ' . $conn->error,
    ];
  }

  header("Location: subject.php?material=$level");
  exit();
}


// Delete Class
if (isset($_POST['deleteSubject'])) {
  $courseId = $_POST['course_id'];
  $levelClass = $_POST['level'];
  $deleteClassQuery = "DELETE FROM course WHERE CourseID = '$courseId'";
  $deleteClassResult = $conn->query($deleteClassQuery);

  if ($deleteClassResult) {
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Class deleted successfully.',
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error deleting class: ' . $conn->error,
    ];
  }
  // Redirect to the page displaying classes
  header("Location: subject.php?material=$levelClass");
  exit();
}





?>