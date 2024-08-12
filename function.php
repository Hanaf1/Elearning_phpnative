<?php

// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}



class DatabaseHandler
{
  private static $pdo;

  private static function createPDOConnection()
  {
    $dsn = "mysql:host=localhost;dbname=classroom";
    $username = "root";
    $password = "";

    if (!isset(self::$pdo)) {
      try {
        self::$pdo = new PDO($dsn, $username, $password);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Database Connection Error: " . $e->getMessage();
      }
    }
  }

  private static function executeQuery($query, $params)
  {
    try {
      self::createPDOConnection();
      $stmt = self::$pdo->prepare($query);
      $stmt->execute($params);
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
      return 0;
    }
  }


  public static function insertData($tableName, $data)
  {
    self::createPDOConnection();
    $columns = array_keys($data);
    $placeholders = array_map(function ($column) {
      return ":" . $column;
    }, $columns);

    $query = "INSERT INTO $tableName (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

    $stmt = self::$pdo->prepare($query);

    foreach ($data as $column => $value) {
      $stmt->bindValue(":$column", $value);
    }

    if ($stmt->execute()) {
      return true; // Query berhasil dieksekusi
    } else {
      return false; // Query gagal dieksekusi
    }
  }


  public static function insertDataWithIntegerValue($tableName, $columnName, $value)
  {
    self::createPDOConnection();

    $query = "INSERT INTO $tableName ($columnName) VALUES (:value)";

    $stmt = self::$pdo->prepare($query);
    $stmt->bindValue(":value", $value, PDO::PARAM_INT); // Bind the value as an integer

    if ($stmt->execute()) {
      return true; // Query berhasil dieksekusi
    } else {
      return false; // Query gagal dieksekusi
    }
  }

  public static function deleteData($tableName, $idColumn, $idValue)
  {
    self::createPDOConnection();

    $query = "DELETE FROM $tableName WHERE $idColumn = :idValue";

    $stmt = self::$pdo->prepare($query);

    $stmt->bindValue(":idValue", $idValue);

    try {
      if ($stmt->execute()) {
        return true; // Query berhasil dieksekusi
      } else {
        return false; // Query gagal dieksekusi
      }
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
      return false;
    }
  }


  public static function getTabel($tabel, $idColumn, $idValue)
  {
    self::createPDOConnection();

    $query = "SELECT * FROM $tabel WHERE $idColumn = :idValue";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':idValue', $idValue);

