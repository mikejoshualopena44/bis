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
    $result = $post->create_post($id, $_POST,$_FILES);

    //To avoid resubmission of post when refreshing

    if($result == ""){
      header("Location: index.php");
      die;
    }else{
      echo "<div class='error' id='error-message'>";
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

  // To collect recent posts from other users
  $post = new Post();
  $recent_posts = $post->get_recent_posts($_SESSION['Bisuconnect_stud_ID']);

?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Home_page </title>
    <link rel="stylesheet" href="style/style_indexs.css">

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

<!-- -=== End of Annucement -->

    <div class="profile-section">

    <?php include("header.php"); ?>
          <!-- === Announcement -->
    <?php
            $DB = new CONNECTION_DB();

            // Fetch announcements from the database
            $sql = "SELECT * FROM announcement";
            $announcements = $DB->read($sql);

            // Check if the query was successful
            if ($announcements !== false && is_array($announcements)) {
                // Display the slider if there are announcements
                ?>
                <div class="ancmnt-bar">
                    <div class="slider">
                        <?php foreach ($announcements as $announcement): ?>
                            <img id="slide-<?php echo $announcement['anc_number']; ?>" src="<?php echo $announcement['path']; ?>" alt="Announcement Image" />
                        <?php endforeach; ?>
                    </div>
                    <div class="slider-nav">
                        <?php foreach ($announcements as $announcement): ?>
                            <a href="#slide-<?php echo $announcement['anc_number']; ?>"></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
            } else {
                // Handle the case when there are no announcements or an error occurred
                echo "No announcements found.";
            }
      ?>


        <!-- below cover-->
        <div class="profile-content">
          <!-- friends area-->


        <div class="org-container"></div>
          <div class="org-bar">
            <div class="label">&nbsp &nbsp Organizations</div> <br>
            <?php
              $orgs = ['BISU', 'CSO', 'SCV', 'ICPEP', 'CEA', 'SSG', 'MAYORS_LEAGUE', 'LUDAFIL', 'YMMA', 'PICE_ACES', 'SEES_IIEE_SC', 'UAPSA', 
              'BIDA', 'JPSME', 'ADA', 'ATTS', 'EESA', 'LATEST', 'MATH_ISIP', 'OASIS', 'SCUBAP', 'SPE', 'YES', 'AHWB', 'BISU_CHORALE', 
              'GDSC', 'HSC', 'KGEN', 'PFC', 'SKILARTALES', 'TAWUSO', 'VAG', 'DOST_SA_BOHOL', 'RCY', 'IVCF', 'KKBM', 'SFC', 'SMCI', 
              'YFCCB', 'JESUS_AND_ME', 'ASUL', 'BDATS', 'ALLY', 'ABCD', 'ANDA', 'ALSO', 'BISUs_PILAR', 'BISUbayanons', 'BTAP', 'BTAP_3', 
              'BUGS', 'CYou', 'COOL', 'CSA', 'DANAO_SCOUT', 'ABDUCT', 'HCB', 'JUST', 'LOLs', 'MABINIANS', 'MYLS', 'SICAD', 'SIDLAK', 'SISS',
              'SMART', 'SMTEP', 'SOLID', 'SQUAD', 'SYC', 'GO_TCC', 'TEGUM', 'TRIAD', 'UBSA_BISU', 'EG', 'USBBC', 'BVAULTS', 'USB', 'LLS', 'SIAW'];

            foreach ($orgs as $org) {
                $orgConfig = getOrgConfig($_SESSION['Bisuconnect_stud_ID'], $org);

                if ($orgConfig && $orgConfig['show_logo']) {
                    echo "<a href='" . $orgConfig['logo_url'] . "' target='_blank'>";
                    echo "<img class='org-logo' src='" . $orgConfig['logo_path'] . "' alt='$org'><br>";
                    echo "</a>";
                }
            }
            ?>
          </div>

          <!-- Start Post area-->

              <div class="profile-posts">
                <!--post something-->
                <?php
                if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {

                // Display these post area only if the current user's ID matches the profile user's ID
                
                ?>
                        <!--post something-->
                        <div class="posts-area">
                            <form method="post" enctype="multipart/form-data" action="#">
                            <textarea name="post" id="text-post"  placeholder="What's on your mind, <?php echo $user_data['firstName']; ?>?"></textarea><br><br>
                            <input name="file" id="posts_browse" type="file"  accept="image/jpeg, image/png">  
                            <input id="posts_btn" type="submit" value="Post"> 
                            <br><br>
                            </form>
                        </div><br>
                <?php
                    }
                ?>
            
                <!--profile- timeline-->

                  <!--profile- timeline-->

                    <div class="timeline-bar">
                        <!-- Other posts here!-->
                        <?php
                        
                        if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']){
                        ?>
                            <div class="timeline"> <!--refer to P_post.php for the content-->
                            <?php
                              if ($recent_posts) {
                                  foreach ($recent_posts as $ROW) {
                                      $user = new User();
                                      $ROW_user = $user->get_user($ROW['stud_ID']);
                                      include("P_post_index.php");
                                  }
                              }else{
                                  // No posts, display "No more comments" message
                                  echo "<div class='noComment'>";
                                  echo "No more post";
                                  echo "</div>";
                              }
                              ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                      //pagination on previous and next page on class_F_paginationLink.php
                      $pg = pagination_link();
                    ?>

                    <div class="page-container">
                        <a href="<?php echo $pg['prev_page'] ?>"> 
                            <i class='bx bxs-chevron-left' style="color: #f0c310"></i>
                            <input id="page" type="submit" value="Previous Page"> 
                        </a>

                        <a href="<?php echo  $pg['next_page'] ?>"> 
                            <input id="page" type="submit" value="Next Page"> 
                            <i class='bx bxs-chevron-right' style="color: #f0c310"></i>
                        </a>
                    </div>


              </div>
            <!--== End of post area== -->

          </div>
        </div>
      </div>
  </div>







  <!--== Header script ==-->
  <script>
    {
      const nav = document.querySelector(".home-header");
      let lastScrollY = window.scrollY;

      window.addEventListener("scroll" , () => {
        if(lastScrollY < window.scrollY) {
          nav.classList.add("nav--hidden");
        } else {
          nav.classList.remove("nav--hidden");
        }

        lastScrollY = window.scrollY;
      });

      window.addEventListener('scroll', function () {
      var header = document.querySelector('.home-header');

      if (window.scrollY > 100) {
        header.classList.add('hidden');
      } else {
        header.classList.remove('hidden');
      }
    });
    }

  </script>


 <!--== Image slider scipt ==-->
 <script>
  // JavaScript
  const slider = document.querySelector('.slider');

  function slideNext() {
    const firstSlide = slider.firstElementChild;
    slider.appendChild(firstSlide.cloneNode(true));
    slider.removeChild(firstSlide);
    slider.scrollLeft += firstSlide.offsetWidth;
  }

  function startSlider() {
    setInterval(() => {
      slideNext();
      slider.style.transition = 'scroll-left 1s ease-in-out'; // Adjust the duration and easing as needed
    }, 3000); // Adjust the interval as needed (in milliseconds)
  }

  startSlider();

  // Reset transition after it completes
  slider.addEventListener('transitionend', () => {
    slider.style.transition = 'none';
    slider.scrollLeft = slider.scrollLeft % slider.scrollWidth;
  });

  // Prevent default behavior of anchor links
  document.querySelectorAll('.slider-nav a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const targetSlide = document.getElementById(this.getAttribute('href').substring(1));
      const distanceToScroll = targetSlide.offsetLeft - slider.scrollLeft;
      slider.scrollLeft += distanceToScroll;
    });
  });
