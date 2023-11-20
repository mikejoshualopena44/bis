

<br>
<hr width="1645rem">
<div class="profile-posts" >
    <div class=""></div>
        


    <!--img-->
    <?php

        $DB = new CONNECTION_DB();
        
        $sql = ("SELECT image,post_id FROM posts WHERE has_image = 1 && stud_ID = $user_data[stud_ID] ORDER BY id DESC LIMIT 30 ");
        $images = $DB->read($sql);


        $iamge_class = new Image();
        if(is_array($images)){

            foreach($images as $image_row){
                echo "<img src='". $image_class->get_thumb_posts($image_row['image']) ."' class='photos' />";
            }
            

        }
        else
        {
            echo "No Images were found!";
        }

    ?>
    </div>

</div>
