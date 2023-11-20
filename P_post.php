<?php
  
    $databaseDate = $ROW['date']; // As $ROW['date'] contains the date from the database
    $formattedDate = date('M d, Y', strtotime($databaseDate)); //Convert databse date format to desired Month,Day and Year

?>

<div class="timeline">
    <!-- User Default Photo-->
    <?php

        $image = "images/bman1.jpg";
        if($ROW_user['gender'] == "Female")
        {
            $image = "images/gman.jpg";
        }

        if(file_exists($ROW_user['profile_image']))
        {
            $image = $image_class->get_thumb_profile($ROW_user['profile_image']);
        }
    ?>
     <!-- User Photo-->
    <div class="timeline-img">
        <img src="<?php  echo $image ?>" alt="profile photo">
    </div>

     <!-- Name and Date-->
    <div class="timeline-txt">
        <div class="label">
            <?php 
            //html escaping to avoid usertyping script
                echo htmlspecialchars($ROW_user['firstName']) . " " . htmlspecialchars($ROW_user['lastName']); // get the array or the user_DB

                if($ROW['is_profile_image'])
                {  
                    $pronoun = "his";
                    if($ROW_user['gender'] =="Female" )
                    {
                        $pronoun = "her";
                    }
                    echo"<span style='color: white ; font-weight:normal'> updated $pronoun profile image </span>";
                }

                if($ROW['is_cover_image'])
                {  
                    $pronoun = "his";
                    if($ROW_user['gender'] =="Female" )
                    {
                        $pronoun = "her";
                    }
                    echo"<span style='color: white ; font-weight:normal'> updated $pronoun cover photo </span>";
                }
            ?>
        </div>
        <div class="date">
            <?php 
                echo $formattedDate;
            ?>
        </div>

        <?php
        if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {
            // Display these options only if the current user's ID matches the profile user's ID
              ?>
                <div class="edit <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'hidden' : ''; ?>">
                    <span id="edt-opt" class="edt">

                        Edit
                    </span>.
                    <span id="del-opt" class="del">
                        <a href="delete.php?id=<?php echo $ROW['post_id']?>">
                        Delete
                        </a>
                    </span>
                        
                </div>
              <?php
                  }
              ?>
        
        <br><br>
            <!-- Media posts -->
            <div class="posted-image">
                <?php //location C_image 
                    if (file_exists($ROW['image'])) {
                        $post_img = $image_class->get_thumb_posts($ROW['image']);
                        echo "<img src='$post_img' class='custom-image-class' />";
                    }
                ?>
            </div>

            <br>
            <!-- Caption -->
            <div class="posted-text">
                <!--special chars to avoid user typing script in textarea-->
                <?php
                //posting with white space
                    echo nl2br($ROW['post']);

                ?>
            </div>

                <br><br>

        <div class="liked-by">

            <!-- recent people reacted profile -->
            <span><img id="react_img"src="./images/profile-10.jpg" alt=""></span>
            <span><img id="react_img1" src="./images/profile-4.jpg" alt=""></span>
            <span><img id="react_img2"src="./images/profile-15.jpg"alt=""></span> 
            
            <!-- Display who likes -->
            <?php 
                $i_liked = false;

                if(isset($_SESSION['Bisuconnect_stud_ID'])){

                
                    $DB = new CONNECTION_DB();

                    $sql = "SELECT likes FROM likes WHERE type='post' && content_id = '$ROW[post_id]' LIMIT 1";
                    $result = $DB->read($sql);

                    //avoid user to like again if already click like
                    if(is_array($result)){

                        $likes = json_decode($result[0]['likes'],true);

                        $stud_ids = array_column($likes, "stud_ID");

                    //if user like it already
                        if(in_array($_SESSION['Bisuconnect_stud_ID'], $stud_ids )){
                            $i_liked = true;


                        }
                    }
                }
                $name = " ";
                    if($ROW['likes'] > 0){
                    
                       
                        if($ROW['likes'] == 1){
                            if($i_liked){
                                $name= "You loved this post";
                            }else{
                                $name= "1 person loved this post";
                            }
                        }else{
                            if($i_liked){

                                $text = "others";
                                if($ROW['likes']-1 == 1){
                                    $text = "other";
                                }
                                $name= "You and " . ($ROW['likes'] -1) . " $text loved this post";
                            }else{
                                $name= $ROW['likes'] . " people loved this post";
                            }
                           
                        }


                    }
            ?>
            <a href="people-likes.php?type=post&id=($ROW[post_id]">
                <span style="color: white"><?php echo $name ?></span>
            </a>
            
            <!-- Count number of likes -->
            <?php 
                $likes = " ";
    
                $likes = ($ROW['likes'] == 0) ? 
                    " ": 
                    $likes = ($ROW['likes'] == 1)  ?  
                        $ROW['likes'] ." Heart"   :
                        $ROW['likes'] ." Hearts";
            ?>
            <br>
          <!--  <h7><?php echo $likes?> </h7> -->

         </div>
        
        <div class="comments text-muted"  style=" color:darkgray">
            View all 199 comments
        </div>
        <!-- like, comment icon -->
        <div class="tag">
            <div class="left-icons">
                <a href="like.php?type=post&id=<?php  echo $ROW['post_id'] ?> " class="<?php echo $i_liked ? 'liked' : ''; ?>" onclick="handleLike(event)">
                    <i class='bx bx-heart bx-lg'></i>
                </a>
                <a href=""><i class='bx bx-message-dots bx-lg'></i></a>
                <a href=""><i class='bx bx-share-alt bx-lg'></i></a>
            </div>
            <div class="right-icons">
                <i class='bx bx-bookmark-plus bx-lg'></i>
            </div>
        </div>
                <br>
        <div class="line" 
        style=" height:1px;
                width:100%;
                background-color: white;
        "></div>
    </div>        
</div>

