<?php
    // Process login form and set cookie on successful login    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST["username"];
      $password = $_POST["password"];
      try {
        $pdo = new PDO('mysql:host=db.cs.dal.ca; dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

        $stmt = $pdo->prepare("SELECT * FROM Login WHERE UserName = :username;");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch the user from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password ,$user['Password'])) {
          setcookie("user", $username, time() + 3600 * 24 * 365, "/");
          header("Location: index.php");
          exit();
        } else {  
          $loginErr = "Invalid username or password!";
        }
      } 
      catch (PDOException $e) {
          $database =  "Connection failed: " . $e->getMessage();
      }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            <form method="post" action="login.php">
              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Please enter your login and password!</p>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control form-control-lg">
              </div>

              <div class="form-outline form-white mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-lg">
                <?php
                  if(isset($loginErr)){
                    echo $loginErr;
                  }
                ?>
              </div>

              <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
              <div class="mb-md-5 mt-md-4">
                  <p class="text-white-50"> Need an account?  </p>
                  <a class="text-white-50 mb-5" href="register.php"> Sign up here!</a>
              </div>
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
