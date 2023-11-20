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

    $post = new Post();
    $id = $_SESSION['Bisuconnect_stud_ID'];
    $result = $post->create_post($id, $_POST,$_FILES);

    //To avoid resubmission of post when refreshing

    if($result == ""){
      header("Location: Profile_page.php");
      die;
    }else{
      echo "<div class='error'>";
      echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
      print_r($result);
      echo "</div>";
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
    <title>BISUconnect | Profile_page </title>
    <link rel="shortcut icon" type="x-icon" href="images/lego.jpg">
    <link rel="stylesheet" href="style/style_profile.css">
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
             <a href="Profile_page.php?id=<?php echo $user_data['stud_ID']?>"><div class="menu-buttons">Timeline</div></a>
             <?php
              if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {
            // Display these options only if the current user's ID matches the profile user's ID
              ?>
                  <a href="User_image.php?change=profile"><div class="menu-buttons">Change Profile</div></a>
                  <a href="User_image.php?change=cover"><div class="menu-buttons">Change Cover</div></a>
              <?php
                  }
              ?>
            <a href="Profile_page.php?section=about&id=<?php echo $user_data['stud_ID']?>"  ><div class="menu-buttons">About me</div></a>
            <a href="Profile_page.php?section=photos&id=<?php echo $user_data['stud_ID']?>"  ><div class="menu-buttons">Photos</div></a>
          </div>
        </div>

        <!-- pop-up modal for edit about me-->
        <div class="bg-modal">
            <div class="modal-content">
              <div class="close">+</div>
              <img class="modal-profile-dp" src="<?php echo $image ?>" alt="image_profile">
              <h2>Edit about me</h2>
              <form method="post" action="Profile_page.php"> <!-- Updated action to the same page -->
                  <div>
                      <textarea name="description" id="text-description" placeholder="Edit description" rows="5"><?php echo $user_data['introduction']; ?></textarea>
                  </div>
                  <div class="about-btn">
                      <input type="submit" value="Save" name="updateIntroduction">
                  </div>
              </form>
            </div>
        </div>

       <!-- pop-up modal for edit post-->       
       <div class="edit-modal">
            <div class="edit-content">
              <div class="close-edt">+</div>
              <h2>Edit post</h2>
              <form method="post" action="Profile_page.php"> <!-- Updated action to the same page -->
                  <div>
                      <textarea name="description" id="text-description" placeholder="Edit post" rows="20">
                        <?php
                          echo htmlspecialchars($ROW['post']) 
                        ?>
                      </textarea>
                  </div>
                  <div class="edt-btn">
                      <input type="submit" value="Save" name="">
                  </div>
              </form>
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
            include("profile_content_default.php");
          }
          elseif($section == "photos")
          {
            include("profile_content_photos.php");
          }
          elseif($section == "about")
          {
            include("profile_content_about.php");
          }
          elseif($section == "bisuans")
          {
            include("profile_content_bisuans.php");
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
  if (currentPage === 'Profile_page.php') {
    document.getElementById('profile').classList.add('profilebg');
  } 

  </script>


    <!--=== Script for loading ====-->

    <script>
        $(window).on('load', function(){
          $(".spinner-parent").fadeOut(1010);
          $(".body").fadeIn(1010);
        })
    </script>

     <!--=== modal open/close for about me====-->
     <script>
      document.getElementById('modalbtn').addEventListener('click',
      function() {
        document.querySelector('.bg-modal').style.display = 'flex';
      });

      document.querySelector('.close').addEventListener('click',
        function(){
          document.querySelector('.bg-modal').style.display = 'none';
      });
     </script>

     
     <!--=== modal open/close for editing post ====-->
     <script>
      document.getElementById('edt-opt').addEventListener('click',
      function() {
        document.querySelector('.edit-modal').style.display = 'flex';
      });

      document.querySelector('.close-edt').addEventListener('click',
        function(){
          document.querySelector('.edit-modal').style.display = 'none';
      });
     </script>

     <!--=== modal open/close for deleting post ====-->
     <script>
      document.getElementById('del-opt').addEventListener('click',
      function() {
        document.querySelector('.delete-modal').style.display = 'flex';
      });

      document.querySelector('.close-del').addEventListener('click',
        function(){
          document.querySelector('.delete-modal').style.display = 'none';
      });
     </script>

<!-- return to previous screen where you left of -->
<script>
  function handleLike(event) {
    // Store the current scroll position
    const scrollY = window.scrollY || window.pageYOffset;

    // Allow the default behavior (navigate to the specified href)
    // Note: You can add your AJAX logic here if needed

    // Restore the scroll position after the navigation
    setTimeout(() => {
      window.scrollTo(0, scrollY);
    }, 0);
  }
</script>



      

</body>
</html>