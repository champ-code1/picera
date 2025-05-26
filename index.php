<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picera Photo Album</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Picera Photo Album</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="image" accept=".jpg, .jpeg, .png" required>
        <button type="submit">Upload Image</button>
    </form>
    <div id="gallery">
        <?php
        $images = glob('images/*.{jpg,jpeg,png}', GLOB_BRACE);
        $imagesPerPage = 6;
        $totalImages = count($images);
        $totalPages = ceil($totalImages / $imagesPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, min($currentPage, $totalPages));
        $startIndex = ($currentPage - 1) * $imagesPerPage;
        $endIndex = min($startIndex + $imagesPerPage, $totalImages);
        for ($i = $startIndex; $i < $endIndex; $i++) {
            echo '<div class="image-container">';
            echo '<img src="' . $images[$i] . '" alt="Image">';
            echo '</div>';
        }
        ?>
    </div>
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
        <?php endif; ?>
        <span>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></span>
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
    <script src="script.js"></script>
</body>
</html> 