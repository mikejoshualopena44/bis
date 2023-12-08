<?php
  //print_r($_GET);

  include ("classes/autoloader.php");

  //Check if user is logged in and if numeric to secure
  //Who log_in? =($_SESSION['Bisuconnect_stud_ID']); 
  $login = new Login();
  $user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);

  //check who login //white listing to avoid sql injection
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
     $profile = new Profile();
      $profile_data = $profile-> get_profile($_GET['id']?? '');

      if(is_array( $profile_data))
      {
        $user_data = $profile_data[0];
      }
  }
 

  // For posting start here


  if($_SERVER['REQUEST_METHOD'] == "POST" ) //inserting post to db
  {
    if(isset($_POST['firstName'])){
      $settings_class = new Settings();
      $settings_class->save_settings($_POST,$_SESSION['Bisuconnect_stud_ID']);
    }else{
      $post = new Post();
      $id = $_SESSION['Bisuconnect_stud_ID'];
      $result = $post->create_post($id, $_POST,$_FILES);

      //To avoid resubmission of post when refreshing

      if($result == ""){
        header("Location: Profile_page.php");
        die;
      }else{
        echo "<div class='error' id='error-message'>";
        echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
        print_r($result);
        echo "</div>";
      }
    }
  }

  // to collect posts
  $post = new Post();
  $id = $user_data['stud_ID']; //getting from userdata to only visit other friend not access it
//  $id = $_SESSION['Bisuconnect_stud_ID'];

  // no_post??
  $posts = $post->get_posts($id, $_POST);
 
  //to collect friends
  $user = new User();


  $friends = $user->get_friends($id);

  $image_class = new Image();

  //for about me

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateIntroduction'])) {
    // Sanitize and get the new introduction
    $newIntroduction = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
    
    // Get the user ID from the session
    $user_id = $_SESSION['Bisuconnect_stud_ID'];

    // Update the introduction
    $result = $login->updateIntroduction($user_id, $newIntroduction);

    if ($result) {
        // Success: Redirect to refresh the page with the 'about' section
        header("Location: Profile_page.php?section=about");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Update failed. Please try again.";
    }
}

?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Settings </title>
    <link rel="shortcut icon" type="x-icon" href="images/logo.png">
    <link rel="stylesheet" href="style/settings_2.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

 <!-- White separator bar -->
<div class="mobile-separator"></div>
 <!-- MOBILE NAVBAR -->
 <div class="mobile-navbar">
  <ul>
    <li class="list">
      <a  href="index.php">
        <span class="mobile-icon">
          <i class='bx bx-news' ></i>
        </span>
        <span class="mobile-txt">Home</span>
      </a>
      </span>
    </li>
    <li class="list">
      <a href="#">
        <span class="mobile-icon">
          <i class='bx bx-chat' ></i>
        </span>
        <span class="mobile-txt">Messages</span>
      </a>
      </span>
    </li>
    <li class="list active">
      <a  href="Profile_page.php">
        <span class="mobile-icon">
          <i class='bx bx-user' ></i>
        </span>
        <span class="mobile-txt">Profile</span>
      </a>
      </span>
    </li>
    <li class="list">
      <a href="#">
        <span class="mobile-icon">
          <i class='bx bx-cog' ></i>
        </span>
        <span class="mobile-txt">Settings</span>
      </a>
      </span>
    </li>
    <li class="list">
      <a href="P_logout.php">
        <span class="mobile-icon">
          <i class='bx bx-log-out' ></i>
        </span>
        <span class="mobile-txt">Logout</span>
      </a>
      </span>
    </li>
    <div class="indicator"></div>
  </ul>
