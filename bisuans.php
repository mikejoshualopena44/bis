<?php
  //print_r($_SESSION);
  include ("classes/autoloader.php");

  //Check if user is logged in and if numeric to secure
  //isset($_SESSION['Bisuconnect_stud_ID']); 
  $login = new Login();
  $user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);

  // For posting start here

  if($_SERVER['REQUEST_METHOD'] == "POST" ) //inserting post to db
  {
    $post = new Post();
    $id = $_SESSION['Bisuconnect_stud_ID'];
    $result = $post->create_post($id, $_POST,$files);

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
  $id = $_SESSION['Bisuconnect_stud_ID'];

  $posts = $post->get_posts($id, $_POST);// no_post??
 
  //to collect friends
  $user = new User();
  $id = $_SESSION['Bisuconnect_stud_ID'];

  $friends = $user->get_friends($id);

  //change image in sidebar
  $corner_image = "images/bman1.jpg";

  if(isset($user_data))
  {
    $corner_image = $user_data['profile_image'];
  }

?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Bisuans </title>
    <link rel="stylesheet" href="style/bisuans.css">

    <link rel="shortcut icon" type="x-icon" href="images/logo.png">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
   </head>

<body>
    <!-- LOADING PAGE-->
    <?php include("loading.php"); ?>
  <!-- MOBILE NAVBAR -->
  <!-- White separator bar -->
  <div class="mobile-separator"></div>
  <div class="mobile-navbar">
    <ul>
      <li class="list active">
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
      <li class="list">
        <a href="Profile_page.php">
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

    <div class="profile-section">
              <div class="profile-posts">
                <!-- Display Friends-->

                  <div class="timeline-bar">
                      <div class="timeline"> <!--refer to P_post.php for the content-->
                          <div class="friends-container">
                              <?php
                              $image_class = new Image();
                              if($friends)
                              {
                                  foreach ($friends as $FRIEND_ROW) //It will display nth number of friends
                                  {
                                  include("P_user.php");
                                  }
                              }
                              ?>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
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
      if (currentPage === 'bisuans.php') {
        document.getElementById('bisuan').classList.add('profilebg');
      } 

      </script>


        <!--=== Script for loading ====-->

        <script>
            $(window).on('load', function(){
              $(".spinner-parent").fadeOut(1010);
              $(".body").fadeIn(1010);
            })
          </script>
</body>
</html>