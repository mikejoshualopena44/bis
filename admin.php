<?php
include ("classes/autoloader.php");

// Check if user is logged in
if (!isset($_SESSION['Bisuconnect_stud_ID'])) {
  // Redirect to the login page or any other appropriate page
  header("Location: Login_page.php");
  exit();
}

// Get user data
$login = new Login();
$user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);

// Check if the logged-in user has admin privileges (using a email)
$admin_email = 'admin@bisu.edu.ph'; // Replace with your actual admin email
if ($user_data['email'] !== $admin_email) {
    // Redirect to a page indicating insufficient privileges
    header("Location: insufficient_privileges.php");
    exit();
}

$DB = new CONNECTION_DB();

// Check if the delete button is clicked
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['stud_ID'])) {
  $stud_ID = $_GET['stud_ID'];


  // Fetch the existing likes from the database
  $queryFetchLikes = "SELECT likes FROM likes WHERE type='post'";
  $result = $DB->read($queryFetchLikes);
  

  if ($result !== false) {
      // Check if the query was successful before attempting to fetch the result
      $row = current($result); // Use current() to get the first (and only) element in the array

      if ($row !== false) {
          // Decode the existing likes
          $existing_likes = json_decode($row['likes'], true);

          // Remove the specified stud_ID from the likes array
          foreach ($existing_likes as $key => $like) {
              if ($like['stud_ID'] == $stud_ID) {
                  unset($existing_likes[$key]);



              }
          }
          //Decrement likes column base on the notification table
                  $queryDecrementLikes = "UPDATE posts
                                          SET likes = likes - 1
                                          WHERE post_id IN (
                                                SELECT content_id
                                                FROM notifications
                                                WHERE stud_ID = $stud_ID
                                            )";
                  $DB->save($queryDecrementLikes);

          // Encode the updated likes array
          $updated_likes_string = json_encode(array_values($existing_likes));

          // Update the likes in the database
          $queryUpdateLikes = "UPDATE likes SET likes = '$updated_likes_string' WHERE type='post'";
          $successUpdateLikes = $DB->save($queryUpdateLikes);

          // Delete the user and other related records
          $tables = ['users', 'posts', 'notifications', 'notification_seen', 'content_follow', 'org_config'];

          foreach ($tables as $table) {
              $query = "DELETE FROM $table WHERE stud_ID = $stud_ID";
              $success = $DB->save($query);

              if (!$success) {
                  echo "Error deleting records from $table for user with ID $stud_ID.";
                  exit; // Exit the loop and stop further deletions if an error occurs
              }
          }

          if ($successUpdateLikes) {
              echo "<div class='error' id='error-message'>";
              echo "<hr style='border: 1.5px solid black'>";
              echo "User with ID $stud_ID and related records deleted successfully.";
              echo "<hr style='border: 1.5px solid black'>";
              echo "</div>";
          } else {
              echo "<div class='error' id='error-message'>";
              echo "Error updating likes for user with ID $stud_ID.";
              echo "</div>";

          }
      } else {
          echo "<div class='error' id='error-message'>";
          echo "No likes found for user with ID $stud_ID.";
          echo "</div>";
      }
  } else {
      echo "<div class='error' id='error-message'>";
      echo "Error fetching likes for user with ID $stud_ID.";
      echo "</div>";
  }
} else {
  echo "<div class='error' id='error-message'>";
  echo "Invalid request.";
  echo "</div>";

}




$query = "SELECT * FROM users";
$users = $DB->read($query);

// Check if users were retrieved successfully
if ($users !== false && is_array($users) && count($users) > 0) {
?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Admin Access! </title>
    <link rel="stylesheet" href="style/style_admin_t.css">

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
    <div class="search-bar">
        <input style="margin-top:40px;" type="text" id="searchInput" placeholder="Search..."> 
        <button  id="search_btn" onclick="searchUsers()">Search</button>
    </div>
    <br>

    <!-- Display user data in a table -->
    <div class="profile-posts" style="margin-bottom: 4rem;">
        <table id="userTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date created</th>
                    <th>Option</th>
                    <!-- ... (add more columns as needed) ... -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['stud_ID']; ?></td>
                        <td><?php echo $user['firstName']; ?></td>
                        <td><?php echo $user['lastName']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['date']; ?></td>
                        <td>
                            <button class="update" onclick="viewPosts(<?php echo $user['stud_ID']; ?>)">View Posts</button>
                            <button class="delete" onclick="confirmDelete(<?php echo $user['stud_ID']; ?>)">Delete</button>
                        </td>
                        <!-- ... (Add more cells based on your table structure) ... -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Include necessary scripts -->
    <script>
          function viewPosts(studID) {
              window.location.href = "admin_user_post.php?stud_ID=" + studID;
          }

          function confirmDelete(studID) {
              if (confirm("Are you sure you want to delete this user?")) {
                  window.location.href = "admin.php?action=delete&stud_ID=" + studID;
              }
          }
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
      </script>

<script>
// Get the current page filename
  var currentPage = window.location.pathname.split('/').pop();

  // Add the 'profilebg' class to the corresponding list item
  if (currentPage === 'admin.php') {
    document.getElementById('students').classList.add('profilebg');
  } 
</script>




      <script>
          function searchUsers() {
              // Declare variables
              var input, filter, table, tr, td, i, j, txtValue;
              input = document.getElementById("searchInput");
              filter = input.value.toUpperCase();
              table = document.getElementById("userTable");
              tr = table.getElementsByTagName("tr");

              // Loop through all table rows
              for (i = 0; i < tr.length; i++) {
                  // Skip the header row
                  if (i === 0) continue;

                  // Loop through all table cells in the current row
                  for (j = 0; j < tr[i].cells.length; j++) {
                      td = tr[i].cells[j];
                      if (td) {
                          txtValue = td.textContent || td.innerText;
                          // Check if the current cell's content contains the search query
                          if (txtValue.toUpperCase().indexOf(filter) > -1) {
                              tr[i].style.display = "";
                              break; // Break out of the inner loop if a match is found in any cell
                          } else {
                              tr[i].style.display = "none";
                          }
                      }
                  }
              }
          }
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

<?php
} else {
    echo "No users found.";
}
?>