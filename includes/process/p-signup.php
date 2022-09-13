<?php

$h = new Helper();
$msg = '';
$username = '';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($h->isEmpty([$_POST['username'], $_POST['password'], $_POST['confirm_password']])) {
        $msg = "All fields required";
    } else if (!$h->isValidLength($username,6,100)) {
        $msg = "Username should be between 6 and 100 characters";
    } else if (!$h->isValidLength($password)) {
        $msg = "Password should be between 8 and 20 characters";
    } else if (!$h->isSecure($password)) {
        $msg = "Password should contain at least 1 lowercase character, 1 uppercase character and 1 digit";
    } else if (!$h->passwordsMatch($password,$confirm_password)) {
        $msg = "Passwords don't match";
    } else {
        $bm = new BlogMember($username);
        if($bm->isDuplicateID()){
            $msg = "Username already exists";
        }else{
            $bm->insertIntoMemberDB($_POST['password']);
            header("Location: index.php?new=1");
        }
    }
}