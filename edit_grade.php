<?php

require_once 'app/helpers.php';
require_once 'app/db_config.php';

session_start();
if ( $_SESSION['permission_group']!=0 && $_SESSION['permission_group']!=1) {
    header('location: ./');
    exit();
}

$title = "edit grade";
include_once "./tpl/header.php" ;



// get grade
$grade=null;

if (isset($_GET['gid']) && is_numeric($_GET['gid'])) {
    $gid = filter_input(INPUT_GET, 'gid', FILTER_SANITIZE_NUMBER_INT);

    if ($gid) {

        $link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

        $gid = mysqli_real_escape_string($link, $gid);
        $sql = "SELECT g.grade AS 'last_grade',
        g.subject AS 'test_subject',
        g.test_subject AS 'test_sub_subject',
        u.name AS 'student_name'
         FROM grades g 
        LEFT JOIN users u 
        ON g.student_id = u.id
        WHERE g.id = $gid ";

        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) === 1) {
            $grade = mysqli_fetch_all($result,MYSQLI_ASSOC);
            
            global $grade;
        }
    }
}
foreach($grade as $grad){
    extract($grad);
}
 


$errors=[
    'grade'=>'',
    'submit'=>''
];

if(isset($_POST['submit'])){

    if (!$_POST['grade']) {
        $errors['grade'] = 'The * field are required';

    } else{
        $grade = filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_STRING);

        $grade=mysqli_real_escape_string($link,$grade);
          
        $sql="UPDATE grades SET grade=$grade WHERE id=$gid" ;
        $result=mysqli_query($link,$sql);
        
        
        if($result && mysqli_affected_rows($link)>0){
            header('location: ./grades.php'); 
        }

    }};


?>

<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">- Edit Grade - </h1>
                <p>here to change the student grade  </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mx-auto">
            <div class="border">
            <h4 >- Student name : <span class="text-success"><?= $student_name?></span> </h4>
            <h4>- Test subject : <span class="text-success"><?= $test_subject?></span> </h4>
            <h4>- Test sub-subject : <span class="text-success"><?= $test_sub_subject?></span>  </h4>
            
            </div>
                <form action="" method="POST" novalidate="1" autocomplete="off">
                    
                    <div class="form-group">
                        <label for="grade"><span class="text-danger">*</span> grade:</label>
                        <input  type="text" name="grade" id="grade" class="form-control"  placeholder="last grade was <?=$last_grade?> " autofocus  value=<?= last_value('name') ?> >
                        <?php if($errors['grade']) :  ?>
                        <span class="text-danger"><?= $errors['grade'] ?></span>
                        <?php endif ?>
                    </div>

                    <input type="submit" value="change grade" name="submit" class="btn btn-primary mx-auto">
                    <span class="ml-4 text-danger"><?= $errors['submit']; ?></span>

                </form>
            </div>
        </div>
    </section>

</main>

<?php include_once "tpl/footer.php" ?>