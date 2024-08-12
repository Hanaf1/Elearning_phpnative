<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

require('function.php');

if (isset($_POST["add_material"])) {
  $courseID = $_POST["CourseID"];
  $title = $_POST["Title"];
  $material = $_POST["material"]; // Assuming Trix editor stores content in 'material'
  $urlVideo = $_POST["url_video"];
  $CourseName = $_POST["CourseMaterial"];

  // Check if a new file is uploaded
  $file_path = ''; // Initialize the file_path variable

  if ($_FILES['file_path']['size'] > 0) {
    // Handle file upload
    $file_path = DatabaseHandler::uploadFile('file_path', 'uploads/', $CourseName);

    if (!is_string($file_path)) {
      // Handle file upload error
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error uploading file: ' . $file_path
      ];
      header("Location: subject.php?course=$courseID&material=$CourseName");
      exit();
    }
  }

  // Insert material into the database with file_path
  $insertQuery = "INSERT INTO material (Title, Content, CourseID, file_path, url_video) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($insertQuery);

  // Create a variable for file_path to pass by reference
  $file_path_reference = $file_path;

  if (!empty($file_path)) {
    // Bind parameters with file_path
    $stmt->bind_param("ssiss", $title, $material, $courseID, $file_path_reference, $urlVideo);
  } else {
    // Bind parameters without file_path
    $stmt->bind_param("sssis", $title, $material, $courseID, $file_path_reference, $urlVideo);
  }

  if ($stmt->execute()) {
    // Material added successfully
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Material added successfully!'
    ];
  } else {
    // Error adding material
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error adding material: ' . $stmt->error
    ];
  }

  $stmt->close();

  $conn->close();

  // Redirect back to the subject.php page
  header("Location: teacher/subject.php?course=$courseID&material=$CourseName");
  exit();
}



if (isset($_POST['change_material'])) {
  $materialID = $_POST['MaterialID'];
  $courseID = $_POST['CourseID'];
  $title = $_POST['Title'];
  $material = $_POST['material'];
  $url_video = $_POST['url_video'];
  $CourseName = $_POST['CourseMaterial'];

  // Check if a new file is uploaded
  $file_path = ''; // Initialize the file_path variable

  if ($_FILES['file_path']['size'] > 0) {
    // Handle file upload
    $file_path = DatabaseHandler::uploadFile('file_path', 'uploads/', $CourseName);

    if (!is_string($file_path)) {
      // Handle file upload error
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error uploading file: ' . $file_path
      ];
      header("Location: teacher/subject.php?course=$courseID&material=$CourseName");
      exit();
    }
  }

  // Update the material in the database
  $updateMaterialQuery = "UPDATE material SET Title=?, Content=?, url_video=? WHERE MaterialID=?";

  if (!empty($file_path)) {
    // If a new file is uploaded, include it in the update query
    $updateMaterialQuery = "UPDATE material SET Title=?, Content=?, file_path=?, url_video=? WHERE MaterialID=?";
  }

  $stmt = $conn->prepare($updateMaterialQuery);

  if (!empty($file_path)) {
    // Bind parameters with file_path
    $stmt->bind_param("ssssi", $title, $material, $file_path, $url_video, $materialID);
  } else {
    // Bind parameters without file_path
    $stmt->bind_param("sssi", $title, $material, $url_video, $materialID);
  }

  if ($stmt->execute()) {
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Material updated successfully!'
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error updating material: ' . $stmt->error
    ];
  }

  $stmt->close();
  $conn->close();

  header("Location: teacher/subject.php?course=$courseID&material=$CourseName");
  exit();
}

if (isset($_POST['changeAssignmentGuru'])) {
  $courseID = $_POST['CourseID'];
  $title = $_POST['Title'];
  $description = $_POST['description'];
  $deadline = $_POST['deadline'];
  $CourseName = $_POST['CourseMaterial'];
  $uploadId = $_POST['uploadID'];

  // Check if a new file is uploaded
  $file_path = ''; // Initialize the file_path variable

  if ($_FILES['file_path']['size'] > 0) {
    // Handle file upload
    $file_path = DatabaseHandler::uploadFile('file_path', 'uploads/', $CourseName);

    if (!is_string($file_path)) {
      // Handle file upload error
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Error uploading file: ' . $file_path
      ];
      header("Location: teacher/subject.php?course=$courseID&material=$CourseName");
      exit();
    }
  }

  // Update the assignment in the database
  $updateAssignmentQuery = "UPDATE upload_assignment SET Title=?, deksripsi=?, Deadline=?, file_path=?, upload_time=NOW() WHERE upload_id=?";

  $stmt = $conn->prepare($updateAssignmentQuery);

  // Dynamically bind parameters
  $params = [$title, $description, $deadline, $file_path, $uploadId];
  $paramTypes = str_repeat('s', count($params));  // Assuming all parameters are strings

  $stmt->bind_param($paramTypes, ...$params);

  if ($stmt->execute()) {
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Assignment updated successfully!'
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error updating assignment: ' . $stmt->error
    ];
  }

  $stmt->close();
  $conn->close();

  header("Location: teacher/tugas.php?course=$courseID&material=$CourseName");
  exit();
}
