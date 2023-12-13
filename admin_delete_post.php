<?php
include("classes/autoloader.php");

if (isset($_GET['post_id']) && isset($_GET['stud_ID'])) {
    $post_id = $_GET['post_id'];
    $stud_ID = $_GET['stud_ID'];
    $post = new Post();
    $post->delete_post($post_id);

    // Redirect back to the user's posts page
    header("Location: admin_user_posts.php?stud_ID=" . $stud_ID);
    exit();
} else {
    // Handle the case when post_id or stud_ID is not provided
    header("Location: admin.php");
    exit();
}
?>
