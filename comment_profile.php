<?php
if (!function_exists('formatPostDuration')) {
    date_default_timezone_set('Asia/Manila'); //Set timezone

  function formatPostDuration($postDate) {
    $currentTime = time();
    $postTime = strtotime($postDate);
    $timeDifference = $currentTime - $postTime;

    $secondsInMinute = 60;
    $secondsInHour = $secondsInMinute * 60;
    $secondsInDay = $secondsInHour * 24;
    $secondsInMonth = $secondsInDay * 30;
    $secondsInYear = $secondsInDay * 365;

    if ($timeDifference <= 1) {
        return "Just now";
    } elseif ($timeDifference < $secondsInMinute) {
        $seconds = $timeDifference;
        return $seconds . " second" . ($seconds > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference < $secondsInHour) {
        $minutes = floor($timeDifference / $secondsInMinute);
        return $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference < $secondsInDay) {
        $hours = floor($timeDifference / $secondsInHour);
        return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference < $secondsInMonth) {
        $days = floor($timeDifference / $secondsInDay);
        return $days . " day" . ($days > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference < $secondsInYear) {
        $months = floor($timeDifference / $secondsInMonth);
        return $months . " month" . ($months > 1 ? "s" : "") . " ago";
    } else {
        $years = floor($timeDifference / $secondsInYear);
        return $years . " year" . ($years > 1 ? "s" : "") . " ago";
    }
    }
}


    $postDate = $COMMENT['date']; // As $COMMENT['date'] contains the date from the database
    $elapsedTime = formatPostDuration($postDate);

    

    $login = new Login();
    $Post = new Post();
    $likes = false;
  
  
    // show who likes the  posts
  
    $ERROR = "";
    if(isset($_GET['id']) && isset($_GET['type'])){
  
      $likes = $Post->get_likes($_GET['id'],$_GET['type']);
  
    }
    else{
      $ERROR = "No data was found!";
    }

    //declare
    $User = new User();
    $ROW_user = $user->get_user($COMMENT['stud_ID']);
  
    
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
    <div class="timeline-container">
        <div class="timeline-txt">
            <div class="label">

            <!-- for linking the name to the user profile -->

            <a href="Profile_page.php?id=<?php echo $ROW_user['stud_ID'];  ?>" style="color:#f0c310">
                <?php 
                //html escaping to avoid usertyping script          
                    echo htmlspecialchars($ROW_user['firstName']) . " " . htmlspecialchars($ROW_user['lastName']); // get the array or the user_DB
                ?>
            </a>
                <?php           

                    if($COMMENT['is_profile_image'])
                    {  
                        $pronoun = "his";
                        if($ROW_user['gender'] =="Female" )
                        {
                            $pronoun = "her";
                        }
                        echo"<span style='color: white ; font-weight:normal ; font-size: 17px'> updated $pronoun profile image </span>";
                    }

                    if($COMMENT['is_cover_image'])
                    {  
                        $pronoun = "his";
                        if($ROW_user['gender'] =="Female" )
                        {
                            $pronoun = "her";
                        }
                        echo"<span style='color: white ; font-weight:normal ; font-size: 17px'> updated $pronoun cover photo </span>";
                    }
                ?>
            </div>
            <div class="date" style="color:#fff">
                <?php 
                    echo $elapsedTime;
                ?>
            </div>

            <?php //parent of parent
            if ($_SESSION['Bisuconnect_stud_ID'] == $COMMENT['stud_ID']) {
                 if($ROW['parent'] == 0){ 
 
 
                // Display these options only if the current user's ID matches the profile user's ID
                ?>

                    <div class="edit <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'hidden' : ''; ?>">
                        <span id="edt-opt" class="edt">
                        <a href="edit.php?id=<?php echo $COMMENT['post_id']?>">
                                Edit
                            </a>
                        </span>.
                        <span id="del-opt" class="del">
                            <a href="delete.php?id=<?php echo $COMMENT['post_id']?>">
                                Delete
                            </a>
                        </span>
                            
                    </div>
                <?php
                        }
                    }
                ?>
            

                <br>
                <!-- comments -->
                <div class="posted-text">
                    <!--special chars to avoid user typing script in textarea-->
                    <?php
                    //posting with white space
                        echo nl2br($COMMENT['post']);

                    ?>
                </div>

                <br>
            <div class="liked-by">           
                <!-- Display number of likes-->
                <?php 
                    $i_liked = false;

                    if(isset($_SESSION['Bisuconnect_stud_ID'])){

                    
                        $DB = new CONNECTION_DB();

                        $sql = "SELECT likes FROM likes WHERE type='post' && content_id = '$COMMENT[post_id]' LIMIT 1";
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
                        if($COMMENT['likes'] > 0){
                        
                        
                            if($COMMENT['likes'] == 1){
                                if($i_liked){
                                    $name= "1 person loved this comment";
                                }else{
                                    $name= "1 person loved this comment ";
                                }
                            }else{
                                if($i_liked){

                                    $text = "others";
                                    if($COMMENT['likes']-1 == 1){
                                        $text = "other";
                                    }
                                    $name= $COMMENT['likes'] . " people loved this comment";
                                }else{
                                    $name= $COMMENT['likes'] . " people loved this comment ";
                                }
                            
                            }
                        }    
                
                ?>          

                <a href="people-likes.php?type=post&id=<?php echo $COMMENT['post_id']; ?>">
                    <span id="like-count-<?php echo $COMMENT['post_id']?>" class="people-react">
                        <?php echo $name; ?>
                    </span>
                </a>
                <!-- Count number of likes -->
                <?php 
                    $likes = " ";
        
                    $likes = ($COMMENT['likes'] == 0) ? 
                        " ": 
                        $likes = ($COMMENT['likes'] == 1)  ?  
                            $COMMENT['likes'] ." Heart"   :
                            $COMMENT['likes'] ." Hearts";
                ?>
            <!--  <h7><?php echo $likes?> </h7> -->

            </div>
            
            <div class="comments text-muted"  style=" color:darkgray">
                <?php

                if($ROW['parent'] == 0){ 
                    $comments = " ";
                    $sub_text = " ";
                    

                    if ($COMMENT['reply_count'] > 0) {
                        $comments = "(" . $COMMENT['reply_count'] . ")";

                        if($COMMENT['reply_count'] == 1){
                            $sub_text = "reply";
                        }else{
                            $sub_text = "replies";
                        }
                        
                    }
                }
                ?>
                
            </div>
            <!-- like, comment icon -->
            <div class="tag">
                <div class="left-icons">
                    <!-- heart-->
                    <a href="like.php?type=post&id=<?php echo $COMMENT['post_id']; ?>" class="heart <?php echo $i_liked ? 'liked' : ''; ?>" onclick="like_post(event, <?php echo $COMMENT['post_id']; ?>)">
                        <i class='bx bx-heart bx-lg'></i>
                    </a>

                    <!-- reply-->
                    <?php if($ROW['parent'] == 0){ ?>
                        <a class="cmnt" href="single_post_profile.php?id=<?php echo $COMMENT['post_id'] ?>">
                            <i class='bx bx-reply' id="icon"></i>
                            <?php echo "&nbsp  
                            <div style='font-size: 1.5rem; '> $comments </div> &nbsp
                            <div style='font-size: 1rem; float:right; '> $sub_text </div>" ?>
                        </a>
                    <?php }?>
                    <!--view image-->
                    <a class="view"href="view_image_profile.php?id=<?php echo $COMMENT['post_id'] ?>">
                    <?php
                        if($COMMENT['has_image']){

                            echo "<i class='bx bx-fullscreen'></i>";
                        }
                        ?>
                    </a>
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
</div>

