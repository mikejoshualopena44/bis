<div class="profile-content">


    <!-- friends area-->
    <div class="friends-bar">
        <div class="label">Details and Password</div> <br>
        <div class="friends-container">                         
        <?php
            $settings_class = new Settings();
            $settings = $settings_class->get_settings($_SESSION['Bisuconnect_stud_ID']);


            if(is_array($settings)){


        echo  "<section class='contact' id='contact'>      
                <form method='post' enctype='multipart/form-data' action='#'  id='settingsForm'>
                    <div class='input-box'>
                        <input name='firstName' type='text' value='".htmlspecialchars($settings["firstName"])."' placeholder='First Name'>
                        <input name='lastName' type='text'  value='".htmlspecialchars($settings["lastName"])."' placeholder='Last Name'>
                    </div>
                    <div class='input-box'>
                        <i class='fas fa-lock'></i>
                        <input name='password' type='Password' placeholder='Password'>
                        <input name='password2' type='Password' placeholder='Password_Confirmation'>
                    </div> <br>
                    <div class='input-box'>
                        <select  value='".htmlspecialchars($settings["gender"])."' name='gender' class='round'>
                          <option>Male </option>
                          <option>Female</option>
                        </select>
                    </div>

                    <br> <br> 
                    
                    <input type='submit' value='Save Changes' class='btn'>
  
                </form>

            </section> ";       
         }
        
        
        ?>
        </div>
    </div>


</div>


