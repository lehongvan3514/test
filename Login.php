<?php
use test\PasswordManager;
include "PasswordManager.php";
$PassManager = PasswordManager::getInstance();

switch ($_POST['submit']){
    case 'Login':
        $ret = $PassManager->login();
        break;
    case 'Create':
        $ret = $PassManager->createNewUser();
        break;
    case 'Validate':
        $ret = $PassManager->validatePassword();
        $_SESSION['ret'] = $ret;
        header('Location: index.php');
        exit();
        break;
    case 'Logout':
        $ret = $PassManager->logout();
        header('Location: index.php');
        exit();
        break;
    case 'Change':
        $ret = $PassManager->setNewPassword();
        echo $ret['mess'];
        require_once 'Main.php';
        exit();
        break;

}

if ($ret['res']){
    echo $ret['mess'];
    require_once 'Main.php';
}else{
    $_SESSION['ret'] = $ret;
    header('Location: index.php');
    exit();
}


