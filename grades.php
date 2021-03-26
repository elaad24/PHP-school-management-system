<?php 

require_once "app/helpers.php";
require_once "app/db_config.php";


session_start();
if (!user_auth()) {
    header('location: ./');
    exit();
}

$title_page = 'grades';
include_once "tpl/header.php" ;


$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

$sort=isset($_POST['sort'])? $_POST['sort'] : "upload_time";
 /* $sort will be the var to order how to sort the list  */

if ($_SESSION['permission_group']==2){
 
    /* the information that STUDENTS will see */

    $student_id=$_SESSION['user_id'];
    
    $sql="SELECT g.subject AS 'subject',
    g.test_subject AS 'test_subject' ,
     DATE_FORMAT(g.date,'%d/%m/%Y') AS 'date' ,
    g.grade AS 'grade' ,
    DATE_FORMAT(g.upload_time , '%ss') AS 'upload_time' 
    FROM grades g 
    WHERE student_id =$student_id 
    ORDER BY $sort DESC";
    
    
    $result=mysqli_query($link,$sql);
    
    if($result && mysqli_num_rows($result)>0){
        
         $grades=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
        }

    global $grades;
    
}

if ($_SESSION['permission_group']==1 ){

    
    #check if there is a search for specific student
    $specific_user=isset($_POST['student_name'])? $specific_user=$_POST['student_name'] :"0";
    # if there isn't and the user tring to sort by any way
    # the search is empty string - so check bolean 
    # and becose 0 string as boolean is false the if happens 

    if(!boolval($specific_user)){
        unset($specific_user);
    }
    
    
    # check if there is var specific user ,
    # if there is check if the name in the users DB , if it is so add a-  where query to the main sql querry 
    # if the name not on th users DB make pop up to infer the user that the name worng 
    # and make the var as nothing -> name not eqel to "1" so everything .
    $where=isset($specific_user)? "WHERE name='$specific_user'" : 'WHERE name!="1" ' ;

    $sql_user_name_search="SELECT u.name FROM users u";

    $result_user_name_search=mysqli_query($link,$sql_user_name_search);

    if($result_user_name_search && mysqli_num_rows($result_user_name_search)>0){
        
        $result_user_name_search=mysqli_fetch_all($result_user_name_search);
        
        echo "</br>";
        $user_list=[];

        foreach($result_user_name_search as $name){
            array_push($user_list,$name[0]);
        }
        
        if(isset($specific_user) && in_array($specific_user,$user_list)){
            $where="WHERE name='$specific_user'";
         }elseif(isset($specific_user) && !in_array($specific_user,$user_list)){
             echo "<script>alert('the user name is worng try again ')</script>";
             $where= 'WHERE name!="1" ';
         }

   }
    
     $sql="SELECT g.subject AS 'subject',
     g.test_subject AS 'test_subject' ,
      DATE_FORMAT(g.date,'%d/%m/%Y') AS 'date' ,
     g.grade AS 'grade' ,
     DATE_FORMAT(g.upload_time , '%ss') AS 'upload_time' ,
     u.name AS 'name',
     u.class AS 'class'
     FROM grades g  
     LEFT JOIN users u
     ON g.student_id = u.id
     $where
    ORDER BY $sort DESC ";

$result=mysqli_query($link,$sql);
    
    if($result && mysqli_num_rows($result)>0){
        
         $grades=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
        }

    global $grades;

}

            /***
             * to make the feacher in grades table 
             * to see how the grade relative to the average
             *  
             * - make an array of all subsubject with there average .
             * 
             # required to all the users in the site 
             * */
            
     $sql_subsubject="SELECT DISTINCT g.test_subject FROM grades g ";
     $result_subsubjects=mysqli_query($link,$sql_subsubject);
     
     if($result_subsubjects && mysqli_num_rows($result_subsubjects)>0){
 
         $arr_avrge_grades=[];
         $subsubjects=mysqli_fetch_all($result_subsubjects);
 
          foreach($subsubjects as $sub ){
             
             $avrge_grade_subject=$sub[0];
             
             $sql_avreg="SELECT ROUND( AVG(g.grade) ,0)  FROM grades g
                         where test_subject='$sub[0]'";
             
             $result_avreg=mysqli_query($link,$sql_avreg);
             
             $result_avreg=mysqli_fetch_all($result_avreg);
            
             $grade_avrge=$result_avreg[0][0];
 
             $arr_avrge_grades[$avrge_grade_subject]=$grade_avrge;
             global $arr_avrge_grades;
             
         }
     }

       

unset($_POST['student_name']);
?>


<!-- MAIN -->
<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">grades page</h1>
                <p>here you can see your grades </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row mb-2">
            <div class="col-lg-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="m-auto text-primary ">Grades </h3>
                    
                  <?php 
                      /* students grades table */
                          if ($_SESSION['permission_group']==2):
                      ?>
                        <form method="POST" action="" class=" mt-2 col-lg-4 col-sm-12">
                        <label for="sort">sort by :</label>
                        <select name="sort" id="sort"> 
                        <option value="date">new to old</option>
                        <option value="grade">grades</option>
                        <option value="subject">subjects</option>
                        </select>
                        
                        <input type="submit" value="sort !" class="ml-2 btn btn-primary">
                        
                        </form>

                            <?php endif  ?>  


                            <?php 
                            /* students grades table */
                            if ($_SESSION['permission_group']==2):
                                ?>

                                <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Test Subject</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Relative to the class grade</th>
                                    </tr>
                                </thead>
                                <tbody>

                            <?php
                                    for($i=0;$i<count($grades);$i++)
                                    {
                                        grade_students_table_row($grades[$i],$i,$arr_avrge_grades);
                                    }
                               endif 
                            ?> 

                            
                                <?php 
                            /* teachers grades table */
                                if ($_SESSION['permission_group']==1):
                            ?>

                        <form method="POST" action="" class=" mt-2 col-lg-4 col-sm-12">
                        <label for="sort">sort by :</label>
                        <select name="sort" id="sort"> 
                        <option value="date">new to old</option>
                        <option value="grade">grades</option>
                        <option value="subject">subjects</option>
                        <option value="name">names</option>
                        <option value="class">class</option>
                        </select>
                        
                     
                        <input class="form-control my-2 col-lg-8 col-sm-12" name="student_name" type="search" 
                                placeholder="Search by student name :" >

                        <input type="submit" value="sort !" class="ml-2 btn btn-primary">
                        
                        </form>

                        <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Student class</th>
                                        <th scope="col">Student name</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Test Subject</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Relative to class grade</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>

                            <?php
                                    for($i=0;$i<count($grades);$i++)
                                    {
                                        grade_teachers_table_row($grades[$i],$i,$arr_avrge_grades);
                                    }
                               endif 
                            ?> 

                           
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>


        </div>
    </section>
</main>

<?php include_once "tpl/footer.php" ?>