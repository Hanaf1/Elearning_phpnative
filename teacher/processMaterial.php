<?php
session_start();

require '../function.php';

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}




if (isset($_POST["deleteMaterial"])) {
$courseID = $_POST["CourseID"];
$materialID = $_POST["MaterialID"]; // Assuming you have a MaterialID to uniquely identify the material to be deleted
$CourseName = $_POST["CourseMaterial"];
// Delete material from the database
$deleteQuery = "DELETE FROM material WHERE MaterialID = ?";
$stmt = $conn->prepare($deleteQuery);

if ($stmt) {
    $stmt->bind_param("i", $materialID); // Assuming MaterialID is an integer, adjust the type accordingly

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
    header("Location: subject.php?course=$courseID&material=$CourseName");
    exit();
}

