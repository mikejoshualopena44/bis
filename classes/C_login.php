<?php

class Login
{

	private $error = "";
 
    public function evaluate($data)
    {
        // Read if the user exists in the database
        $email = addslashes($data['email']);
        $password = $data['password'];

        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

        $DB = new CONNECTION_DB();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];
			

			//reading hashed password
            if (password_verify($password, $row['password'])) {
                // Password is correct
                $_SESSION['Bisuconnect_stud_ID'] = $row['stud_ID'];

                // Check conditions for admin access
                if ($row['stud_ID'] == 12252023 
				&& $row['firstName'] == 'Admin' 
				&& $row['lastName'] == 'admin' 
				&& $row['email'] == 'admin@bisu.edu.ph')
				{
                    // Redirect to admin.php for admin
                    header("Location: admin.php");
                    exit();
                } else {
                    // Redirect to Profile_page.php for non-admin users
                    header("Location: Profile_page.php");
                    exit();
                }
            } else { // wrong password
                $this->error .= "Invalid email or password<br>";
            }
        } else { // wrong email
            $this->error .= "Invalid email or password<br>";
        }

        return $this->error;
    }

	public function check_login($id)  //chck if not numeric redirect,if numeric retrieve user_data
	{

		if(is_numeric($_SESSION['Bisuconnect_stud_ID']))
		{
			$query = "SELECT * FROM users where stud_ID = '$id' LIMIT 1 ";

			$DB = new CONNECTION_DB();
			$result = $DB->read($query);

			if($result)
			{
				$user_data = $result[0];
				return  $user_data;
			}else{
				//no user found redirect to login
				header("Location: Login_page.php");
				die;
			}	

		}else{
			header("Location: Login_page.php");
			die;
		
		}

	}

    public function getIntroduction($id) {
        // Fetch the introduction from the database based on the user's ID
        $query = "SELECT introduction FROM users WHERE stud_ID = '$id' LIMIT 1";
        $DB = new CONNECTION_DB();
        $result = $DB->read($query);

        if ($result) {
            return $result[0]['introduction'];
        } else {
            return false;
        }
    }

    public function updateIntroduction($id, $introduction)
    {
        $introduction = addslashes($introduction);
        $query = "UPDATE users SET introduction = '$introduction' WHERE stud_ID = '$id'";
        $DB = new CONNECTION_DB();
        return $DB->save($query);
    }



/*	private function hash_text($text){

		$text = hash("sha1", $text);
		return $text;
	}


	public function check_login($id,$redirect = true)
	{
		if(is_numeric($id))
		{

			$query = "select * from users where userid = '$id' limit 1 ";

			$DB = new CONNECTION_DB();
			$result = $DB->read($query);

			if($result)
			{

				$user_data = $result[0];
				return $user_data;
			}else
			{
				if($redirect){
					header("Location: ".ROOT."login");
					die;
				}else{

					$_SESSION['mybook_userid'] = 0;
				}
			}
 
			 
		}else
		{
			if($redirect){
				header("Location: ".ROOT."login");
				die;
			}else{
				$_SESSION['mybook_userid'] = 0;
			}
		}

	}
	*/
 
}