<?php
    
    $databaseDate = $ROW['date']; // As $ROW['date'] contains the date from the database
    $formattedDate = date('M d, Y', strtotime($databaseDate)); //Convert databse date format to desired Month,Day and Year

?>

<div class="timeline">

     <!-- Name and Date-->
    <div class="timeline-txt">
        <div class="label">
            <?php 
            //html escaping to avoid usertyping script
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
        <br>

        <?php
        if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {
            // Display these options only if the current user's ID matches the profile user's ID
              ?>

              <?php
                  }
              ?>
        
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
                    echo htmlspecialchars($ROW['post']) 
                ?>
            </div>
    </div>        
</div>