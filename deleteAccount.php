<?php
    try{
        $pdo = new PDO('mysql:host=db.cs.dal.ca; dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

        $stmt = $pdo->prepare("DELETE FROM Customers WHERE UserID = :userID;");
        $stmt->bindParam(':userID', $_COOKIE['user']);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM Login WHERE UserName = :username;");
        $stmt->bindParam(':username', $_COOKIE['user']);
        $stmt->execute();

        include 'logout.php';

        header("Location: index.php");
        exit();
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>