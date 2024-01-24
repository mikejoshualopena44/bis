<?php
  session_start();

  //print_r($_SESSION);
  include ("classes/connection.php");
  include ("classes/C_login.php");
  include ("classes/C_user.php");
  include ("classes/C_post.php");
  include ("classes/C_image.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);
  //userdata we will know whos the person who log in
	//posting starts here

  $DB = new CONNECTION_DB();
  //check user post upon posting
  if($_SERVER['REQUEST_METHOD'] == "POST")
	{
    //Change Profile
    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
    {
   //type to check extension
      if($_FILES['file']['type'] == "image/jpeg")
      {
        //size to check file size
        $allowed_size =  (1024 * 1024) * 200; //200MB
        if($_FILES['file']['size'] < $allowed_size)
        {
            //All goods
            $folder = "uploads/" . $user_data['stud_ID'] . "/";

            //create folder for every user

            if(!file_exists($folder))
            {
              mkdir($folder,0777,true);
            }

            $image = new Image();

            //create random folder name
            $filename = $folder . $image->generate_filename(15).".jpg" ;
            move_uploaded_file($_FILES['file']['tmp_name'], $filename);

            $change = "profile";
            //if you change bg image
            if(isset($_GET['change']))
            {
              $change = $_GET['change'];
            }


            

            if($change == "cover")
            {
              if(file_exists($user_data['cover_image']))
              {
                unlink($user_data['cover_image']);
              }
              $image->resize_img($filename,$filename,1500,1500);
            }else
            {
              if(file_exists($user_data['profile_image']))
              {
                unlink($user_data['profile_image']);
              }
              $image->resize_img($filename,$filename,1500,1500);
            }


            if(file_exists($filename))
            {
              $stud_ID = $user_data['stud_ID'];
              $is_profile_image = $user_data['profile_image'];
              $is_cover_image = $user_data['cover_image'];


              if($change == "cover")
              { 
                //delete comments on that post
                $deleteCommentQuery = "DELETE FROM posts WHERE parent IN (SELECT post_id FROM posts WHERE stud_ID = '$stud_ID' AND is_cover_image = 1)";
                $DB->save($deleteCommentQuery);  

                //delete notification on that post
                $deleteNotifQuery = "DELETE FROM notifications WHERE content_id IN (SELECT post_id FROM posts WHERE stud_ID = '$stud_ID' AND is_cover_image = 1)";  
                $DB->save($deleteNotifQuery);   

                //delete previoues post
                $deleteCoverQuery = "DELETE FROM posts WHERE stud_ID = '$stud_ID' AND is_cover_image = 1 AND image != '$filename' LIMIT 1";               
                $DB->save($deleteCoverQuery);

                //Update user table image
                $query = "UPDATE users SET cover_image = '$filename' WHERE stud_ID =' $stud_ID' LIMIT 1 "; 
                $_POST['is_cover_image'] = 1;

              }else
              {

                //delete comments on that post
                $deleteCommentQuery = "DELETE FROM posts WHERE parent IN (SELECT post_id FROM posts WHERE stud_ID = '$stud_ID' AND is_profile_image = 1)";
                $DB->save($deleteCommentQuery);  
                

                //delete notification on that post
                $deleteNotifQuery = "DELETE FROM notifications WHERE content_id IN (SELECT post_id FROM posts WHERE stud_ID = '$stud_ID' AND is_profile_image = 1)";  
                $DB->save($deleteNotifQuery);   

                //delete previoues post
                $deleteProfileQuery = "DELETE FROM posts WHERE stud_ID = '$stud_ID' AND is_profile_image = 1 AND image != '$filename' LIMIT 1";    
                $DB->save($deleteProfileQuery); 
                
                //Update user table image
                $query = "UPDATE users SET profile_image = '$filename' WHERE stud_ID =' $stud_ID' LIMIT 1 ";  
                
                             
                $_POST['is_profile_image'] = 1;
              }

              $DB->save($query);


              //Create a posts

              $post = new Post();
              $post->create_post($stud_ID, $_POST,$filename);


              header("Location: Profile_page.php");
              die;
      
            }
        }else{
          echo "<div class='error' id='error-message'>";
          echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
          echo "Only images of 7MB or lower are allowed";
          echo "</div>"; 
        }

      }else
      {
        echo "<div class='error' id='error-message'>";
        echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
        echo "Only images of jpeg format are allowed";
        echo "</div>";       
      }
    
    }//Change Cover
    else
    {

      echo "<div class='error' id='error-message'>";
      echo "The following errors occurred:<br><hr style='border: 1.5px solid black'>";
		  echo "please add a valid image!";
	  	echo "</div>";
    }
  }

?>


<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Change profile </title>
    <link rel="stylesheet" href="style/change.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="shortcut icon" type="x-icon" href="images/logo.png">
   </head>
<body>
   <!-- LOADING PAGE-->
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
    <?php include ("Sidebar.php"); ?>
      <!-- END OF SIDEBAR-->

  <!-- Profile Page -->
  <?php include("header.php"); ?>
      
    <div class="profile-section">
        <!-- below cover-->
        <div class="profile-content">
          <!-- Main Area-->
          <div class="profile-friends">
            <div class="friends-bar">
              <div class="label">Change Photo</div> <br>
                  <div class="posts-area">
                    <form method="post" action="" class="create-post" enctype="multipart/form-data">
                        <input type="file" name="file" id="upload-btn" accept="image/jpeg, image/png">
                        <input type="submit" value="Change" id="posts_btn"> 
                    </form>
                  </div><br>
                  <div class="prev-area ">       
                  <?php
                            $change = "profile";
                            //if you change bg image
                            if(isset($_GET['change']) && $_GET['change'] == "cover")
                            {
                              $change = "cover";
                              echo "<img src='$user_data[cover_image]'id='prev_cp''>";
                            }else
                            {
                              echo "<img src='$user_data[profile_image]' id='prev_dp'>";
                            }  
                        ?>
                  </div>
              </div>
          </div>
            <!-- Start Post area-->
            <!--== End of post area== -->
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

    // Add the 'profilebg' class to the corresponding list item
    if (currentPage === 'User_image.php') {
    document.getElementById('profile').classList.add('profilebg');
  }else{
    document.getElementById('profile').classList.add('profilebg');
  }
  </script>


    <!--main-->
        <!---->
</body>
</html>