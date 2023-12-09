<?php

include ("classes/autoloader.php");

$query = "SELECT * FROM users";
$DB = new CONNECTION_DB();
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
    <link rel="stylesheet" href="style/admin_style.css">

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
        <input type="text" id="searchInput" placeholder="Search..."> 
        <button  id="search_btn" onclick="searchUsers()">Search</button>
    </div>
    <br>

    <!-- Display user data in a table -->
    <div class="profile-posts">
      <table id="userTable">
          <thead>
              <tr>
                  <th>Student ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Date created</th>
                  <th>Option</th>
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
                      <!-- <button class="update">Update</button> -->
                          <button class="delete" onclick="confirmDelete(<?php echo $user['stud_ID']; ?>)">Delete</button>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
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

<script>
// Get the current page filename
  var currentPage = window.location.pathname.split('/').pop();

  // Add the 'profilebg' class to the corresponding list item
  if (currentPage === 'admin.php') {
    document.getElementById('students').classList.add('profilebg');
  } 

</script>

<script>
    function confirmDelete(studID) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "delete_user.php?stud_ID=" + studID;
        }
    }
</script>


</body>
</html>

<?php
} else {
    echo "No users found.";
}
?>