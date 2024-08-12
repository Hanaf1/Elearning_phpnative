<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
require('../function.php');

if (isset($_POST["addAccount"])) {
  // Retrieve form data
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
  $role = $_POST['role'];

  // Prepare and execute the SQL query to insert the new account
  $insertUserQuery = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
  $stmtUser = $conn->prepare($insertUserQuery);
  $stmtUser->bind_param("ssss", $username, $email, $password, $role);

  if ($stmtUser->execute()) {
    // Get the auto-incremented ID from the last insert
    $userID = $stmtUser->insert_id;

    // Account added successfully
    $_SESSION['notification'] = [
      'type' => 'success',
      'message' => 'Account added successfully!'
    ];

    // Determine the redirect based on the user's role
    if ($role == 'Teacher') {
      // Redirect to the listGuru.php page
      header("Location: listGuru.php");
    } elseif ($role == 'Student') {
      // Insert data into the studyaccess table for students
      $insertStudyAccessQuery = "INSERT INTO studyaccess (userID, StudyLevelID) VALUES (?, NULL)";
      $stmtStudyAccess = $conn->prepare($insertStudyAccessQuery);
      $stmtStudyAccess->bind_param("i", $userID);

      if ($stmtStudyAccess->execute()) {
        // Redirect to the listPerson.php page
        header("Location: listPerson.php");
        exit();
      } else {
        // Error in executing the studyaccess query
        $_SESSION['notification'] = [
          'type' => 'danger',
          'message' => 'Error when adding study access'
        ];
        echo "Error: " . $stmtStudyAccess->error;
        exit();
      }
    } else {
      // Handle other roles as needed
      header("Location: addPerson.php"); // Example redirect for other roles
      exit();
    }
  } else {
    // Error in executing the user query
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Error when adding account'
    ];
    echo "Error: " . $stmtUser->error;
  }

  $stmtUser->close();
  $conn->close(); // Close the database connection
}




if (isset($_POST['updateSiswa'])) {
  $accessID = $_POST['AccessID'];
  $updatedUsername = $_POST['updatedUsername']; // Add this line

  // Update the username in the users table
  $updateUsernameQuery = "UPDATE users SET username = '$updatedUsername' WHERE id_user = $accessID";
  if ($conn->query($updateUsernameQuery) !== TRUE) {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Error updating username: ' . $conn->error);
    header("Location: listPerson.php");
    exit();
  }

  // Update the StudyLevelID in the studyaccess table
  $updatedKelas = $_POST['updatedKelas'];

  $updateQuery = "UPDATE studyaccess SET StudyLevelID = $updatedKelas WHERE AccessID = $accessID";

  if ($conn->query($updateQuery) === TRUE) {
    $_SESSION['notification'] = array('type' => 'success', 'message' => 'Siswa berhasil diupdate.');
  } else {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Error updating record: ' . $conn->error);
  }

  header("Location: listPerson.php");
  exit();
}




if (isset($_POST['deleteSiswa'])) {
  $accessID = $_POST['AccessID'];

  $deleteQuery = "DELETE FROM studyaccess WHERE AccessID = $accessID";

  if ($conn->query($deleteQuery) === TRUE) {
    $_SESSION['notification'] = array('type' => 'success', 'message' => 'Siswa berhasil dihapus.');
  } else {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Error deleting record: ' . $conn->error);
  }

  header("Location: listPerson.php");
  exit();
}


if (isset($_POST['updateGuru'])) {
  // Update operation
  $id_user = $_POST['id_user'];
  $updatedNamaGuru = $_POST['updateNamaGuru'];

  $updateQuery = "UPDATE users SET username = '$updatedNamaGuru' WHERE id_user = $id_user";
  $updateResult = $conn->query($updateQuery);

  if ($updateResult) {
    $_SESSION['notification'] = array('type' => 'success', 'message' => 'User updated successfully.');
  } else {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Failed to update user.');
  }

  header("Location: listGuru.php");
  exit();
}


if (isset($_POST['deleteGuru'])) {
  // Delete operation
  $id_user = $_POST['id_user'];

  $deleteQuery = "DELETE FROM users WHERE id_user = $id_user";
  $deleteResult = $conn->query($deleteQuery);

  if ($deleteResult) {
    $_SESSION['notification'] = array('type' => 'success', 'message' => 'User deleted successfully.');
  } else {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Failed to delete user.');
  }

  header("Location: listGuru.php");
  exit();
}


if (isset($_POST['addClass'])) {
  // Validate and sanitize the input
  $newClassName = mysqli_real_escape_string($conn, $_POST['newClassName']);

  // Insert the new class into the database
  $insertQuery = "INSERT INTO studylevel (LevelName) VALUES ('$newClassName')";

  if ($conn->query($insertQuery) === TRUE) {
    $_SESSION['notification'] = array('type' => 'success', 'message' => 'New class added successfully.');
  } else {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Error adding new class: ' . $conn->error);
  }

  header("Location: class.php");
  exit();
}



if (isset($_POST['updateClass'])) {
  // Validate and sanitize the input
  $courseId = mysqli_real_escape_string($conn, $_POST['course_id']);
  $updatedCourseName = mysqli_real_escape_string($conn, $_POST['updatedCourseName']);

  // Update the class name in the database
  $updateQuery = "UPDATE studylevel SET LevelName = '$updatedCourseName' WHERE StudyLevelID = '$courseId'";

  if ($conn->query($updateQuery) === TRUE) {
    $_SESSION['notification'] = array('type' => 'success', 'message' => 'Class updated successfully.');
  } else {
    $_SESSION['notification'] = array('type' => 'danger', 'message' => 'Error updating class: ' . $conn->error);
  }

  header("Location: class.php");
  exit();
}


if (isset($_POST['deleteClass'])) {
  $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
  $deleteQuery = "DELETE FROM studylevel WHERE StudyLevelID = '$course_id'";

  if ($conn->query($deleteQuery) === TRUE) {
    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Class deleted successfully.'];
  } else {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Error deleting class: ' . $conn->error];
  }

  header("Location: class.php");
  exit();
} else {
  $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Invalid request.'];
  header("Location: class.php");
  exit();
}


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
