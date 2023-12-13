<?php
include("classes/autoloader.php");

if (isset($_GET['stud_ID'])) {
    $stud_ID = $_GET['stud_ID'];

    // Assuming your users table has a column named 'stud_ID' as the primary key
    $query = "DELETE FROM users WHERE stud_ID = $stud_ID";

    $DB = new CONNECTION_DB();
    $success = $DB->save($query);

    if ($success) {
        echo "User with ID $stud_ID deleted successfully.";
    } else {
        echo "Error deleting user with ID $stud_ID.";
    }

    // Terminate script execution
    die();
} else {
    echo "Invalid request. Please provide a user ID.";
}
?>
