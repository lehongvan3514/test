<?php
namespace test;
include 'Storage.php';

class PasswordManager{
    const PATH = 'password.txt';
    protected $userName;
    protected $passWord;
    public function __construct(){
        session_start();

    }

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }

    function encrypt($str){
        return md5($str);
    }

    function verifyPassword($userName, $pass){
        $storageUser = Storage::loadStorage($userName);
        if ($pass !== $storageUser['pass']){
            return false;
        }

        return true;
    }

    public function validatePassword($pass){
        return true;
    }

    public function setNewPassword($pass){
        $userName = $this->userName;

        if (!$this->validatePassword($pass)){
            return false;
        }

        return Storage::changeContent($userName, $this->encrypt($pass));

    }
    public function login(){
        if ($this->isLogin()){
            session_destroy();
        }

        if (empty($this->passWord) || empty($this->userName)){
            return false;
        }

        if (!$this->verifyPassword($this->userName, $this->passWord)){
            return false;
        }
        $_SESSION['login_user']= $this->userName;
        return $this->userName;
    }

    public function setUserName($userName){
        $this->userName = $userName;
    }
    public function isLogin(){
        if (isset($_SESSION['login_user'])){
            return true;
        }
        return false;
    }

    public function logout(){
        session_destroy();
    }

    public function setPass($pass){
        if (!$this->validatePassword($pass)){
            return false;
        }
        $this->passWord = $this->encrypt($pass);
    }
    public function createNew(){
        $arr = [
            'user'=> $this->userName,
            'pass' => $this->passWord,
        ];

        if (Storage::addContent($arr)){
            $_SESSION['login_user']= $this->userName;
            return $this->userName;
        }
        return false;
    }
}