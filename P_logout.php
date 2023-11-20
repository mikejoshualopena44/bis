<?php
//intended to logout user prevent from undoing tab
session_start();

if(isset($_SESSION['Bisuconnect_stud_ID']))
{
    $_SESSION['Bisuconnect_stud_ID'] = NULL;
    unset($_SESSION['Bisuconnect_stud_ID']);
}


header("Location: Login_page.php");
die;


?>