<?php



class Post{

    private $error = "";

    public function create_post($stud_ID, $data, $files) //Check if user input in post area
    {

        if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image'])|| isset($data['is_cover_image'])){

            $myimage ="";
            $has_image = 0;
            $is_profile_image = 0;
            $is_cover_image = 0;

            //to separate Images between Profile,cover and Posts
            if(isset($data['is_profile_image'])|| isset($data['is_cover_image']))
            {
                $myimage = $files;
                $has_image = 1;
                
                
                if(isset($data['is_profile_image']))
                {
                    $is_profile_image = 1;
                }
                if(isset($data['is_cover_image']))
                {
                    $is_cover_image = 1;
                }

            }else
            { // check actual file

                if(!empty($files['file']['name']))
                {

                    $folder = "uploads/" . $stud_ID . "/";

                    //create folder for every user
        
                    if(!file_exists($folder))
                    {
                    mkdir($folder,0777,true);
                    }
        
                    $image_class = new Image();
        
                    //create random folder name
                    $myimage = $folder . $image_class->generate_filename(15).".jpg" ;
                    move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                    $image_class->resize_img($myimage,$myimage,1500,1500);
                    
                    $has_image = 1;
                }
            }

            $post = "";
            if(isset($data['post'])){
                $post = addslashes($data['post']);
            }

            $post = addslashes($data['post']) ;
            $post_id = $this->create_post_id();

            $query = "INSERT INTO posts (post_id,stud_ID,post,image,has_image,is_profile_image,is_cover_image ) VALUES ('$post_id','$stud_ID','$post','$myimage','$has_image','$is_profile_image','$is_cover_image' )";

            $DB = new CONNECTION_DB();
            $DB->save($query);


        }else{
            $this->error .= "Please input something to post!<br>";
        }