</script>



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
  if (currentPage === 'index.php') {
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

<!-- Add this script to your HTML file -->
<script>
// Function to check if the post is liked in local storage
function isPostLiked(postId) {
    return localStorage.getItem('liked_post_' + postId) === 'true';
}

// Function to handle liking a post
function like_post(e, postId) {
    e.preventDefault();

    // Toggle the 'liked' class on the parent 'a' element
    e.target.parentNode.classList.toggle('liked');

    // Save the liked status in local storage
    var isLiked = e.target.parentNode.classList.contains('liked');
    localStorage.setItem('liked_post_' + postId, isLiked);

    // Send the request to the server using AJAX
    var link = "like.php?type=post&id=" + postId;
    var xml = new XMLHttpRequest();

    xml.onreadystatechange = function () {
        if (xml.readyState == 4 && xml.status == 200) {
            // Update the like count
            updateLikeCount(postId, xml.responseText);
        }
    };

    xml.open("POST", link, true);
    xml.send();
}

// Function to update like count in the DOM
function updateLikeCount(postId, response) {
    var likeCountElement = document.getElementById('like-count-' + postId);

    if (likeCountElement) {
        var text = "";

        if(response.trim() == 0){
           text = " ";
        }
        else if(response.trim() == 1){
           text = response.trim() + " person loved this post";
        }
        else if (response.trim() !== "") {
            text = response.trim() + " people loved this post";
        }

        likeCountElement.textContent = text;
    }
}

// Check liked status on page load and apply 'liked' class
document.addEventListener('DOMContentLoaded', function () {
    var likeElements = document.querySelectorAll('.heart');
    
    likeElements.forEach(function (likeElement) {
        var postId = likeElement.getAttribute('data-post-id');
        var isLiked = isPostLiked(postId);
        
        if (isLiked) {
            likeElement.classList.add('liked');
        }
    });
});
</script>

<!-- Timer for error message to display -->
<script>
  // Show the error message
    document.getElementById('error-message').style.display = 'block';

  // Automatically hide the error message after 5 seconds
    setTimeout(function() {
      document.getElementById('error-message').style.display = 'none';
    }, 1000);
</script>



</body>
</html>