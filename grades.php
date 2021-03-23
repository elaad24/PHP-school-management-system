<?php 

session_start();

require_once "app/db_config.php";
require_once "app/helpers.php";
$title_page = 'grades';
include_once "tpl/header.php" ;


$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

if ($_SESSION['permission_group']==2){
 /***
  * the information that STUDENTS will see
 */

    $student_id=$_SESSION['user_id'];
    
    $sql="SELECT g.subject AS 'subject',
    g.test_subject AS 'test_subject' ,
     DATE_FORMAT(g.date,'%d/%m/%Y') AS 'date' ,
    g.grade AS 'grade' ,
    DATE_FORMAT(g.upload_time , '%ss') AS 'upload_time' 
    FROM grades g 
    WHERE student_id =$student_id ";
    
    
    $result=mysqli_query($link,$sql);
    
    
    
    if($result && mysqli_num_rows($result)>0){
        

         $grades=mysqli_fetch_all($result,MYSQLI_ASSOC);

         
        }

    global $grades;
    

function grade_table_row($grade,$iternum){
    /***
     * take row from asositive array and 
     * change it so it will be display in html table form row 
     * 
     * @param array -> a row from the full array from the db 
     * @param integer -> the number of iteration - to dislay in the table   
    */
    extract($grade);
    $count=$iternum+1;
  echo  " <tr>
        <th scope='row'>$count</th>
        <td>$date</td>
        <td>$subject</td>
        <td>$test_subject</td>
        <td>$grade</td>
        <td>avrge</td>
        </tr>
        ";
    }

}

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

                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Test Subject</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">avrg</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                            for($i=0;$i<count($grades);$i++){
                                grade_table_row($grades[$i],$i);

                            }
                            
                            /* foreach($grades as $grade){
                                grade_table_row($grade,$grades[$grade]);

                            } */?>  
                           
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>


        </div>
    </section>
</main>

<?php include_once "tpl/footer.php" ?>