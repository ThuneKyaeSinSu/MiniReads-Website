<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Mini Reads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container justify-content-center">
    <?php
    include 'includes/header.php';
    include 'includes/booklist.php';

    $bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Find the selected book
    $selectedBook = null;
    foreach ($books as $book) {
        if ($book['id'] == $bookId) {
            $selectedBook = $book;
            break;
        }
    }

    if (!is_null($selectedBook)) {
        echo '<div class="card bg-dark text-white mb-4" style="border-radius: 1rem;">';
        echo '<img class="cover rounded mx-auto d-block" src="' . $selectedBook['image'] . '" alt="' . $selectedBook['title'] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $selectedBook['title'] . '</h5>';
        echo '<p class="card-text">By ' . $selectedBook['author'] . '</p>';
        echo '<p class="card-text"> Genre: ' . $selectedBook['genre'] . '</p>';
        echo '<p class="card-text"> Publication Year: ' . $selectedBook['publication year'] . '</p>';
        echo '<p class="card-text"> ISBN: ' . $selectedBook['isbn'] . '</p>';
        echo '<p class="card-text"> Price: ' . $selectedBook['price'] . '</p>';
        echo '<a class="btn btn-outline-light" href="index.php"> Homepage </a>';
        echo '<form method="post" action="cart.php?action=buy&id=' . $book['id'] . '">';
        echo '<button type="submit" class="btn btn-outline-light mt-3" name="buy">Buy</button>';            echo '</form>';
        echo '</div></div>';
    } else {
        echo '<p>Book not found.</p>';
    }
    ?>
    
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
