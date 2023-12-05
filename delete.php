<?php
  //print_r($_GET);

  include ("classes/autoloader.php");

  $login = new Login();
  $user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);
  $post = new Post();
  
  if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "delete.php")){

		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
	}

  //check who login //white listing to avoid sql injection
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
      $profile = new Profile();
      $profile_data = $profile-> get_profile($_GET['id']?? '');

      if(is_array( $profile_data))
      {
        $user_data = $profile_data[0];
      }
  }
 

  $image_class = new Image();

  // to delete posts

  $ERROR = "";
  if(isset($_GET['id'])){
    $Post = new Post();
    $ROW = $Post->get_one_posts($_GET['id']);

    if(!$ROW){
      $ERROR = "No such post  found!";
    }else{
      if($ROW['stud_ID'] !=  $_SESSION['Bisuconnect_stud_ID'])
      {
        $ERROR = "Access denied! you cant delete this post!";
      }
    }
  }
  else{
    $ERROR = "No such post  found!";
  }
  //To go back to a page where you came from
  if($_SERVER['REQUEST_METHOD'] == "POST"){

    
    $Post->delete_post($_POST['post_id']);  
    header("Location: ".$_SESSION['return_to']);
    die;


  }

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
    <title>BISUconnect | Delete post </title>
    <link rel="stylesheet" href="style/dt.css">

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

        <!-- below cover-->
       <!-- pop-up modal for delete post-->       
       <div class="delete-modal">

          <nav class="home-header">
            <h3>BisuConnect</h3>
          </nav>

            <div class="delete-content">
              <div class="close-del">
                <a href="#" id="closeButton">+</a>
              </div><br>
              <h2>DELETE POST</h2>
              <form method="post" action=""> <!-- Updated action to the same page -->
                              
                      <?php
                        if($ERROR != ""){
                          echo $ERROR;
                        }
                      ?>

                      <?php             
                      if($ROW){
                        echo "Are you sure you want to delete this post?"; 
                        
                      ?>
                    <div class="delete-box">
                          <?php
                          
                          $user = new User();
                          $ROW_user = $user->get_user($ROW['stud_ID']);
                            
                          Include("post_delete.php");
                      ?>
                      
                    </div>

                  <div class="del-btn">
                      <input type="hidden" value="<?php echo $ROW['post_id']?>" name="post_id">
                      <input type="submit" value="Delete" >
                  </div>
                      <?php  
                        }
                      ?>
                  <br>
              </form>
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
  if (currentPage === 'delete.php') {
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

     </script>

<!-- Add this script in your people-likes.php page, after the previous script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store the current page in session storage
        sessionStorage.setItem('previousPage', document.referrer);

        // Listen for closeButton click
        var closeDelLink = document.getElementById('closeButton');
        closeDelLink.addEventListener('click', function(event) {
            event.preventDefault();
            var previousPage = sessionStorage.getItem('previousPage');
            window.location.href = previousPage || 'index.php'; // Default to index.php if no previous page is stored
        });
    });
</script>


</body>
</html>