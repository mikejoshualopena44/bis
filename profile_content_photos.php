

<br>
<hr width="1645rem">
<div class="profile-posts" >
    <div class=""></div>
        


    <!--img-->
    <?php

        $DB = new CONNECTION_DB();
        $image_class = new Image();

        $sql = "SELECT image, post_id FROM posts WHERE has_image = 1 && stud_ID = $user_data[stud_ID] ORDER BY id DESC LIMIT 100 ";
        $images = $DB->read($sql);

        if (is_array($images)) {
            foreach ($images as $image_row) {
                $postID = $image_row['post_id'];

                // Skip if the image is a profile or cover photo
                if ($image_class->isProfileOrCoverImage($postID)) {
                    continue;
                }

                echo "<a class='info' href='single_post_photos.php?id=$image_row[post_id]'> ";
                echo "<img src='" . $image_class->get_thumb_posts($image_row['image']) . "' class='photos' />";
                echo "</a>";
            }
        } else {
            echo "No Images were found!";
        }


    ?>
    </div>

</div>
