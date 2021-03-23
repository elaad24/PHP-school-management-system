
<?php 

if(!function_exists('last_value')){

     /**
     * Returns last input value of field
     * 
     * @param string $field_name The field name
     * @return string The input's last value or empty string 
     */

     function last_value($field_name){
         return isset($_REQUEST[$field_name])? $_REQUEST[$field_name] : '';  
     }

     
     if(!function_exists('login_user')){

        /***
         * take the information from the user 
         * when log-in and enter it to session 
         * and collect info from user computer 
         * for auth in next pages 
         * 
        * @param string $id -> user id 
        * @param string $name -> user name
        */

        function login_user($id,$name,$permission_group){
            $_SESSION['user_id']=$id;
            $_SESSION['user_name']=$name;
            $_SESSION['permission_group']=$permission_group;

            $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent']=$_SERVER['HTTP_USER_AGENT'];
            header("location: ./");

        }
     }

     if(!function_exists('user_auth')){

        /***
         *  check if the user realy log-in and not just play 
         * with the cookies and check that it is not
         *  a cross Site Request Forgery attack
         * 
         * @return -> boolen 
        */

         function user_auth(){

             if(
                isset($_SESSION['user_id'])&&
                isset($_SESSION['user_ip'])&&
                isset($_SESSION['user_agent'])&&
                $_SESSION['user_ip']===$_SERVER['REMOTE_ADDR']&&
                $_SESSION['user_agent']===$_SERVER['HTTP_USER_AGENT']
             ){
                 return true;
             }
             return false;
         }
     }

}


?>

