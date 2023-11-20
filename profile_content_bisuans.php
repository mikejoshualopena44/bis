<hr width="1645rem">
<div class="profile-posts" >
    <div class=""></div>
        


        <div class="bisuan">
                     <!--Problem: I may say add atleast 3 friends so it would fit in the desired size: SOLVED-->
                    <?php
                      $image_class = new Image();
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

</div>