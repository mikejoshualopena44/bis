<div class="profile-content">
    <!-- friends area-->
    <div class="friends-bar">
        <div class="label">Account </div> <br>
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
</div>
