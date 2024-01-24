<?php

Class Settings
{
    public function get_settings($id)
    {
        $DB = new CONNECTION_DB();
        $sql = "SELECT * FROM users WHERE stud_ID = '$id' LIMIT 1 ";
        $row = $DB-> read($sql);

        if(is_array($row)){

            return $row[0];
        }

    }


    public function save_settings($data, $id)
    {
        $DB = new CONNECTION_DB();

        // Check if firstName and lastName are provided
        if (empty($data['firstName']) || empty($data['lastName'])) {
            // Show an alert if either firstName or lastName is empty
            echo "<script>alert('First name or last name should be provided');</script>";
            return; // Stop execution if not provided
        }
        
        if (!preg_match('/^[a-zA-Z ]+$/',($data['firstName']) ) || !preg_match('/^[a-zA-Z ]+$/',($data['lastName']) )) {
            // Show an alert if either firstName or lastName is empty
            echo "<script>alert('First name or last name should be consists of letter');</script>";
            return; // Stop execution if symbols provided
        }

        // Check if firstName and lastName are less than 16 characters
        if (strlen($data['firstName']) > 16 || strlen($data['lastName']) > 16) {
            // Show an alert if either firstName or lastName is longer than 16 characters
            echo "<script>alert('First name or last name should be less than 16 characters');</script>";
            return; // Stop execution if too long
        }

    
        // Check if password is provided and matches confirmation
        if (!empty($data['password']) && $data['password'] === $data['password2']) {
            // Check if the password is at least 4 characters long
            if (strlen($data['password']) >= 4) {
                // Hash the password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                // Show an alert if the password is less than 4 characters long
                echo "<script>alert('Password should be at least 4 characters long');</script>";
                return;
                // Do not update the password in this case
                unset($data['password']);
            }
        } else {

            // Show an alert if the passwords don't match
            if (!empty($data['password']) || !empty($data['password2'])) {
                echo "<script>alert('Password doesn\'t match');</script>";
                return;
            }
            // Do not update the password if not provided or doesn't match confirmation
            unset($data['password']);
        }
    
        unset($data['password2']);
    
        $sql = "UPDATE users SET ";
    
        foreach ($data as $key => $value) {
            // Check if the current key is 'firstName' or 'lastName'
            // If yes, capitalize the first letter and convert the rest to lowercase
            if ($key === 'firstName' || $key === 'lastName') {
                $value = ucfirst(strtolower($value));
            }
    
            $sql .= $key . "='" . $value . "' ,";
        }
    
        $sql = rtrim($sql, ", ") . " WHERE stud_ID = '$id' LIMIT 1";
    
        $DB->save($sql);

        // Redirect to Profile_page.php
        header("Location: Profile_page.php");
        die;

    }
    


}

?>