<?php 

require_once "app/helpers.php";
require_once "app/db_config.php";


session_start();
if (!user_auth()) {
    header('location: ./');
    exit();
}

$title_page = 'contacts';
include_once "tpl/header.php" ;


$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

$sort=isset($_POST['sort'])? $_POST['sort'] : "name";
 /* $sort will be the var to order how to sort the list  */




 if ($_SESSION['permission_group']==2 ){

     $student_id=$_SESSION['user_id'];

    $sql_class="SELECT u.class as 'class' FROM users u WHERE u.id=$student_id ";
    $result_class=mysqli_query($link,$sql_class);
    $result_class=mysqli_fetch_assoc($result_class);
    $user_class = $result_class['class'];


     $sql="SELECT u.name AS 'name',
     u.class AS 'class',
     u.phone_number as 'phone_number',
     u.address as 'address',
     u.id AS 'id'
     FROM  users u
     WHERE u.permission_group=2 AND u.class='$user_class'

    ORDER BY $sort DESC ";

$result=mysqli_query($link,$sql);
    
    if($result && mysqli_num_rows($result)>0){
        
         $contacts=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
        }

    global $contacts;

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
  $where=isset($specific_user)? "name='$specific_user'" : 'name!="1" ' ;

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
          $where="name='$specific_user'";
       }elseif(isset($specific_user) && !in_array($specific_user,$user_list)){
           echo "<script>alert('the user name is worng try again ')</script>";
           $where= 'name!="1" ';
       }

 }
  
    
     $sql="SELECT u.name AS 'name',
     u.class AS 'class',
     u.phone_number as 'phone_number',
     u.address as 'address'
     FROM  users u
     $where
    ORDER BY $sort DESC ";

$result=mysqli_query($link,$sql);
    
    if($result && mysqli_num_rows($result)>0){
        
         $contacts=mysqli_fetch_all($result,MYSQLI_ASSOC);
 
        }

    global $contacts;

}

         

       

unset($_POST['student_name']);
?>


<!-- MAIN -->
<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">contacts page</h1>
                <p>here you can see information about your peers </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row mb-2">
            <div class="col-lg-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="m-auto text-primary ">contacts </h3>               
                
                        <?php 
                  
                  /* students contacts table */
                      if ($_SESSION['permission_group']==2):
                  ?>

              <table class="table table-striped mt-3">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Student name</th>
                              <th scope="col">Student class</th>
                              <th scope="col">Phone number</th>
                          </tr>
                      </thead>
                      <tbody>

                  <?php
                          for($i=0;$i<count($contacts);$i++)
                          {
                            contact_students_table_row($contacts[$i],$i);
                          }
                     endif 
                  ?> 


                  <?php 
                  
                    
                            
                                
                            /* teachers contacts table */
                                if ($_SESSION['permission_group']==1):
                            ?>

<form method="POST" action="" class=" mt-2 col-lg-4 col-sm-12">
                     <label for="student_name">find student by name :</label>
                        <input class="form-control my-2 col-lg-8 col-sm-12" name="student_name" type="search" 
                                placeholder="Search by student name :" >
                        <input type="submit" value="find !" class="ml-2 btn btn-primary">
                        </form>  

                        <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Student name</th>
                                        <th scope="col">Student class</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone number</th>
                                    </tr>
                                </thead>
                                <tbody>

                            <?php
                                    for($i=0;$i<count($contacts);$i++)
                                    {
                                        contact_teachers_table_row($contacts[$i],$i);
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