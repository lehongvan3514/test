<?php
namespace test;

class Storage{
    const PATH = 'password.txt';

    static function addContent($arr){

        $current = [];
        if (file_exists(self::PATH)){
            $current = file_get_contents(self::PATH);
        }

        if (!empty($current)){
            $current = unserialize($current);
        }
        if (!(new Storage)->validateUnique($arr['user'],$current)){
            return false;
        }

        $current[] = $arr;

        $current = serialize($current);

        return file_put_contents(self::PATH, $current);

    }

    private function validateUnique($userName, $db){
        foreach ($db as $val){
            if ($val['user'] === $userName){
                return false;
            }
        }
        return true;
    }

    static function changeContent($userName, $pass){
        if (!file_exists(self::PATH)){
            return false;
        }
        $current = file_get_contents(self::PATH);
        $current = unserialize($current);

        if (empty($current)){
            return false;
        }

        $set = false;
        foreach ($current as &$val){
            if ($val['user'] === $userName){
                $val['pass'] = $pass;
                $set = true;
                break;
            }
        }

        if (!$set){
            return false;
        }

        $current = serialize($current);
        return file_put_contents(self::PATH, $current);

    }

    static function loadStorage($userName){
        $current = file_get_contents(self::PATH);

        if (empty($current)){
            return [];
        }

        $current = unserialize($current);

        foreach ($current as $user){
            if ($user['user'] === $userName){
                return $user;
            }
        }

        return false;
    }

}