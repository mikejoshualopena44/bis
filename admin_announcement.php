<?php
include ("classes/autoloader.php");

$DB = new CONNECTION_DB();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Announcement_number'])) {
    $announcement_number = $_POST['Announcement_number'];

    // Check if the directory exists, if not, create it
    $uploadDirectory = "announcement/";
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $uploadDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowedExtensions = array("jpg", "jpeg", "png");

    if (in_array($fileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

            // Update the path in the database
            $updateQuery = "UPDATE announcement SET path = '$targetFilePath' WHERE anc_number = $announcement_number";
            $success = $DB->save($updateQuery);

            if ($success) {
                echo "<div class='error' id='error-message'>";
                echo "<hr style='border: 1.5px solid black'>";
                echo "Image uploaded and database updated successfully.";
                echo "</div>";
            } else {
                echo "Error updating the database.";
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
    }
}

// Fetch announcements from the database
$sql = "SELECT * FROM announcement";
$announcements = $DB->read($sql);

// Check if the query was successful
if ($announcements !== false && is_array($announcements)) {
?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Admin Access! </title>
    <link rel="stylesheet" href="style/style_admin.css">

    <link rel="shortcut icon" type="x-icon" href="admin1.png">
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
            <?php include("admin_sidebar.php"); ?>
        <!-- END OF SIDEBAR-->

    <!-- SEARCH BAR -->

    <!-- Display user data in a table -->
    <div class="profile-posts">
        
            <div class="posts-area">
                    <div class="input-box">
                        <form method="post" enctype="multipart/form-data" action="#">
                            <select name="Announcement_number" class="round">
                                <?php foreach ($announcements as $announcement): ?>
                                    <option><?php echo $announcement['anc_number']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input name="file" id="posts_browse" type="file" accept="image/jpeg, image/png">
                            <input id="posts_btn" type="submit" value="Save">
                        </form>
                    </div>
                </div><br>
                
                <table id="postTable">
                    <thead>
                        <tr>
                            <th>Announcements Image</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td style="display: flex ; flex-direction:column ; gap: 1rem;">
                                    <?php foreach ($announcements as $announcement): ?>
                                        <?php 
                                            if ($announcement['anc_number'] == 1) {
                                                echo "<div style='margin-bottom: -55px; z-index: 3;  color: #7d734d; font-weight: bold; font-size: 1.5rem' > 1 </div>";
                                                echo '<img style="height: 14rem;" src="' . $announcement['path'] . '" alt="Announcement Image" />';
                                            } elseif ($announcement['anc_number'] == 2) {
                                                echo "<div style='margin-bottom: -55px; z-index: 3;  color: #7d734d; font-weight: bold; font-size: 1.5rem' > 2 </div>";
                                                echo '<img style="height: 14rem;" src="' . $announcement['path'] . '" alt="Announcement Image" />';
                                            } elseif ($announcement['anc_number'] == 3) {
                                                echo "<div style='margin-bottom: -55px; z-index: 3;  color: #7d734d; font-weight: bold; font-size: 1.5rem' > 3 </div>";
                                                echo '<img style="height: 14rem;" src="' . $announcement['path'] . '" alt="Announcement Image" />';
                                            } elseif ($announcement['anc_number'] == 4) {
                                                echo "<div style='margin-bottom: -55px; z-index: 3;  color: #7d734d; font-weight: bold; font-size: 1.5rem' > 4 </div>";
                                                echo '<img style="height: 14rem;" src="' . $announcement['path'] . '" alt="Announcement Image" />';
                                            } elseif ($announcement['anc_number'] == 5) {
                                                echo "<div style='margin-bottom: -55px; z-index: 3;  color: #7d734d; font-weight: bold; font-size: 1.5rem' > 5 </div>";
                                                echo '<img style="height: 14rem;" src="' . $announcement['path'] . '" alt="Announcement Image" />';
                                            } elseif ($announcement['anc_number'] == 6) {
                                                echo "<div style='margin-bottom: -55px; z-index: 3;  color: #7d734d; font-weight: bold; font-size: 1.5rem' > 6 </div>";
                                                echo '<img style="height: 14rem;" src="' . $announcement['path'] . '" alt="Announcement Image" />';
                                            }
                                        ?>
                                    <?php endforeach; ?>
                                </td>                       
                            </tr>
                    </tbody>
                </table>
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
      </script>

<script>
// Get the current page filename
  var currentPage = window.location.pathname.split('/').pop();

  // Add the 'profilebg' class to the corresponding list item
  if (currentPage === 'admin_announcement.php') {
    document.getElementById('announcement').classList.add('profilebg');
  } 
</script>


</body>
</html>

<?php
} else {
    echo "No Announcement Found.";
}
?>