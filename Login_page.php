<?php

session_start();

    include ("classes/connection.php");
    include ("classes/C_signup.php");
    include ("classes/C_login.php");
    
    $stud_ID = "";
    $firstName = "";
    $lastName = "";
    $password = "";
    $email = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') 
    {   
      if (isset($_POST['login_button'])) {
        // Handle login form submission
        $login = new Login();
        $result = $login->evaluate($_POST);

        if ($result != "") {
            echo "<div class='error'>";
            echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
            print_r($result);
            echo "</div>";
        } else {
            header("Location: Profile_page.php"); // Redirect to the login section on the same page
            die;
        }
    } elseif (isset($_POST['signup_button'])) {
        // Handle signup form submission
        $signup = new Signup();
        $result = $signup->evaluate($_POST);

        if ($result != "") {
            echo "<div class='error'>";
            echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
            print_r($result);
            echo "</div>";
        } else {
            header("Location: Login_page.php#login-form"); // Redirect to the signup section on the same page
            die;
        }
    }

    // Access other form fields only if they are set
      if (isset($_POST['stud_ID'])) {
          $stud_ID = $_POST['stud_ID'];
      }
      if (isset($_POST['firstName'])) {
          $firstName = $_POST['firstName'];
      }
      if (isset($_POST['lastName'])) {
          $lastName = $_POST['lastName'];
      }
      if (isset($_POST['password'])) {
        $password = $_POST['password'];
      }
      if (isset($_POST['email'])) {
          $email = $_POST['email'];
      }

       // echo "<pre>";
       // print_r($result);
      //echo "</pre>";

    }
?>
 <!--==HTML==-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title> BisuConnect | Login </title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Info's--> 
    <title>BisuConnect</title>
    <meta name="author" content="Mike Joshua Lopena, Kurt Trunks Canabe,Mikee Samantha Gamorot, Jan Andrew Paul Maylon">
    <meta name="description" content="TE  03/ Cognate Elective">
    <meta name="keywords" content="BisuConnect, Bisuan, Website">
    <meta name="referrer" content="no-referrer">
    <link rel="stylesheet" type="text/css" href="style/login_style.css">
    <link rel="shortcut icon" type="x-icon" href="images/logo.png">

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
  </head>

  <body>
      <!-- LOADING PAGE-->

    <!--header design-->
      <header class="header">
        <img src="images/BISU.png" alt="logo" id="logo">
        <a href="#" class="logo"> BisuConnect</a>
      </header>  

      <?php include("loading.php"); ?>
    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
          <div class="front">
            <img src="images/BISU1-01.png" alt="">
            <div class="text">
              <span class="text-1"> "WELCOME BISUAN" <br> Step into the spotlight and let your talent shine!</span>
              <span class="text-2">Let's get connected</span>
            </div>
          </div>
          <div class="back">
            <img class="backImg" src="images/BISU1-01.png" alt="">
          </div>
        </div>


        <div class="forms">
          <div class="form-content">

              <div class="login-form" id="login-form">
                  <div class="title">Login</div>
                  <form method="post" id="login-form" onsubmit="return validateEmail();"> <!-- put name so php can fetch the data-->
                    <div class="input-boxes">
                      <div class="input-box">
                        <i class="fas fa-envelope"></i>
                        <input value="<?php echo $email?>" name="email" type="text" id="login-email" placeholder="Enter your email" >
                      </div>
                      <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input value="<?php echo $password?>" name="password" type="password"  placeholder="Enter your password">
                      </div>
                      <div class="text">
                        <a href="https://www.facebook.com/profile.php?id=100021077883020" target="_blank">contact administrator</a>
                      </div>
                      <div class="button input-box" >
                        <input name="login_button" type="submit" value="Login"> <!-- Submit type only work if nested from form tag-->
                      </div>
                      <div class="text sign-up-text">Don't have an account? <label for="flip">Sign up now</label></div>
                    </div>
                </form>

              </div>

              <div class="signup-form" id="signup-form"> 
                <div class="title">Sign up</div>
                <form method="post" action="#" id="signup-form" onsubmit="return validateEmail('signup-form');">
                    <div class="input-boxes">
                      <div class="input-box">
                        <i class="fas fa-user"></i>
                        <input value="<?php echo $firstName?>" name="firstName" type="text" placeholder="Enter your firstname">
                      </div>
                      <div class="input-box">
                        <i class="fas fa-user"></i>
                        <input value="<?php echo $lastName?>"name="lastName" type="text" placeholder="Enter your lastname">
                      </div>
                      <!-- gender-->
                      <div class="input-box">
                        <select value="<?php echo $gender?>" name="gender" class="round">
                          <option>Male</option>
                          <option>Female</option>
                        </select>
                      </div>
                      <!--end of gender-->
                      <div class="input-box">
                        <i class="fas fa-envelope"></i>
                        <input value="<?php echo $email?>"name="email" type="text" id="signup-email" placeholder="Enter your email" >
                      </div>
                      <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input value="<?php echo $password?>" name="password" type="password" placeholder="Enter your password">
                      </div>
                      <div class="input-box">
                        <i class="fas fa-id-card"></i>
                        <input value="<?php echo $stud_ID?>" name="stud_ID" type="number" placeholder="Enter your university ID">
                      </div>
                      <div class="button input-box">
                        <input  name="signup_button" type="submit" value="Sign up">
                      </div>
                      <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                    </div>
              </form>
            </div>
          </div>
        </div>
    </div>


    <script>
        // JavaScript function to validate email before form submission
        function validateEmail() {
            // Get the email input field value
            var Login_emailInput = document.getElementById("login-email").value;
            var Signup_emailInput = document.getElementById("signup-email").value;

            // Check if the email ends with "@bisu.edu.ph"
            if (Login_emailInput.endsWith("@bisu.edu.ph") || Signup_emailInput.endsWith("@bisu.edu.ph")) {
                return true; // Allow form submission
            } else {
                // Display an error message (you can modify this part)
                alert("Invalid Email . Please use the university email @bisu.edu.ph");
                return false; // Prevent form submission
            }
        }
    </script>

        <!--=== Script for loading ====-->

      <script>
        $(window).on('load', function(){
          $(".spinner-parent").fadeOut(1010);
          $(".container").fadeIn(1010);
        })
      </script>
  
   
  </body>
</html>

