<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Mini Reads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php
    try {
        $pdo = new PDO('mysql:host=db.cs.dal.ca; dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

        $stmt = $pdo->prepare("SELECT * FROM Customers WHERE UserID = :userID;");
        $stmt->bindParam(':userID', $_COOKIE['user']);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM Login WHERE UserName = :username;");
        $stmt->bindParam(':username', $_COOKIE['user']);
        $stmt->execute();

        $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) {
        echo  "Connection failed: " . $e->getMessage();
    }
?>



<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card bg-dark text-white mb-4" style="border-radius: 1rem">
            <div class="card-body pb-4">
                <h1 class="pb-4 pt-4">
                    <?php
                        echo $_COOKIE['user']. "'s Profile";
                    ?>    
                </h1>
                <table class="table table-dark">
                    <tbody>
                        <tr>
                        <th> First Name </th>
                        <td>
                        <?php
                            echo $user['FirstName'];
                        ?>
                        </td>
                        </tr>
                        <tr>
                        <th> Last Name </th>
                        <td>
                        <?php
                            echo $user['LastName'];
                        ?>
                        </td>
                        </tr>
                        <tr>
                        <th> Address </th>
                        <td>
                        <?php
                            echo $user['Address'];
                        ?>
                        </td>
                        </tr>
                        <tr>
                        <th> City </th>
                        <td>
                        <?php
                            echo $user['City'];
                        ?>
                        </td>
                        </tr>
                        <tr>
                        <th> Zip Code </th>
                        <td>
                        <?php
                            echo $user['ZipCode'];
                        ?>
                        </td>
                        </tr>
                        <tr>
                        <th> Email </th>
                        <td>
                        <?php
                            echo $userEmail['Email'];
                        ?>
                        </td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn btn-outline-light" href="index.php"> Homepage </a>
                <a class="btn btn-outline-light" href="updateProfile.php"> Update Profile </a>
                <a class="btn btn-outline-light" href="updatePassword.php"> Update Password </a>
                <a class="btn btn-outline-danger" href="deleteAccount.php"> Delete Account </a>
            </div>
            </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
