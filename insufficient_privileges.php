<?php
include ("classes/autoloader.php");


// Check if users were retrieved successfully

?>

<!--=== HTML ===-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>BISUconnect | Access Denied! </title>
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



  
    <!--COVER AREA -->
    <div class="container">
        <div class="profile-posts">
            <div class="priv">
                <i class='bx bxs-lock'></i> <i class='bx bx-file-blank'></i>
            </div>
            <div class="priv_txt">
        This content isn't available right now
When this happens, it's usually because the owner only shared it with a small group of people, changed who can see it or it's been deleted.
            </div>
            <div class="goto">
                <input id="goto_btn" type="button" value="Go to login page" onclick="redirectToLoginPage()">
            </div>
        </div>

    </div>


    <script>
    function redirectToLoginPage() {
      window.location.href = 'Login_page.php';
    }
  </script>


</body>
</html>
