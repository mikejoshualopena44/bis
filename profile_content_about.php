<hr width="1645rem">
<div class="about-me" >
 <!--    <div class="social-media">
        About Me
       
        <a style="color:deepskyblue" href="https://www.facebook.com/yourprofile" target="_blank"> <i class='bx bxl-facebook-circle' id="soc"></i></a>    
        <a style="color:aqua" href="https://twitter.com/yourusername" target="_blank"> <i class='bx bxl-twitter' id="soc"></i></a>  
        <a style="color:chocolate" href="https://www.instagram.com/yourhandle" target="_blank"> <i class='bx bxl-instagram-alt' id="soc" ></i></a>  
        <a style="color:red" href="https://www.youtube.com" target="_blank"> <i class='bx bxl-youtube' id="soc"></i></a>  
        <a style="color:cornflowerblue" href="#" target="_blank">  <i class='bx bxl-linkedin-square' id="soc"></i></a>  
         <br>
    </div>
-->
    <br><br>
        <div>
            <h2>About Me</h2>
            <br>
                <p style="font-weight: thin; color: aliceblue">
                    <?="@".$user_data['tag_name']?>
                <p>
            <br>
            <p style="font-weight: thin; color: aliceblue">
                <?php echo nl2br($user_data['introduction']); ?> 
            </p>
        </div>
        <?php
        if ($_SESSION['Bisuconnect_stud_ID'] == $user_data['stud_ID']) {
            // Display these options only if the current user's ID matches the profile user's ID
              ?>
            <div class="button">
                <input id="modalbtn" type="button" value="Edit">
            </div>
              <?php
                  }
              ?>
              <br>

    </div>
        
    </div>


</div>