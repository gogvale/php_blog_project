<?php

$h = new Helper();
$msg = '';
$username = $_POST['username'];
$is_admin = $_POST['is_admin'];

if ($h->isEmpty([$username, $is_admin])) {
    header("Location admin.php");
} else {
    if ($_POST['submit']) {
        $title = $_POST['title'];
        $post = $_POST['post'];
        $audience = $_POST['audience'];
        if ($h->isEmpty([$title, $post, $audience])) {
            $msg = "All fields required";
        } else {
            $admin = new Admin($username);
            $admin->insertIntoPostDB($title, $post, $audience);
            $msg = "Message saved successfully";
        }
    }
}