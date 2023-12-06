<div class="profile-content">
    <!-- friends area-->
    <div class="friends-bar">
        <div class="label">Bisuans</div> <br>
        <div class="friends-container">                         
            <?php
                if($friends)
                {
                    foreach ($friends as $FRIEND_ROW) //It will display nth number of posts
                    {
                    include("P_user.php");
                    }
                }
            ?>
        </div>
    </div>


    <!--  Post area-->
    <div class="profile-posts">
                <?php
                
                if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {

                // Display these post area only if the current user's ID matches the profile user's ID
                
                ?>
                        <!-- Post something -->
                        <div class="posts-area">
                            <form method="post" enctype="multipart/form-data" action="#">
                                <textarea name="post" id="text-post" placeholder="What's on your mind, <?php echo $user_data['firstName']; ?>?"></textarea>
                                <input name="file" id="posts_browse" type="file" accept="image/jpeg, image/png"> <!-- Specify accepted file types -->
                                <input id="posts_btn" type="submit" value="Post">
                                <br><br>
                            </form>
                        </div><br>
                <?php
                    }
                ?>
                <!--profile- timeline-->
        <div class="timeline-bar">
                    <!--Your posts here!-->
                    <div class="timeline"> <!--refer to P_post.php for the content-->
                    <?php
                    
                        if($posts)
                        {
                                
                            foreach ($posts as $ROW) //It will display nth number of posts
                            {  
                                $user = new User();
                                $ROW_user = $user->get_user($ROW['stud_ID']);

                                include("P_post.php");
                            }
                        }else{
                            // No posts, display "No more comments" message
                            echo "<div class='noComment'>";
                            echo "No more post";
                            echo "</div>";
                        }
                    ?>
                    </div>
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


            <?php
            if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {
            // Display these options only if the current user's ID matches the profile user's ID
              ?>
            <div class="friends-bar">
              <div class="label">
                    Notifications
                    <i style="padding-left: 4rem; font-size: 2.6vh;" class='bx bx-bell'></i>
                </div><br>
                <div class="friends-container">

                <?php
                $User = new User();

                ?>

                    <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-5.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Doris Y. Lartey</b> commented on a post you are tagged in
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                                                     
                    </div>  
                    
                    
              <?php
                  }
              ?>
                </div>
            </div>
</div>
