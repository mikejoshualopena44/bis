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
<!--  Friends Pagination
                    <?php
            //pagination on previous and next page on class_F_paginationLink.php
            $pg = pagination_link();
        ?>      
        <div class="page-container">
                        <a href="#<?php //echo $pg['prev_page'] ?>"> 
                            <i class='bx bxs-chevron-left' style="color: #f0c310"></i>
                            <input id="page" type="submit" value="Previous"> 
                        </a>

                        <a href="#<?php //echo  $pg['next_page'] ?>"> 
                            <input id="page" type="submit" value="Next"> 
                            <i class='bx bxs-chevron-right' style="color: #f0c310"></i>
                        </a>
                    </div>
-->
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

                                include("P_post_profile.php");
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
                    <i style="padding-left: 2rem; font-size: 2.6vh;" class='bx bx-bell'></i>

                    <!-- notification count 
                    <?php

                        $notif = check_notifications();      
                    ?>
                    <?php if($notif> 0 ) :?>
                            <div class="notification_count"><?=$notif?></div>
                    <?php endif; ?>
                    -->

                </div><br>
                <div class="friends-container">

            <?php

                $DB = new CONNECTION_DB();
                $id = esc($_SESSION['Bisuconnect_stud_ID']);
                $follow = array();

                //check content I follow
                //$sql = "SELECT * FROM content_follow WHERE (disabled = 0 AND stud_ID ='$id') LIMIT 99";
                //$i_follow = $DB->read($sql);

                //if(is_array($i_follow)){
                //    $follow = array_column($i_follow, "content_id");
                //}
                if(count($follow)> 0){

                    $str = "'" . implode("','", $follow) . "'";                 
                    $query = "SELECT * FROM notifications WHERE (content_owner = '$id' AND stud_ID != '$id') OR (content_id in ($str)) ORDER BY id DESC LIMIT 30";
                }else{
                    $query = "SELECT * FROM notifications WHERE content_owner = '$id' AND stud_ID != '$id' ORDER BY id DESC LIMIT 30";
                }
                //number of notification
                $data = $DB->read($query);


            ?>
            

            <!-- Loop Notification -->
            <?php  if(is_array($data)): ?>

                <?php foreach($data as $notif_row):

                    Include("single_notification.php");

                endforeach; ?>

            <?php else: ?>

                <b>No Notifications were found</b> 
                
            <?php endif; ?>
<!--  Notification Pagination     
            <?php
            //pagination on previous and next page on class_F_paginationLink.php
            $pg = pagination_link();
        ?>      
        <div class="page-container">
                        <a href="#<?php //echo $pg['prev_page'] ?>"> 
                            <i class='bx bxs-chevron-left' style="color: #f0c310"></i>
                            <input id="page" type="submit" value="Recent"> 
                        </a>

                        <a href="#<?php //echo  $pg['next_page'] ?>"> 
                            <input id="page" type="submit" value="Older"> 
                            <i class='bx bxs-chevron-right' style="color: #f0c310"></i>
                        </a>
                    </div>   
-->           
                    
              <?php
                  }
              ?>
                </div>
            </div>
</div>
