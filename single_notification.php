
    <?php

        $User = new User();
        $id = esc($_SESSION['Bisuconnect_stud_ID']);
        $actor = $User->get_user($notif_row['stud_ID']);
        $owner = $User->get_user($notif_row['content_owner']);

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
        
            if ($timeDifference < $secondsInMinute) {
                return $timeDifference . " seconds ago";
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
        
        $notifDate = $notif_row['date']; // As $ROW['date'] contains the date from the database
        $elapsedTime = formatPostDuration($notifDate);
        

        $link = " "; 

        if($notif_row['content_type'] == "post"){

            $link = "single_post.php?id=". $notif_row['content_id'] . "&notif=". $notif_row['id'] ;

        }elseif($notif_row['content_type']  == "profile"){

            $link = "profile.php?id=". $notif_row['stud_ID']. "&notif=". $notif_row['id'] ;
        }elseif($notif_row['content_type']  == "comment"){

            $link = "single_post.php?id=". $notif_row['content_id']. "&notif=". $notif_row['id'] ;
        }



        if(is_array($actor) && (is_array($owner))){


            $query = "SELECT * FROM notification_seen WHERE stud_ID = '$id' &&  notification_id = '$notif_row[id]' LIMIT 1";
            $seen = $DB->read($query);

            if(is_array($seen)){
                $color = " ";
            }else{
                $color = "#6868c2a4";
            }

            //check notification if seen
            
            
    ?>
            <div class="notifications-popup">
                <div class="friends" style="background-color: <?=   $color  ?>">
                    <div class="profile-photo">
                    <?php
                        $image = "images/bman1.jpg"; 
                        if($actor['gender'] == "Female")
                        {
                            $image = "images/gman.jpg";
                        }
                        //if image loaded to db, uplaod it to profile
                        if(file_exists($actor['profile_image']))
                        {
                            $image = $image_class->get_thumb_profile($actor['profile_image']);
                        }

                    ?>
                    <img id="notification-img" src="<?php echo $image ?>" alt="">
                </div> 

                        <a href="<?php echo $link ?>">
                            <div class="notification-body">
                                <b id="notification_name"><?php echo $actor['firstName'] . " " . $actor['lastName'] ?></b> 

                                <?php                                
                                    if($notif_row['activity'] == "like"){
                                        echo "liked ";
                                    }elseif($notif_row['activity'] == "comment"){
                                        echo "commented on";
                                    }
                                ?>

                                <b>
                                    <?php 

                                    if($owner['stud_ID'] != $id) {
                                        echo $owner['firstName'] . " " . $owner['lastName'] . "'s" ;
                                    }else{
                                        echo "your";
                                    }
                                    

                                    ?>
                                </b> 
                                <?php                                
                                    if($notif_row['content_type'] == "post"){
                                        echo $notif_row['content_type'];

                                    }else if($notif_row['content_type'] == "comment"){
                                        echo $notif_row['content_type'];
                                    }
                                    //here


                                ?>

                                <small class="text-muted" style="padding-top: 5px;">
                                    <?php 
                                        echo $elapsedTime; 
                                    ?>
                                </small>
                            </div>
                        </a>   

        <?php

            }

        ?>

            
                </div>                                  
            </div>  