        return $this->error;
    }


    public function get_posts($id)  //get the posts of the user
    {
        $query = "SELECT * FROM posts WHERE stud_ID = '$id' ORDER BY id DESC LIMIT 10";

        $DB = new CONNECTION_DB();
        $result= $DB->read($query);

        if($result){
             
            return $result;
        }else{
            return false;
        }

    }

    public function get_one_posts($post_id)  //get the posts of the user
    {
        if(!is_numeric($post_id)){
            return false;
        }
        $query = "SELECT * FROM posts WHERE post_id = '$post_id' LIMIT 1";

        $DB = new CONNECTION_DB();
        $result= $DB->read($query);

        if($result){
             
            return $result[0];
        }else{
            return false;
        }

    }

    public function delete_post($post_id)  //get the posts of the user
    {
        if(!is_numeric($post_id)){
            return false;
        }
        $query = "DELETE FROM posts WHERE post_id = '$post_id' LIMIT 1";

        $DB = new CONNECTION_DB();
        $DB->save($query);

    }

   public function edit_post( $data, $files) //Check if user input in post area
    {

        if(!empty($data['post']) || !empty($files['file']['name'])){

            $myimage ="";
            $has_image = 0;
            $stud_ID = " ";


                if(!empty($files['file']['name']))
                {

                    $folder = "uploads/" . $stud_ID . "/";

                    //create folder for every user
        
                    if(!file_exists($folder))
                    {
                    mkdir($folder,0777,true);
                    }
        
                    $image_class = new Image();
        
                    //create random folder name
                    $myimage = $folder . $image_class->generate_filename(15).".jpg" ;
                    move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                    $image_class->resize_img($myimage,$myimage,1500,1500);
                    
                    $has_image = 1;
                }
    

            $post = "";
            if(isset($data['post'])){
                $post = addslashes($data['post']);
            }

            $post_id = addslashes($data['post_id']);

            if($has_image){
                $query = " UPDATE posts SET post = '$post', image = '$myimage' WHERE post_id = '$post_id' LIMIT 1";
            }else{
                $query = " UPDATE posts SET post = '$post' WHERE post_id = '$post_id' LIMIT 1";
            }          

            $DB = new CONNECTION_DB();
            $DB->save($query);


        }else{
            $this->error .= "Please input something to post!<br>";
        }

        return $this->error;
    }
    
    public function get_likes($id, $type)
    {
        $DB = new CONNECTION_DB();
        $type = addslashes($type);

        if(is_numeric($id) ){

            
            //get like details
            $sql = "SELECT likes FROM likes WHERE type='$type' && content_id = '$id' LIMIT 1";
            $result = $DB->read($sql);

            //avoid user to like again if already click like
            if(is_array($result)) {

                $likes = json_decode($result[0]['likes'],true);

                return $likes;
            }

        }

        return false;
    }

  
    public function get_likes_with_users($id, $type, $limit = 3)
    {
        $DB = new CONNECTION_DB();
        $User = new User();
        $type = addslashes($type);
    
        if (is_numeric($id)) {
            // Get like details
            $sql = "SELECT likes FROM likes WHERE type='$type' && content_id = '$id' LIMIT 1";
            $result = $DB->read($sql);
    
            // Avoid user to like again if already click like
            if (is_array($result)) {
                $likes = json_decode($result[0]['likes'], true);
    
                // Extract stud_ID values
                $studIDs = array_column($likes, 'stud_ID');
    
                // Fetch user data for the likes
                $users = [];
                foreach ($studIDs as $studID) {
                    $friend_user = $User->get_user($studID);
                    if ($friend_user) {
                        $users[] = $friend_user;
                    }
                }
    
                // Limit the result to the specified number
                $limitedUsers = array_slice($users, 0, $limit);
    
                return $limitedUsers;
            }
        }
    
        return false;
    }
    
    

    public function like_post($id, $type, $Bisuconnect_stud_ID)
    {
       

        if($type == "post"){

            $DB = new CONNECTION_DB();
            //increment attribute like on likes table
            $sql = "SELECT likes FROM likes WHERE type='post' && content_id = '$id' LIMIT 1";
            $result = $DB->read($sql);

            //avoid user to like again if already click like
            if(is_array($result)){

                $likes = json_decode($result[0]['likes'],true);

                $stud_ids = array_column($likes, "stud_ID");

            //if user like it already
                if(!in_array($Bisuconnect_stud_ID, $stud_ids )){
                    $arr["stud_ID"] = $Bisuconnect_stud_ID;
                    $arr["date"] = date("Y-m-d H:i:s");

                    $likes[] = $arr;
                    $likes_string = json_encode($likes);
                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type='post' && content_id = '$id' LIMIT 1 ";
                    $DB->save($sql);

                    
                    //increment attribute like on post table
                    $sql = "UPDATE posts SET likes = likes + 1 WHERE post_id = '$id' LIMIT 1";           
                    $DB->save($sql);

                }else
                {
                    $key = array_search($Bisuconnect_stud_ID, $stud_ids);
                    unset($likes[$key]);
    
                    $likes_string = json_encode($likes);
                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type='$type' && content_id = '$id' LIMIT 1";
                    $DB->save($sql);

                    //decrement attribute like on post table
                    $sql = "UPDATE posts SET likes = likes - 1 WHERE post_id = '$id' LIMIT 1";           
                    $DB->save($sql);
    
                }


            }else{
                $arr["stud_ID"] = $Bisuconnect_stud_ID;
                $arr["date"] = date("Y-m-d H:i:s");

                $arr2[] = $arr;

                $likes = json_encode($arr2);
                $sql = "INSERT INTO likes (type,content_id,likes ) VALUES ('$type','$id','$likes')";
                $DB->save($sql);

                //increment attribute like on post table
                $sql = "UPDATE posts SET likes = likes + 1 WHERE post_id = '$id' LIMIT 1";           
                $DB->save($sql);
                
            }
        }
            

        
    }

    private function create_post_id()   //Generate random number for every post of the user
    {

        $length = rand(4,19);
        $number = "";

        for ($i=0; $i<$length; $i++ ){
            $new_rand = rand(0,9);

            $number = $number . $new_rand;
        }
        return $number;

    }



}



?>