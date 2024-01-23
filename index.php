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
        session_start();
    ?>
    <div class="row">
        <?php
            include 'includes/booklist.php';

            foreach ($books as $book) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card h-100 text-dark bg-dark mb-3">';
                echo '<a href="book.php?id=' . $book['id'] . '">';
                echo '<img src="' . $book['image'] . '" class="card-img-top" alt="' . $book['title'] . '">';
                echo '</a>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $book['title'] . '</h5>';
                echo '<p class="card-text">By ' . $book['author'] . '</p>';
                echo '<form method="post" action="cart.php?action=buy&id=' . $book['id'] . '">';
                echo '<button type="submit" class="btn btn-outline-light" name="buy">Buy</button>';
                echo '</form>';
                echo '</div></div></div>';
            }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
