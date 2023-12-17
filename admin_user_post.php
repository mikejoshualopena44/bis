<?php
include("classes/autoloader.php");


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

if (isset($_GET['stud_ID'])) {
    $stud_ID = $_GET['stud_ID'];

    // Check if the delete button is clicked
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['post_id'])) {
        $post_ID = $_GET['post_id'];

        // Assuming your posts table has a column named 'post_id' as the primary key
        $query = "DELETE FROM posts WHERE post_id = $post_ID";

        $DB = new CONNECTION_DB();
        $success = $DB->save($query);

        if ($success) {
            echo "<div class='error' id='error-message'>";
            echo "<hr style='border: 1.5px solid black'>";
            echo "Post with ID $post_ID deleted successfully.";
            echo "</div>";
        } else {
            echo "Error deleting post with ID $post_ID.";
        }
    }

    // Fetch user posts
    $post = new Post();
    $user_posts = $post->admin_get_user_posts($stud_ID);
} else {
    // Handle the case when stud_ID is not provided
    header("Location: admin.php");
    exit();
}
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
        <input style="margin-top:40px ;" type="text" id="searchInput" placeholder="Search..."> 
        <button id="search_btn" onclick="searchPosts()">Search</button>
    </div>
    <br>
    <!-- Display user posts in a table -->
    <div class="profile-posts">
      <?php if (is_array($user_posts) && !empty($user_posts)): ?>
        <table id="postTable">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Post Caption</th>
                    <th>Post Image</th>
                    <th>Date</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_posts as $user_post): ?>
                    <tr>
                        <td><?php echo $user_post['post_id']; ?></td>
                        <td><div style="max-width:20rem; overflow: auto;"><?php echo $user_post['post']; ?></div></td> 
                        <td><img style="height:6rem ;border-radius: 1rem;" src="<?php echo $user_post['image']; ?>" alt="No Image"></td>
                        <td><?php echo $user_post['date']; ?></td>
                        <td>
                            <button class="delete" onclick="confirmDelete(<?php echo $user_post['post_id']; ?>, <?php echo $stud_ID; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="search_btn" style="margin-top:40px ;margin-bottom:40px;"  onclick="goBack()">Go Back</button>
    <?php else: ?>
        <p>No posts found for this user.</p>
        <button id="search_btn" style="margin-top:40px ;margin-bottom:40px;"  onclick="goBack()">Go Back</button>
    <?php endif; ?>
  </div>
</div>

<!-- Include necessary scripts -->
<script>
    function searchPosts() {
        // Declare variables
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("postTable");
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

    function confirmDelete(postID, studID) {
        if (confirm("Are you sure you want to delete this post?")) {
            window.location.href = "admin_user_post.php?action=delete&post_id=" + postID + "&stud_ID=" + studID;
        }
    }

    function goBack() {
      window.location.href = "admin.php";
    }
</script>

<!-- ... -->

<script>
// Get the current page filename
  var currentPage = window.location.pathname.split('/').pop();

  // Add the 'profilebg' class to the corresponding list item
  if (currentPage === 'admin_user_post.php') {
    document.getElementById('students').classList.add('profilebg');
  } 
</script>

</body>
</html>
