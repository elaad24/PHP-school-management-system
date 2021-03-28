<?php

require_once 'app/helpers.php';
require_once 'app/db_config.php';

session_start();
if ( $_SESSION['permission_group']!=0 && $_SESSION['permission_group']!=1) {
    header('location: ./');
    exit();
}


$title = "add grades";
include_once "./tpl/header.php" ;

$errors=[
    'subject'=>'',
    'sub_subject'=>'',
    'test_date'=>'',
    'recheck'=>'',
    'submit_grades'=>''
];


$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

#make sure that the info that enter is not malicious
$recheck= filter_input(INPUT_POST, 'recheck', FILTER_SANITIZE_STRING);
if(isset($_POST['recheck'])){
    $recheck= ($_POST['recheck'] =='DONE')? "TRUE" : '';}

$subject= filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
$sub_subject= filter_input(INPUT_POST, 'sub_subject', FILTER_SANITIZE_STRING);
$test_date= filter_input(INPUT_POST, 'test_date', FILTER_SANITIZE_STRING);

# a var to check if the first submite  has made and if it isnt 
#the seccend submit is disable 
$submited_1=(!isset($_POST['class']) || $_POST['class']=='')? "disabled" : ''  ;



 #check if the second submit has made and if it is 
 #check that all the field are filed
if (isset($_POST['submit_grades']) && (!$sub_subject || !$subject || !$test_date || !$recheck)) {
    $errors['submit_grades'] = 'All  field are required';
    if(!$sub_subject){
        $errors['sub_subject'] = 'Sub Subject is required';
    }
    if(!$subject){
        $errors['subject'] = 'Subject is required';
    }
    if(!$test_date){
        $errors['test_date'] = 'Test date is required';
    }
    if(!$recheck){
        $errors['recheck'] = 'MUST right DONE to comple the task ! ';
    }}


#check if the user chose the class 
$class_name=isset($_POST['class'])?$_POST['class'] : '';
     
if(isset($class_name));{
    # take the name and id form the chosen class and make asosative array id=>name

    $sql_users_by_class_search=
    "SELECT u.name as 'name' ,
     u.id as 'id' 
     FROM users u 
     WHERE u.class='$class_name'" ;
    
    $result_class_search=mysqli_query($link,$sql_users_by_class_search);
    
    if($result_class_search && mysqli_num_rows($result_class_search)>0){

        $result_class_search=mysqli_fetch_all($result_class_search,MYSQLI_ASSOC);
        $class_list=[];
        foreach($result_class_search as $class){
           array_push($class_list, [$class['id']=>$class['name']]);
        }
        global $class_list;
    }
}

    #check that evrything that the user should fill to 
    #add grade done - and add the grade to the db
    if(isset($_POST['submit_grades']) && $recheck  ){
        if(isset($_POST['subject']) && isset($_POST['sub_subject'])){
            $test_subject=$_POST['subject'];
            $test_sub_subject=$_POST['sub_subject'];
            $test_date=$_POST['test_date'];

            for($i=0;$i<count($class_list);$i++){
                foreach($class_list[$i] as $id=>$name){
                $grade=$_POST["grade$id"];
                #echo $test_subject , $test_sub_subject , $name ,$_POST["grade$id"] , $grade;
                $sql_insert="INSERT INTO grades (subject,test_subject,date,grade,student_id) 
                VALUES ('$test_subject','$test_sub_subject','$test_date','$grade','$id')";
                $result_add_grade=mysqli_query($link,$sql_insert);
                if(mysqli_affected_rows($link)>0){
                    echo 'works - grade add';
                }
            }}
        };
        }
?>

<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">- add grades page - </h1>
                <p>add grades to users </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mx-auto">

                <!-- check if class has been chosen and if it has it remove the 
            option to chosse class again -->
                <?php if(!isset($_POST['class']) || $_POST['class']==''):;?>
                <form action="" method="POST" novalidate="1" autocomplete="off">

                    <label for="class">class :</label>
                    <select name="class" id="class">">
                        <option value="softmore">softmore</option>
                        <option value="science">science</option>
                        <option value="computer science">computer science</option>
                        <option value="electrical engnear">electrical engnear</option>
                        <option value="engeniring">engeniring</option>
                        <option value="need asistence">need asistence</option>
                    </select>
                    <input type="submit" value="find !" name="submit" class="ml-2 btn btn-primary">
                    <?php elseif($_POST['class']!=''):
                    echo  '<h3 class="text-success">class - '.$class_name . '</h3>';?>


                    <?php  endif ?>
                </form>
                <form class="" method="POST" novalidate="1" autocomplete="off">
                    <input type='hidden' name='class' placeholder="<?= $_POST['class'] ?>"
                        value='<?= $_POST['class'] ?>'>
                    <div class="form-group col-lg-12 d-flex flex-column ">

                        <label class="" for="subject"> <span class="text-danger">*</span> Test-subject : </label>
                        <input type="subject" name="subject" placeholder="Test subject" class="form-control"
                            value=<?= last_value('subject') ?>>
                        <?php if($errors['subject']) :  ?>
                        <span class="text-danger"><?= $errors['subject'] ?></span>
                        <?php endif ?>

                        <label for="sub_subject"> <span class="text-danger">*</span> Test-Sub-subject :</label>
                        <input type="text" name="sub_subject" placeholder="sub-subject" class="form-control"
                            value=<?= last_value('sub_subject') ?>>
                        <?php if($errors['sub_subject']) :  ?>
                        <span class="text-danger"><?= $errors['sub_subject'] ?></span>
                        <?php endif ?>

                        <label for="test_date"> <span class="text-danger">*</span> Test date :</label>
                        <input type="text" name="test_date" placeholder="yyyy-mm-dd" class="form-control"
                            value=<?= last_value('test_date') ?>>
                        <?php if($errors['test_date']) :  ?>
                        <span class="text-danger"><?= $errors['test_date'] ?></span>
                        <?php endif ?>

                    </div>


                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Name</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            for($i=0;$i<count($class_list);$i++){

                                foreach($class_list[$i] as $id=>$name){
                                    add_grade($name,$id,$i);
                                }
                            }
                                ?>

                        </tbody>
                    </table>

                    <div class="form-group">

                        <label for="recheck"> <span class="text-danger">*</span> "type 'DONE' after recheck that all
                            field are correct ! " </label>
                        <input type="text" name="recheck" id="recheck" class="form-control" placeholder="type DONE">
                        <?php if($errors['recheck']) :  ?>
                        <span class="text-danger"><?= $errors['recheck'] ?></span>
                        <?php endif ?>
                    </div>

                    <input type="submit" value="set grades" name="submit_grades" <?= $submited_1?>
                        class="btn btn-primary mx-auto">
                    <span class="ml-4 text-danger"><?= $errors['submit_grades']; ?></span>

                </form>
            </div>
        </div>
    </section>

</main>

<?php include_once "tpl/footer.php" ?>