</div>
<!--===END OF MOBILE NAVBAR ===-->

 
  <!--COVER AREA -->
  <div class="container">
      <!--LEFT SIDEBAR-->
      <?php include("Sidebar.php"); ?>
      <!-- END OF SIDEBAR-->

  <!-- Profile Page -->
      <!-- top header -->
      <div class="profile-header">
          <h3>BisuConnect</h3>
      </div>
      <div class="profile-section">
        <div class="profile-container">
            <div class="profile-pan">
                
                <!-- user profile-->
                <div class="profile-box">
                    <!-- Cover photo-->
                    <?php
                    $image_bg = "images/main_bg.jpg"; 

                    //if image loaded to db, uplaod it to profile
                    if(file_exists($user_data['cover_image']))
                    {
                        $image_bg = $image_class->get_thumb_cover($user_data['cover_image']);
                    }
                    ?>
                    <img class="profile-bg" src="<?php echo $image_bg ?>" alt="no images">

                    <!-- Profile photo-->
                    <?php
                    $image = "images/bman1.jpg"; 
                    if($user_data['gender'] == "Female")
                    {
                        $image = "images/gman.jpg";
                    }
                    //if image loaded to db, uplaod it to profile
                    if(file_exists($user_data['profile_image']))
                    {
                        $image = $image_class->get_thumb_profile($user_data['profile_image']);
                    }
                    ?>

                    <img class="profile-dp" src="<?php echo $image ?>" alt="image_profile"> 
                    <a href="Profile_page.php?id=<?php echo $user_data['stud_ID']?>">
                    <div class="profile-name"> <!--retrieve username-->
                        <?php echo $user_data['firstName']. " ". $user_data['lastName']  ?>
                    </div>
                    </a>

                    <!-- profile Options-->
                    <br>
                <div class="menu-main">
                    <a href="settings.php?id=<?php echo $user_data['stud_ID']?>"><div class="menu-buttons"> <i class='bx bx-user-circle' > &nbsp;</i>Account</div></a>
                    <a href="settings.php?section=password&id=<?php echo $user_data['stud_ID']?>"  ><div class="menu-buttons"> <i class='bx bx-shield'> &nbsp; </i>Details and Password</div></a>
                    <a href="settings.php?section=terms_condition&id=<?php echo $user_data['stud_ID']?>"  ><div class="menu-buttons"><i class='bx bx-error-circle'> &nbsp;</i>Terms and Conditions</div></a>
                    <a href="settings.php?section=about_us&id=<?php echo $user_data['stud_ID']?>"  ><div class="menu-buttons"><i class='bx bxs-quote-right' > &nbsp;</i>About us</div></a>
                    <a href="P_logout.php"><div class="menu-buttons"><i class='bx bx-log-out' >  &nbsp;</i>Logout</div></a>
                </div>
                <br><br><br>
            <footer style="font-size: 1rem";>
                <!-- Add footer content if needed -->
                &copy; 2023 BisuConnect
                <p>Contact: mikejoshua.lopena44.@gmail.com</p>
                <p>Follow us on social media: 
                    <a href="#">Facebook</a>, 
                    <a href="#">Twitter</a>, 
                    <a href="#">Instagram</a>
                </p>
            </footer>
            </div>


          </div>
        </div>

        <!-- below cover-->

        <?php
          $section = "default";
          if(isset($_GET['section']))
          {
            $section = $_GET['section'];
          }
          if($section == "default")
          {
            include("settings_account.php");
          }
          elseif($section == "password")
          {
            include("settings_password.php");
          }
          elseif($section == "terms_condition")
          {
            include("settings_terms_condition.php");
          }
          elseif($section == "about_us")
          {
            include("settings_about.php");
          }
          else
          {
            include("P_logout.php.php");
          }

        ?>
      </div>
</div>






  <!--=== Mobileview Bar Script==-->
  <script>
    const list = document.querySelectorAll('.list');
    function activeLink(){
      list.forEach((item) =>
      item.classList.remove('active'));
      this.classList.add('active');
    }
    list.forEach((item) =>
    item.addEventListener('click' , activeLink));
  </script>

  <!--=== Sidebar Script==-->
  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
  });

  // following are the code to change sidebar button(optional)
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
   }
  }

  // Get the current page filename
  var currentPage = window.location.pathname.split('/').pop();

  // Add the 'profilebg' class to the corresponding list item
  if (currentPage === 'settings.php') {
    document.getElementById('setting').classList.add('profilebg');
  } 

  </script>


    <!--=== Script for loading ====-->

    <script>
        $(window).on('load', function(){
          $(".spinner-parent").fadeOut(1010);
          $(".body").fadeIn(1010);
        })
    </script>

<!-- Timer for error message to display -->
<script>
  // Show the error message
    document.getElementById('error-message').style.display = 'block';

  // Automatically hide the error message after 5 seconds
    setTimeout(function() {
      document.getElementById('error-message').style.display = 'none';
    }, 3000);
</script>

<!-- refresh after submitting -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if the page is /settings.php?section=password
        if (window.location.pathname === 'settings.php' && window.location.search === '?section=password') {
            // Add a click event listener to the submit button
            var confirmation = confirm("Save changes. Do you want to continue?");

            document.querySelector('.btn').addEventListener('click', function () {
              
                              
                // If the user clicks "OK," proceed with form submission and redirection
                if (confirmation) {
                    // Submit the form
                    document.getElementById('settingsForm').submit();
                    
                    // Redirect to profile_page.php after a short delay (adjust the delay as needed)
                    setTimeout(function () {
                        window.location.href = 'profile_page.php';
                    }, 500);
                }
            });
        }
    });
</script>









      

</body>
</html>