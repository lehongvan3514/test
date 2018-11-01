<?php
namespace test;
include 'Storage.php';
include 'ValidateFactory.php';
class PasswordManager{
    const PATH = 'password.txt';
    private $encryptKey = 'xxxx';
    protected $userName;
    protected $passWord;
    public function __construct(){
        if (isset($_POST['username']) || isset($_POST['password'])){
            $this->setUserName($_POST['username']);
            $this->setPass($_POST['password']);
        }
        session_start();
        if (isset($_SESSION['login_user'])){
            $this->setUserName($_SESSION['login_user']);
        }
    }
    //get singleton
    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }
    // open ssl encrypt, i'm not sure the requirement is hash or encrypt
    protected function encrypt($str){
        return openssl_encrypt($str, 'AES-128-CBC', $this->encryptKey);
    }


    protected function verifyPassword($userName, $pass){
        $storageUser = Storage::loadStorage($userName);

        if (empty($storageUser)){
            return false;
        }

        if ($pass !== $storageUser['pass']){
            return false;
        }

        return true;
    }

    public function validatePassword($pass = null){
        $listValidate = [
            'WhiteSpace', 'Length', 'UpperAndLower', 'DigitAndSymbol'
        ];

        if (empty($pass)&& empty($this->passWord)){
            return $this->buildResult(false, 'Please enter your password');
        }

        if (empty($pass)){
            $pass = $_POST['password'];
        }
        foreach ($listValidate as $validate){
            $validator = ValidateFactory::create($validate);
            if (empty($validator)){
                return $this->buildResult(false, 'Validator Not Found');
            }
            $ret = $validator->validate($pass);
            if (!$ret['res']){
                return $ret;
            }
        }
        return $this->buildResult(true, 'Success');
    }

    public function createNewUser(){
        if (empty($this->passWord) || empty($this->userName)){
            return $this->buildResult(false, 'Please enter your user name and password');
        }
        $arr = [
            'user'=> $this->userName,
            'pass' => $this->passWord,
        ];
        $validation = $this->validatePassword();
        if (!$validation['res']){
            return $validation;
        }
        if (Storage::addContent($arr)){
            $this->setSessionLogin($this->userName);
            return $this->buildResult(true, $this->userName.' Create Success');
        }
        return $this->buildResult(false, 'Duplicate User Name');
    }


    public function setNewPassword(){
        if (!isset($_POST['new_password'])){
            return $this->buildResult(false, 'Please enter your new password');
        }
        $pass = $_POST['new_password'];
        $userName = $this->userName;
        $validation = $this->validatePassword($pass);
        if (!$validation['res']){
            return $validation;
        }

        if (!Storage::changeContent($userName, $this->encrypt($pass))){
            return $this->buildResult(false, 'Failure');
        }
        return $this->buildResult(true, 'Success');

    }

    public function logout(){
        session_destroy();
    }

    public function login(){
        if ($this->isLogin()){
            session_destroy();
        }

        if (empty($this->passWord) || empty($this->userName)){
            return $this->buildResult(false, 'Please enter your user name and password');
        }

        if (!$this->verifyPassword($this->userName, $this->passWord)){
            return $this->buildResult(false, 'Wrong user name or password');

        }
        $this->setSessionLogin($this->userName);
        return $this->buildResult(true, $this->userName.' Login Success');
    }

    private function setSessionLogin($userName){
        $_SESSION['login_user']= $userName;
    }

    public function setUserName($userName){
        $this->userName = $userName;
    }

    public function setPass($pass){

        $this->passWord = $this->encrypt($pass);
    }

    private function isLogin(){
        if (isset($_SESSION['login_user'])){
            return true;
        }
        return false;
    }

    private function buildResult($res, $mess){
        return [
            'res' => $res,
            'mess' => $mess,
        ];
    }
}