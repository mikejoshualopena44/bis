<?php

include ("classes/autoloader.php");

//Check if user is logged in and if numeric to secure
//Who log_in? =($_SESSION['Bisuconnect_stud_ID']); 
$login = new Login();
$user_data = $login->check_login($_SESSION['Bisuconnect_stud_ID']);
$post = new Post();

//check who login //white listing to avoid sql injection
if(isset($_GET['id']) && is_numeric($_GET['id'])){
   $profile = new Profile();
    $profile_data = $profile-> get_profile($_GET['id']?? '');

    if(is_array( $profile_data))
    {
      $user_data = $profile_data[0];
    }
}

if(isset($_SERVER['HTTP_REFERER'])){
    $return_to = $_SERVER['HTTP_REFERER'];
}else{
    $return_to = "Profile_page.php";
}

    if (isset($_GET['type']) && isset($_GET['id'])) {
        

        if (is_numeric($_GET['id'])) {
            $allowed = ['post', 'user', 'comment'];

            if (in_array($_GET['type'], $allowed)) {
                $post->like_post($_GET['id'], $_GET['type'], $_SESSION['Bisuconnect_stud_ID']);
            }
     
            //user_class = new User(); for following
            //$single_post = $post->get_user($_GET['id']);
        }
    }

    
    $likes = $post->get_likes($_GET['id'],$_GET['type']);
    
    if(is_array($likes)){
        echo count($likes);
    }else{
        echo 0;
    }



?>