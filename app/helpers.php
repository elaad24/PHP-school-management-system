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
    }
     
     if(!function_exists('login_user')){
        
        /**
         *
         * take the information from the user 
         * when log-in and enter it to session 
         * and collect info from user computer 
         * for auth in next pages 
         * 
         * @param string $id -> user id 
         * @param string $name -> user name
         * @param  string $permission_group -> the premision group of the user
         * 
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

        /**
         *  check if the user realy log-in and not just play 
         *  with the cookies and check that it is not
         *  a cross Site Request Forgery attack
         *  if logged in boolen->true
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


     if(!function_exists('grade_students_table_row')){
                        
        /**
         * to make the tables for STUDENTS  
         * take row from asositive array and 
         * change it so it will be display in html table form row 
         * 
         * @param array -> a row from the full array from the db 
         * @param integer -> the number of iteration - to dislay in the table   
         * @param array -> associative array of grades - name_subject->grade
         *
         * @return string -> return a full row for table in html  
         */
        function grade_students_table_row($grade,$iternum,$average_grade_array){
            
            extract($grade);
            $count=$iternum+1;
            if($grade > $average_grade_array[$test_subject]){
                $relative_to_average="<span class=\" text-success \">above average grade</span>";
            }elseif($grade== $average_grade_array[$test_subject]){
                $relative_to_average="<span class=\" text-warning \"> average grade</span>";
            }else{
                $relative_to_average="<span class=\" text-danger \"> below average grade</span>";
            }
        echo  " <tr>
                <th scope='row'>$count</th>
                <td>$date</td>
                <td>$subject</td>
                <td>$test_subject</td>
                <td>$grade</td>
                <td>$relative_to_average</td>
                </tr>
                ";
            }
     }


     if(!function_exists('grade_teachers_table_row')){
                        
        /**
         * to make the table for TEACHERS 
         * take row from asositive array and 
         * change it so it will be display in html table form row 
         * 
         * @param array -> a row from the full array from the db 
         * @param integer -> the number of iteration - to dislay in the table   
         * @param array -> associative array of grades - name_subject->grade
         * 
         * @return string -> return a full row for table in html  
         */
        function grade_teachers_table_row($grade,$iternum,$average_grade_array){
            
            extract($grade);
            $count=$iternum+1;
            if($grade > $average_grade_array[$test_subject]){
                $relative_to_average="<span class=\" text-success \">above average grade</span>";
            }elseif($grade== $average_grade_array[$test_subject]){
                $relative_to_average="<span class=\" text-warning \"> average grade</span>";
            }else{
                $relative_to_average="<span class=\" text-danger \">below average grade</span>";
            }
        echo  " <tr>
                <th scope='row'>$count</th>
                <td>$class</td>
                <td>$name</td>
                <td>$subject</td>
                <td>$test_subject</td>
                <td>$grade</td>
                <td>$date</td>
                <td>$relative_to_average</td>
                <td>
                <a  href='./edit_grade.php?gid=$grade_id'
                    <i class='fas fa-edit'></i>
                Edit
                </a>
                </td>
                </tr>
                ";
            }
     }


     if(!function_exists('contact_students_table_row')){
                        
        /**
         * to make the table for TEACHERS 
         * take row from asositive array and 
         * change it so it will be display in html table form row 
         *
         *@param array -> a row from the full array from the db 
         * @param integer -> the number of iteration - to dislay in the table   
         * @parm array -> associative array of grades - name_subject->grade
         *
         * @return string -> return a full row for table in html  d
         */
        function contact_students_table_row($contacts,$iternum){
            
            extract($contacts);
            $count=$iternum+1;
        echo  " <tr>
                <th scope='row'>$count</th>
                <td>$name</td>
                <td>$class</td>
                <td>$phone_number</td>
                </tr>
                ";
            }
     }


     
     if(!function_exists('contact_teachers_table_row')){
                        
        /**
         *  to make the table for TEACHERS 
         * take row from asositive array and 
         * change it so it will be display in html table form row 
         *
         * @param array -> a row from the full array from the db 
         * @param integer -> the number of iteration - to dislay in the table   
         * @parm array -> associative array of grades - name_subject->grade
         * @return string -> return a full row for table in html 
         */
        function contact_teachers_table_row($contacts,$iternum){
            
            extract($contacts);
            $count=$iternum+1;
        echo  " <tr>
                <th scope='row'>$count</th>
                <td>$name</td>
                <td>$class</td>
                <td>$address</td>
                <td>$phone_number</td>
                </tr>
                ";
            }
     }



     if(!function_exists('contact_admin_table_row')){
                        
        /**
         * to make the table for ADMIN   
         * take row from asositive array and 
         * change it so it will be display in html table form row 
         *
         * @param array -> a row from the full array from the db 
         * @param integer -> the number of iteration - to dislay in the table   
         * @parm array -> associative array of grades - name_subject->grade
         *
         * @return string -> return a full row for table in html 
         */
        function contact_admin_table_row($contacts,$iternum){
            
            extract($contacts);
            $count=$iternum+1;
        echo  " <tr>
                <th scope='row'>$count</th>
                <td class='pl-5'>$user_id</td>
                <td class='pl-4'>$name</td>
                <td>$class</td>
                <td>$address</td>
                <td>$phone_number</td>
                </tr>
                ";
            }
     }
     if(!function_exists('add_grade')){
             
         
                  
         /**
          * take the student name and id number and iteration to 
          * create a table whit input box to enter the grade 
          * the input that enter is finely when wubmit sent to the 
          * server with method post and name grade$id-> ei;- grade15
          *
          * @param string -> the student name 
          * @param string -> the student id number
          * @param integer -> the number of loop - just for numbering the rows in table 
          * 
          * @return html_code -> return table whit the student name and input box for the grade 
          */
         function add_grade($student_name,$id,$iternum){
      
            
            
            $count=$iternum+1;
        echo  " <tr>
                <th scope='row'>$count</th>
                <td class='pl-3'>$student_name</td>
                <td class=''><input type='grade' name='grade$id' placeholder='Test grade' class='form-control'></td>
                </tr>
                ";
            }
     }



?>