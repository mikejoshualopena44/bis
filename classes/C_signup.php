<?php

class Signup
{
    private $error = "";

    public function evaluate($data)   //Verify user input if empty or valid
    {
        foreach($data as $key => $value){
            if(empty($value))
            {
                $this->error .= $key ." is empty!<br>";
            }

            if($key == "email") //Dafault email checker
            {
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value))
                {
                    $this->error .="Invalid email address!<br>";
                }

                if ($this->isEmailExist($value)) {
                    $this->error .= "Email already exists!<br>";
                }
               
            }

            if($key == "firstName")
            {
                
                if (is_numeric($value) || !preg_match('/^[a-zA-Z ]+$/', $value))
                {
                    $this->error .="First name should be consists of letters!<br>";
                }      
                
                // Check if the length of firstName is greater than 16 characters
                if (strlen($value) > 16) {
                    $this->error .= "First name should be less than 16 characters!<br>";
                }
            }
            

            if($key == "lastName")
            {
                if (is_numeric($value) || (!ctype_alpha($value)) )
                {
                    $this->error .="Last name should be consists of letters!<br>";
                }

                // Check if the length of lastName is greater than 16 characters
                if (strlen($value) > 16) {
                    $this->error .= "Last name should be less than 16 characters!<br>";
                }

                if (strstr($value, " "))
                {
                    $this->error .="Last name can't have spaces!<br>";
                }

               
            }


            if ($key == "stud_ID") {
                // Check if the student ID already exists in the database
                if ($this->isStudentIDExists($value)) {
                    $this->error .= "Student ID already exists!<br>";
                }
            }



        }

        if($this->error == ""){
        //no error
            $this->create_user($data);
        }else{

            return $this->error;
        }
    }

    
    private function isStudentIDExists($studID)
    {
        $DB = new CONNECTION_DB();
        $studID = addslashes($studID);

        $sql = "SELECT stud_ID FROM users WHERE stud_ID = '$studID' LIMIT 1";
        $result = $DB->read($sql);

        return is_array($result) && count($result) > 0;
    }

    private function isEmailExist($email)
    {
        $DB = new CONNECTION_DB();
        $email = addslashes($email);

        $sql = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
        $result = $DB->read($sql);

        return is_array($result) && count($result) > 0;
    }


    public function create_user($data)
    {
        $stud_ID = ucfirst($data['stud_ID']);
        $firstName = ucfirst($data['firstName']);
        $lastName = $data['lastName'];
        $gender = $data['gender'];
        $email = $data['email'];
        $password = $data['password'];
        //generate url
        $url_address = "https://BisuConnect/". strtolower($firstName) .".". strtolower($lastName). "/" . strtolower(".com");

        //hash password using php password_hash($password)// hash in sql PASSWORD('$password')
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (stud_ID,firstName,lastName,gender,email,password,url_address)
                  VALUES ('$stud_ID','" . ucfirst(strtolower($firstName)) . "','" . ucfirst(strtolower($lastName)) . "','$gender','$email', '$passwordHash','$url_address')";

        

        $DB = new CONNECTION_DB();
        $DB->save($query);
    }

}

?>