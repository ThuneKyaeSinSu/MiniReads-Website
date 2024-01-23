<?php
    function clean($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    function validateFirstName($input){
        $firstName_pattern = "/^[a-z ,.'-]+$/i";
        if (!preg_match($firstName_pattern, $input)) {
            return "Please input a valid first name.";
        }
        else{
            return '';
        }
    }
    
    function validateLastName($input){
        $lastName_pattern = "/[A-Z a-z]+[-|']?[A-Z a-z]+/";
        if (!preg_match($lastName_pattern, $input)){
            return "Please input a valid last name";
        }
        else{
            return '';
        }
    }

    function validatePassword($input){
        $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/";
        if (!preg_match($password_pattern, $input)){
            return "Password must be at least 12 letters with one uppercase, one lowercase, one number and one special character.";
        }
        else{
            return '';
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $password = $_POST["password"];
        $confirm = $_POST["confirmPassword"];

        if (empty($firstName)) {
            $firstNameErr = "First Name is required";
        } else {
            $firstName = clean($firstName);
            $firstNameErr = validateFirstName($firstName);
        }
        
        if (empty($lastName)) {
            $lastNameErr = "Last Name is required";
        } else {
            $lastName = clean($lastName);
            $lastNameErr = validateLastName($lastName);
        }

        if (empty($email)) {
            $emailErr = "Email is required";
        } else {
            $email = clean($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email";
            }
        }

        if (empty($password)) {
            $passwordErr = "Password is required";
        } else {
            $passwordErr = validatePassword($password);
        }

        if (empty($confirm)) {
            $confirmErr = "Password is required";
        } else {
            if ($password != $confirm) {
                $confirmErr = "Passwords in both fields must match.";
            }
        }
        
        if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmErr)) {
            try {
                $pdo = new PDO('mysql:host=db.cs.dal.ca; dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');
        
                // Set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec('SET NAMES "utf8"');
                
                //Encrypt password
                $password = password_hash($password, PASSWORD_BCRYPT);
                
                // Prepare the SQL statement
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                ];
                
                $stmt = $pdo->prepare("INSERT INTO Login (UserName, Email, Password) VALUES (:username, :email, :password);");
                $stmt->execute($data);

                $data = [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'userID' => $username,
                ];
                $stmt = $pdo->prepare("INSERT INTO Customers (FirstName, LastName, UserID) VALUES (:firstName, :lastName, :userID);");
                $stmt->execute($data);
    
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                echo  "Connection failed: " . $e->getMessage();
            }
            
            
        }
        
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini Reads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-7 col-lg-8 col-xl-9">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">
            <form method="post" action="register.php">
              <h2 class="fw-bold mb-2 text-uppercase">Register User</h2>
              <p class="text-white-50 mb-5">Please enter your username and password!</p>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control form-control-lg">

              </div>
            
              <div class="form-outline form-white mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg">
                <?php
                    if(isset($emailErr)) {
                        echo $emailErr;
                    }
                ?>
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control form-control-lg">
                <?php
                    if(isset($firstNameErr)) {
                        echo $firstNameErr;
                    }
                ?> 
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control form-control-lg">
                <?php
                    if(isset($lastNameErr)) {
                        echo $lastNameErr;
                    }
                ?>
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-lg">
                <?php
                    if(isset($passwordErr)) {
                        echo $passwordErr;
                    }
                ?>
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-lg">
                <?php
                    if(isset($confirmErr)) {
                        echo $confirmErr;
                    }
                ?>
              </div>

              <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>
            </form>
            </div>
            <a class="btn btn-outline-light float-start" href="index.php"> Homepage </a>
          </div>
        </div>
      </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
