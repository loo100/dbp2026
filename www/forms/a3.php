<?php
    $name = $_POST['user_name'] ?? ''; 
    $email = $_POST['user_email'] ?? '';
    $message = $_POST['user_message'] ?? '';
    echo "User Name: $name <br>";
    echo "User Email: $email <br>";
    echo "User Message: $message <br>";

