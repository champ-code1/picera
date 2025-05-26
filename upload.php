<?php
header('Content-Type: application/json');

$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            if (in_array($file['type'], $allowedTypes)) {
                if ($file['size'] <= $maxFileSize) {
                    $uploadDir = 'images/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = basename($file['name']);
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'File size exceeds limit.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Upload error.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
} 