<?php
    function clean($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
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
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["newPassword"];

        if (empty($oldPassword)) {
            $oldPasswordErr = "Enter your old Password!";
        } else {
            if (empty($newPassword)){
                $newPasswordErr = "Enter your new Password!";
            }
            else{
                $newPasswordErr = validatePassword($newPassword);
            }
        }
        
        
        if (empty($oldPasswordErr) && empty($newPasswordErr)) {
            try {
                $pdo = new PDO('mysql:host=db.cs.dal.ca; dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');
        
                // Set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec('SET NAMES "utf8"');
                
                $stmt = $pdo->prepare("SELECT * FROM Login WHERE UserName = :username;");
                $stmt->bindParam(':username', $_COOKIE['user']);
                $stmt->execute();

                // Fetch the user from the database
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify the password and update if password matches
                if ($user && password_verify($oldPassword ,$user['Password'])) {
                    $newPassword = password_hash($newPassword, PASSWORD_BCRYPT); 
                    $data = [
                        'newPassword' => $newPassword,
                        'username' => $_COOKIE['user'],
                    ];
                    $stmt = $pdo->prepare("UPDATE Login SET Password = :newPassword WHERE UserName = :username;");
                    $stmt->execute($data);

                    $oldPasswordErr = "Your Password has been updated!";
                } else {  
                    $oldPasswordErr = "Your old Password is incorrect!";
                }
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
            <form method="post" action="updatePassword.php">
              <h2 class="fw-bold mb-2 text-uppercase">Update Password</h2>
              <p class="text-white-50 mb-5">Please enter old password and your new password!</p>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="oldPassword">Old Password:</label>
                <input type="text" name="oldPassword" id="oldPassword" class="form-control form-control-lg">

              </div>
            
              <div class="form-outline form-white mb-4">
                <label class="form-label" for="newPassword">New Password</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control form-control-lg">
                <?php
                    if(isset($oldPasswordErr)) {
                        echo $oldPasswordErr;
                    }
                    if (isset($newPasswordErr)){
                        echo $newPasswordErr;
                    }
                ?>
              </div>

              <button class="btn btn-outline-light btn-lg px-5" type="submit">Submit</button>
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
