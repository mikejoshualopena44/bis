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

                    $allowed_types = ['image/jpeg', 'image/png'];
                    $file_type = mime_content_type($files['file']['tmp_name']);
                    
                    if (!in_array($file_type, $allowed_types)) {
                        $this->error .= "Only images of JPEG and PNG format are allowed.<br>";
                        return $this->error;
                    }
                    // Check if the file is a valid image using getimagesize
                    $image_info = getimagesize($files['file']['tmp_name']);
            
                    if ($image_info === false) {
                        $this->error .= "Invalid image file. Please upload a valid image.<br>";
                        return $this->error;
                    }

                    //create folder for every user   
                    $folder = "uploads/" . $stud_ID . "/";                        
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
            $parent = 0;
            $DB = new CONNECTION_DB();

            if(isset($data['parent']) && is_numeric($data['parent'])){
                $parent = $data['parent'];

                $sql = "UPDATE posts SET comments = comments +1 WHERE post_id = '$parent' LIMIT 1";
                $DB->save($sql);
            }
            $query = "INSERT INTO posts (post_id,stud_ID,post,image,parent,has_image,is_profile_image,is_cover_image ) VALUES ('$post_id','$stud_ID','$post','$myimage','$parent','$has_image','$is_profile_image','$is_cover_image' )";

            
            $DB->save($query);


        }else{
            $this->error .= "Please input something to post!<br>";
        }

        return $this->error;
    }

    public function get_posts($id)  //get the posts of the user
    {
        $query = "SELECT * FROM posts WHERE parent = 0 AND stud_ID = '$id' ORDER BY id DESC LIMIT 10";

        $DB = new CONNECTION_DB();
        $result= $DB->read($query);

        if($result){
             
            return $result;
        }else{
            return false;
        }

    }

    public function get_comments($id)
    {
        $query = "SELECT p.*, 
                         (SELECT COUNT(*) FROM posts WHERE parent = p.post_id) AS reply_count 
                  FROM posts p 
                  WHERE parent = '$id' 
                  ORDER BY id DESC 
                  LIMIT 50";
    
        $DB = new CONNECTION_DB();
        $result = $DB->read($query);
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    

    public function get_recent_posts($current_user_id, $limit = 50) //Get the recent posts of other user
    {
        $query = "SELECT * FROM posts WHERE parent = 0 AND (stud_ID != '$current_user_id' OR stud_ID = '$current_user_id') ORDER BY id DESC LIMIT $limit";

        $DB = new CONNECTION_DB();
        $result = $DB->read($query);

        if ($result) {
            return $result;
        } else {
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


		$Post = new Post();
		$one_post = $Post->get_one_posts($post_id);

		$DB = new CONNECTION_DB();
		$sql = "SELECT parent FROM posts WHERE post_id = '$post_id' limit 1";
		$result = $DB->read($sql);
		
		if(is_array($result)){

			if($result[0]['parent'] > 0){

				$parent = $result[0]['parent'];

				$sql = "UPDATE posts SET comments = comments - 1 where post_id = '$parent' limit 1";
				$DB->save($sql);
			}
		}
			  
        

        $query = "DELETE FROM posts WHERE post_id = '$post_id' LIMIT 1";

        $DB = new CONNECTION_DB();
        $DB->save($query);


        	//delete any images and thumbnails
		if($one_post['image'] != "" && file_exists($one_post['image']))
		{
			unlink($one_post['image']);
		}

		if($one_post['image'] != "" && file_exists($one_post['image']. "_post_thumb"))
		{
			unlink($one_post['image']. "_post_thumb");
		}

		if($one_post['image'] != "" && file_exists($one_post['image']. "_cover_thumb"))
		{
			unlink($one_post['image']. "_cover_thumb");
		}

		//delete all comments
		$query = "delete from posts where parent = '$post_id' ";
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
        $DB = new CONNECTION_DB();
    
        if ($type == "post") {
            // Fetch existing likes for the post from the database
            $sql = "SELECT likes FROM likes WHERE type='post' AND content_id = '$id' LIMIT 1";
            $result = $DB->read($sql);
    
            if (is_array($result)) {
                $likes = json_decode($result[0]['likes'], true);
    
                // Check if the user has already liked the post
                $user_already_liked = false;
                $updated_likes = [];
    
                foreach ($likes as $like) {
                    if ($like['stud_ID'] == $Bisuconnect_stud_ID) {
                        $user_already_liked = true;
                    } else {
                        $updated_likes[] = $like;
                    }
                }
    
                if (!$user_already_liked) {
                    // Add the user's like
                    $arr["stud_ID"] = $Bisuconnect_stud_ID;
                    $arr["date"] = date("Y-m-d H:i:s");
                    $updated_likes[] = $arr;
    
                    // Update the likes in the database
                    $likes_string = json_encode($updated_likes);
                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type='post' AND content_id = '$id' LIMIT 1";
                    $DB->save($sql);
    
                    // Increment the likes count on the posts table
                    $sql = "UPDATE posts SET likes = likes + 1 WHERE post_id = '$id' LIMIT 1";
                    $DB->save($sql);
                } else {
                    // User already liked, remove the like
                    $likes_string = json_encode($updated_likes);
                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type='post' AND content_id = '$id' LIMIT 1";
                    $DB->save($sql);
    
                    // Decrement the likes count on the posts table
                    $sql = "UPDATE posts SET likes = likes - 1 WHERE post_id = '$id' LIMIT 1";
                    $DB->save($sql);
                }
            } else {
                // No existing likes, create a new array with the user's like
                $arr["stud_ID"] = $Bisuconnect_stud_ID;
                $arr["date"] = date("Y-m-d H:i:s");
                $updated_likes[] = $arr;
    
                // Encode the likes array and insert it into the database
                $likes = json_encode($updated_likes);
                $sql = "INSERT INTO likes (type, content_id, likes) VALUES ('$type', '$id', '$likes')";
                $DB->save($sql);
    
                // Increment the likes count on the posts table
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