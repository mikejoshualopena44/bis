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
                        <!--post something-->
                        <div class="posts-area">
                            <form method="post" enctype="multipart/form-data" action="#">
                            <textarea name="post" id="text-post"  placeholder="What's on your mind, <?php echo $user_data['firstName']; ?>?"></textarea>
                            <input name="file" id="posts_browse" type="file" > 
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
                        }
                    ?>
                    </div>
        </div>
    </div>  


            <?php
            if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {
            // Display these options only if the current user's ID matches the profile user's ID
              ?>
            <div class="friends-bar">
              <div class="label">Notifications</div> <br>
                <div class="friends-container">
                    <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img" src="./images/profile-2.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-3.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>John Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-4.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Marry Oppong</b> and <b>283 Others</b> liked your post
                                    <small class="text-muted">4 Minutes Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-5.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Doris Y. Lartey</b> commented on a post you are tagged in
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-6.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Keyley Jenner</b> commented on a post you are tagged in
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-7.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Jane Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-2.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-3.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>John Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-4.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Marry Oppong</b> and <b>283 Others</b> liked your post
                                    <small class="text-muted">4 Minutes Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-4.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Marry Oppong</b> and <b>283 Others</b> liked your post
                                    <small class="text-muted">4 Minutes Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-5.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Doris Y. Lartey</b> commented on a post you are tagged in
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img id="notification-img"src="./images/profile-6.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Keyley Jenner</b> commented on a post you are tagged in
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            
                    </div>        
              <?php
                  }
              ?>
                </div>
            </div>
</div>