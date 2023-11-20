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
               
            }

            if($key == "firstName")
            {
                if (is_numeric($value))
                {
                    $this->error .="First name should be consists of letter!<br>";
                }             
            }
            

            if($key == "lastName")
            {
                if (is_numeric($value))
                {
                    $this->error .="Last name should be consists of letter!<br>";
                }

                if (strstr($value, " "))
                {
                    $this->error .="Last name can't have spaces!<br>";
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
                  VALUES ('$stud_ID','$firstName','$lastName','$gender','$email', '$passwordHash','$url_address')";

        

        $DB = new CONNECTION_DB();
        $DB->save($query);
    }

}

?>