<?php

    $image = "images/bman1.jpg";
    if($FRIEND_ROW['gender'] == "Female")
    {
        $image = "images/gman.jpg";
    }
    // SHow the actual profile of your friend
    if(file_exists($FRIEND_ROW['profile_image']))
    {
        $image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']);
    }
?>

<a href="Profile_page.php?id=<?php echo $FRIEND_ROW['stud_ID'];  ?>">
    <div class="friends">           
        <img class="profile-friends-img" src="<?php  echo $image?>" alt="friends"><br>
        <!-- part where you can visit other creating new profile_PAge.php-->
        <!--access other profile by using super variables-->
        
        <?php echo $FRIEND_ROW['firstName'] . " " . $FRIEND_ROW['lastName'] ?>
        
    </div>
</a>