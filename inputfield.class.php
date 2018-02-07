<?php namespace MariuszAnuszkiewicz\src\Input;

class InputField {

   public static function exists($type = 'post'){

       switch($type){

           case 'post':
                return (!empty($_POST)) ? true : false;
                break;
           case 'get':
                return (!empty($_GET)) ? true : false;
                break;
           default :
                return false;
                break;

       }
   }

   public static function load($key){

       if (isset($_POST[$key])) {
           return $_POST[$key];
       }
       elseif (isset($_GET[$key])) {
           return $_GET[$key];
       }
       return;
   }
}
