<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "eng.ahmedrammadan@gmail.com";
    $to = "deve.ahmedramadan@gmail.com";
    $subject = "Checking PHP mail";
    $message = "PHP mail works just fine";
    $headers = "From:" . $from;
    mail($to, $subject, $message, $headers);
    echo "The email message was sent.";
