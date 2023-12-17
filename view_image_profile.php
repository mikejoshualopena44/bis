<?php
  

  include ("classes/autoloader.php");

  $login = new Login();
  $user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);
  $Post = new Post();
  $ROW = false;


  // show who comment in the  posts

  $ERROR = "";
  if(isset($_GET['id'])){

    $ROW = $Post->get_one_posts($_GET['id']);

  }
  else{
    $ERROR = "No Image was found!";
  }

  
  
  //change image in sidebar
    $corner_image = "images/bman1.jpg";

    if(isset($user_data))
    {
      $corner_image = $user_data['profile_image'];
    }

  //To go back to a page where you came from
	if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "view_image_profile.php")){

		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
	}

  
  if($_SERVER['REQUEST_METHOD'] == "POST"){

    
    $Post->edit_post($_POST, $_FILES);  
    header("Location: ".$_SESSION['return_to']);
    die;


  }
  
?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | View Image </title>
    <link rel="stylesheet" href="style/view_t.css">

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
            <h3><a href="index.php" style="color: #212145 "> BisuConnect</a></h3>    
          </nav>

            <div class="delete-content">
            <div class="close-del">
                <a href="<?php echo $_SESSION['return_to']; ?>" id="closeButton">+</a>
            </div>
              <h2> View Image</h2> 
              <?php
                $user = new User();
                $image_class = new Image();

                if(is_array($ROW)){
                 
                    echo "<img src='$ROW[image]' style='height: 40rem;' alt='No image'/>";
                    echo "<a href='$ROW[image]' class='buttonDownload' download><i class='bx bxs-download'></i> Save Image</a>";
                 
                }
              
              ?> 
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
  if (currentPage === 'people-likes.php') {
    document.getElementById('profile').classList.add('profilebg');
  }else{
    document.getElementById('activity-stream').classList.add('profilebg');
  }
  </script>


    <!--=== Script for loading ====-->

    <script>
        $(window).on('load', function(){
          $(".spinner-parent").fadeOut(1010);
          $(".body").fadeIn(1010);
        })
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
            var returnTo = "<?php echo isset($_SESSION['return_to']) ? $_SESSION['return_to'] : 'index.php'; ?>";
            window.location.href = previousPage || returnTo; // Default to returnTo if no previous page is stored
        });
    });
</script>



  


</body>
</html>