    try {
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $applicantData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $applicantData;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
      return false;
    }
  }


  public static function getAllTabel($tabel, $id)
  {
    self::createPDOConnection();

    $query = "SELECT * FROM $tabel WHERE `id_user` = :id";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $applicantData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $applicantData;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
      return false;
    }
  }

 

  public static function uploadImage($fieldName, $uploadDirectory, $userId)
  {
    if (!isset($_FILES[$fieldName])) {
      return "No file uploaded.";
    }

    $uploadedImage = $_FILES[$fieldName];
    $fileExtension = strtolower(pathinfo($uploadedImage['name'], PATHINFO_EXTENSION));
    $maxFileSize = 3 * 1024 * 1024; // 3MB in bytes

    if (!self::isValidFileExtension($fileExtension)) {
      return "Invalid file extension. Only JPG, JPEG, and PNG files are allowed.";
    }

    if ($uploadedImage['size'] > $maxFileSize) {
      return "File size exceeds the maximum allowed (3MB).";
    }

    $imageFileName = $userId . '_' . basename($uploadedImage['name']);
    $imagePath = $uploadDirectory . $imageFileName;

    if (move_uploaded_file($uploadedImage['tmp_name'], $imagePath)) {
      return $imagePath;
    } else {
      return "An error occurred while uploading the image.";
    }
  }

  private static function isValidFileExtension($extension)
  {
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    return in_array($extension, $allowedExtensions);
  }


  public static function uploadFile($fieldName, $uploadDirectory, $userId)
  {
    if (!isset($_FILES[$fieldName])) {
      return "No file uploaded.";
    }

    $uploadedFile = $_FILES[$fieldName];
    $fileExtension = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['pdf', 'pptx', 'jpeg', 'jpg', 'png'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

    if (!self::isValidFileExtensionFile($fileExtension, $allowedExtensions)) {
      return "Invalid file extension. Only PDF, PPT, JPEG, and PNG files are allowed.";
    }

    if ($uploadedFile['size'] > $maxFileSize) {
      return "File size exceeds the maximum allowed (5MB).";
    }

    $fileFileName = $userId . '_' . basename($uploadedFile['name']);
    $filePath = $uploadDirectory . $fileFileName;

    if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
      return $filePath;
    } else {
      return "An error occurred while uploading the file.";
    }
  }

  public static function isValidFileExtensionFile($fileExtension, $allowedExtensions)
  {
    return in_array($fileExtension, $allowedExtensions);
  }



  
  public static function updateImage($fileField, $uploadDirectory, $userId, $existingImage)
  {
    // Check if a new image was uploaded
    if (isset($_FILES[$fileField]) && $_FILES[$fileField]['name']) {
      $uploadedImage = $_FILES[$fileField];
      $fileExtension = strtolower(pathinfo($uploadedImage['name'], PATHINFO_EXTENSION));
      $maxFileSize = 5 * 1024 * 1024; // 3MB in bytes

      // Check if the file extension is allowed (only JPG, JPEG, PNG)
      if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
        // Check if the file size is within the allowed limit
        if ($uploadedImage['size'] <= $maxFileSize) {
          $newImageName = $userId . '_' . basename($uploadedImage['name']);
          $newImagePath = $uploadDirectory . $newImageName;

          if (move_uploaded_file($uploadedImage['tmp_name'], $newImagePath)) {
            // Delete the existing image if it exists
            if (file_exists($existingImage)) {
              unlink($existingImage);
            }
            return $newImagePath; // Return the path to the new image
          } else {
            // Handle the upload error here, e.g., return an error message
            return "An error occurred while uploading the image.";
          }
        } else {
          return "File size exceeds the maximum allowed (3MB).";
        }
      } else {
        return "Invalid file extension. Only JPG, JPEG, and PNG files are allowed.";
      }
    } else {
      // No new image uploaded, keep the existing image
      return $existingImage;
    }
  }


  public static function updatePDF($fileField, $uploadDirectory, $userId, $existingPDF)
  {
    if (isset($_FILES[$fileField]) && $_FILES[$fileField]['name']) {
      $uploadedPDF = $_FILES[$fileField];
      $fileExtension = strtolower(pathinfo($uploadedPDF['name'], PATHINFO_EXTENSION));
      $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

      if ($fileExtension === 'pdf') {
        if ($uploadedPDF['size'] <= $maxFileSize) {
          $newPDFName = $userId . '_' . basename($uploadedPDF['name']);
          $newPDFPath = $uploadDirectory . $newPDFName;

          if (move_uploaded_file($uploadedPDF['tmp_name'], $newPDFPath)) {
            if (file_exists($existingPDF)) {
              unlink($existingPDF);
            }
            return $newPDFPath;
          } else {
            return "An error occurred while moving the uploaded PDF.";
          }
        } else {
          return "File size exceeds the maximum allowed (5MB).";
        }
      } else {
        return "Invalid file extension. Only PDF files are allowed.";
      }
    } else {
      return $existingPDF;
    }
  }



  public static function addFile($fileField, $uploadDirectory, $userId, $existingPDF)
  {
    if (isset($_FILES[$fileField]) && $_FILES[$fileField]['name']) {
      $uploadedPDF = $_FILES[$fileField];
      $fileExtension = strtolower(pathinfo($uploadedPDF['name'], PATHINFO_EXTENSION));
      $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

      if ($fileExtension === 'pdf') {
        if ($uploadedPDF['size'] <= $maxFileSize) {
          $newPDFName = $userId . '_' . basename($uploadedPDF['name']);
          $newPDFPath = $uploadDirectory . $newPDFName;

          if (move_uploaded_file($uploadedPDF['tmp_name'], $newPDFPath)) {
            if (file_exists($existingPDF)) {
              unlink($existingPDF);
            }
            return $newPDFPath;
          } else {
            return "An error occurred while moving the uploaded PDF.";
          }
        } else {
          return "File size exceeds the maximum allowed (5MB).";
        }
      } else {
        return "Invalid file extension. Only PDF files are allowed.";
      }
    } else {
      return $existingPDF;
    }
  }




  public static function pratinjauPDF($filePath)
  {
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    @readfile($filePath);
  }

  public static function unduhPDF($filePath)
  {
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
  }

  public static function editData($tableName, $data, $idColumnName, $idValue)
  {
    $setStatements = [];

    foreach ($data as $column => $value) {
      $setStatements[] = "$column = :$column";
    }

    $setClause = implode(", ", $setStatements);

    $query = "UPDATE $tableName SET $setClause WHERE $idColumnName = :id";

    try {
      self::createPDOConnection();
      $stmt = self::$pdo->prepare($query);

      foreach ($data as $column => $value) {
        $stmt->bindValue(":$column", $value);
      }

      $stmt->bindValue(":id", $idValue);

      $stmt->execute();

      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
      return 0;
    }
  }

  public static function getDataByChildName($tableName, $idColumnName)
  {
    try {
      self::createPDOConnection();
      $query = "SELECT * FROM $tableName WHERE $idColumnName = :id";
      $stmt = self::$pdo->prepare($query);
      $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $childData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $childData;
      } else {
        return null;
      }
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
      return null;
    }
  }
}
