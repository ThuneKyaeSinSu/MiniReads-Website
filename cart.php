<?php
    session_start(); // Start the session
    include 'includes/booklist.php';

    // Check if the shopping cart array is not initialized in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array(); // Initialize the shopping cart as an empty array
    }

    // Check if the buy action is triggered
    if (isset($_GET['action']) && $_GET['action'] == 'buy' && isset($_GET['id'])) {
        $bookId = intval($_GET['id']);
        echo $bookId;
        // Find the selected book
        $selectedBook = null;
        foreach ($books as $book) {
            if ($book['id'] == $bookId) {
                $selectedBook = $book;
                break;
            }
        }

        // Check if the book is already in the cart
        $inCart = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] == $selectedBook['id']) {
                $cartItem['quantity']++;
                $inCart = true;
                break;
            }
        }

        // If not in the cart, add the selected book with quantity 1
        if (!$inCart) {
            $selectedBook['quantity'] = 1;
            $_SESSION['cart'][] = $selectedBook;
        }
    }

    // Check if the delete action is triggered
    if (isset($_POST['delete'])) {
        // Clear the shopping cart
        $_SESSION['cart'] = array();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container justify-content-center">
        <?php
            include 'includes/header.php';
            echo '<div class="card bg-dark text-white mb-4" style="border-radius: 1rem;">';
            echo '<div class="card-body">';
            echo '<h1>Shopping Cart</h1>';
            if (empty($_SESSION['cart'])) {
                echo '<p>Your shopping cart is empty.</p>';
            } else {
                echo '<p>You have ' . count($_SESSION['cart']) . ' items in your shopping cart.</p>';
                echo '<table class="table table-dark">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Item</th>';
                echo '<th scope="col">Quantity</th>';
                echo '<th scope="col">Price</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $item) {
                    echo '<tr>';
                    echo '<td>' . $item['title'] . '</td>';
                    echo '<td>' . $item['quantity'] . '</td>';
                    $price = substr($item['price'], 1);
                    echo '<td>$' . floatval($price) * $item['quantity'] . '</td>';
                    echo '</tr>';
                    
                    $totalPrice += floatval($price) * $item['quantity'];
                }
                

                echo '</tbody>';
                echo '</table>';
                echo '<p>Total Price: $' . number_format($totalPrice, 2) . '</p>';
                echo '<form method="post" action="cart.php">';
                echo '<button type="submit" class="btn btn-outline-danger" name="delete">Delete All Items</button>';
                echo '</form>';
            }
            echo '<a class="btn btn-outline-light mt-3" href="index.php"> Homepage </a>';
            echo '</div></div>';
        ?>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
