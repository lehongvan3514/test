<?php

include "PasswordManager.php";
$a = new test\PasswordManager();
if (isset($_POST['username']) || isset($_POST['password'])){
    $a->setUserName($_POST['username']);
    $a->setPass($_POST['password']);
}

switch ($_POST['submit']){
    case 'Login':
        $ret = $a->login();
        break;
    case 'Create':
        $ret = $a->createNew();
        break;
    case 'Logout':
        $ret = $a->logout();
        header('Location: index.php');
        exit();
        break;

}

echo $ret;
require_once 'logout.php';


