<?php

    try {
        $pdo = new PDO('mysql:host=db.cs.dal.ca;dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

?>
