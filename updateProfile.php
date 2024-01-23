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

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $input = $_POST['inputData'];
        $selectedValue = $_POST['updateType'];
        $selectedValue = clean($selectedValue);
        if (empty($selectedValue)) {
            $optionErr = "Please select an option to update.";
        }
        else if (empty($input)){
            $optionErr = "Please fill out your new " . $selectedValue;
        }
        else{
            if ($selectedValue == "FirstName"){
                $inputErr = validateFirstName($input);
            }
            else if ($selectedValue == "LastName"){
                $inputErr = validateLastName($input);
            }
            try {
                $pdo = new PDO('mysql:host=db.cs.dal.ca; dbname=tkssu', 'tkssu', 'dbnMsJZuviYpwwznbraHvtZjV');
        
                // Set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec('SET NAMES "utf8"');

                $data = [
                    'input' => $input,
                    'userID' => $_COOKIE['user'],
                ];
                $stmt = $pdo->prepare("UPDATE Customers SET $selectedValue = :input WHERE UserID = :userID;");
                $stmt->execute($data);

                $updateStatus = "Your profile has been updated!";
            }
            catch (PDOException $e){
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
            <form method="post" action="updateProfile.php">
              <h2 class="fw-bold mb-2 text-uppercase">Update User Profile</h2>
              <p class="text-white-50 mb-5">Please enter your new profile details</details></p>
                    <div class="mb-3">
                    <?php
                        if (isset($optionErr)){
                            echo $optionErr;
                        }
                        if (isset($inputErr)){
                            echo $inputErr;
                        }
                        if (isset($updateStatus)){
                            echo $updateStatus;
                        }
                    ?>
                    <label for="updateType" class="form-label">Select which detail you would like to update:</label>
                    <select class="form-select" id="updateType" name="updateType">
                        <option value="">Select...</option>
                        <option value="FirstName">First Name</option>
                        <option value="LastName">Last Name</option>
                        <option value="Address">Address</option>
                        <option value="City"> City </option>
                        <option value="Zipcode">ZipCode</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label for="inputData" class="form-label">Fill out the new details:</label>
                    <input type="text" class="form-control" id="inputData" name="inputData">
                    </div>
                    
                    <button type="submit" class="btn btn-outline-light">Submit</button>
            </form>
            </div>   
            <a class="btn btn-outline-light float-start" href="index.php"> Homepage </a>
            <a class="btn btn-outline-light float-start" href="profile.php"> View Profile </a>         
          </div>
        </div>
      </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>