<?php
session_start();

include("admin_connection.php");

if (isset($_GET['stud_ID'])) {
    $stud_ID = $_GET['stud_ID'];

    // Assuming your users table has a column named 'stud_ID' as the primary key
    $query = "DELETE FROM users WHERE stud_ID = $stud_ID";

    $DB = new CONNECTION_DB();
    $success = $DB->save($query);

    if ($success) {
        header("Location: admin.php");
    } else {
        echo "Error deleting user with ID $stud_ID.";
    }
} else {
    echo "Invalid request. Please provide a user ID.";
}
?>
