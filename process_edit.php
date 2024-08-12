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
        $_SESSION['notification'] = "Invalid file format. Please upload a JPG, JPEG, or PNG file.";
        header("Location: setting.php");
        exit();
    }

    $newImagePath = DatabaseHandler::updateImage($fileField, $uploadDirectory, $idPengguna, $oldPhoto);

    if (is_string($newImagePath) && strpos($newImagePath, 'error') !== false) {
        // An error occurred during the image update
        $_SESSION['notification'] = $newImagePath;
    } else {
        // Only delete the old photo if the update was successful
        if (!empty($oldPhoto)) {
            unlink($oldPhoto); // This will delete the file
        }

        // Update the database with the new photo path
        $queryUpdatePhoto = "UPDATE users SET photo = '$newImagePath' WHERE id_user = $idPengguna";
        $conn->query($queryUpdatePhoto);

        // Success message
        $_SESSION['notification'] = "Profile photo updated successfully.";
    }

    // Redirect to the setting page
    header("Location: setting.php");
    exit();
}


if (isset($_POST['edit_tugas'])) {
    $id = $_POST['AssignmentID'];

    // Upload and update the OBS images
    $fileFields = 'file_path';
    $uploadDirectory = 'uploads/';
    $uploadedImages = DatabaseHandler::updateImage($fileFields, $uploadDirectory, $id, $_POST['previous_image']);

    $extension = strtolower(pathinfo($uploadedImages, PATHINFO_EXTENSION));
    // Define an array of allowed extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

    if (in_array($extension, $allowedExtensions)) {
        $dataToUpdate = [
            'Title' => isset($_POST['title_material']) ? $_POST['title_material'] : null,
            'deskripsi' => isset($_POST['jawaban']) ? $_POST['jawaban'] : null,
            'file_path' => isset($uploadedImages) ? $uploadedImages : null,
            'SubmissionDate' => isset($_POST['published']) ? $_POST['published'] : null,
            'UserID' => isset($_POST['id_user']) ? $_POST['id_user'] : null,
            'assigment' => isset($_POST['id_upload']) ? $_POST['id_upload'] : null,
            'Course' => isset($_POST['course']) ? $_POST['course'] : null,
        ];

        $affectedRows = DatabaseHandler::editData('assignment', $dataToUpdate, 'AssignmentID', $id);
        if ($affectedRows > 0) {
            $_SESSION['notification'] = "Data has been updated.";
            header("Location: finished.php?course=" . $_POST['course']);
            exit;
        } else {
            $_SESSION['notification'] = "An error occurred while processing the form.";
        }
    } else {
        $_SESSION['notification'] = $uploadedImages;
    }

    // Redirect to finished.php with the course parameter
    header("Location:finished.php?course=" . $_POST['course']);
    exit;
}
