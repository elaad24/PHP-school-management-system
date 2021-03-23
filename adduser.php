<?php

require_once 'app/helpers.php';
require_once 'app/db_config.php';

session_start();
if ($_SESSION['permission_group']!=0) {
    header('location: ./');
    exit();
}


$title = "add user";
include_once "./tpl/header.php" ;

$errors=[
    'name'=>'',
    'email'=>'',
    'password'=>'',
    'permission_group'=>'',
    'phone_number'=>'',
    'address'=>'',
    'class'=>'',
    'recheck'=>'',
    'submit'=>''
];



if(isset($_POST['submit'])){

    

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $permission_group = filter_input(INPUT_POST, 'permission_group', FILTER_SANITIZE_STRING);
    $phone_number = filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_STRING);
    $recheck= filter_input(INPUT_POST, 'recheck', FILTER_SANITIZE_STRING);
    $recheck= ($_POST['recheck'] ='DONE')? "TRUE" : '';

   
    
    if (!$email || !$password|| !$name || !$permission_group || !$recheck) {
        $errors['submit'] = 'All  * field are required';
       
        
    } else{
        
        if(!$phone_number || !$address || !$class){
            
            if(!$phone_number){
                $phone_number="";
            }
            if(!$address){
                $address="";
            }
            if(!$class){
                $class="";
            }
        }
        
        
        $link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
        $email=mysqli_real_escape_string($link,$email);
        $password=mysqli_real_escape_string($link,$password);
        $name=mysqli_real_escape_string($link,$name);
        $permission_group=mysqli_real_escape_string($link,$permission_group);
        $phone_number=mysqli_real_escape_string($link,$phone_number);
        $address=mysqli_real_escape_string($link,$address);
        $class=mysqli_real_escape_string($link,$class);
        
        
        $passwordB4hash=$password;
        $password=password_hash($password,PASSWORD_BCRYPT);
        
        $sql="INSERT INTO users (email,name,password,passwordB4hash,permission_group,phone_number,address,class) 
        VALUES ('$email','$name','$password','$passwordB4hash','$permission_group','$phone_number','$address','$class') ";
       
        
        $result=mysqli_query($link,$sql);
        
        
        if($result && mysqli_affected_rows($link)>0){
            
            echo "user added";
            $_REQUEST['email']=$_REQUEST['password']=$_REQUEST['name']=$_REQUEST['permission_group']=$_REQUEST['phone-number']=$_REQUEST['address']=$_REQUEST['class']='';
                     
        }

    }};


?>

<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">- admin page - </h1>
                <p>add useres to db </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mx-auto">
                <form action="" method="POST" novalidate="1" autocomplete="off">
                    
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span> Name:</label>
                        <input  type="text" name="name" id="name" class="form-control"  autofocus  value=<?= last_value('name') ?> >
                        <?php if($errors['name']) :  ?>
                        <span class="text-danger"><?= $errors['name'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="email"><span class="text-danger">*</span> Email:</label>
                        <input  type="email" name="email" id="email" class="form-control"  value=<?= last_value('email') ?>  >
                        <?php if($errors['email']) :  ?>
                        <span class="text-danger"><?= $errors['email'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span>Password</label>
                        <input type="text" name="password" id="password" class="form-control"  value=<?= last_value('password') ?>>
                        <?php if($errors['password']) :  ?>
                        <span class="text-danger"><?= $errors['password'] ?></span>
                        <?php endif ?>
                    </div>  

                    <div class="form-group">
                        <label for="permission_group"><span class="text-danger">*</span> permission-group :</label>
                        <br>
                        <label for="permission_group"><span class="text-info">*</span> <small> 0-admin, 1-teacher,2-student,3-non </small> </label>
                        <input  type="number" min="0" max="3" name="permission_group" id="permission_group" class="form-control"  value="3"  value=<?= last_value('permission_group') ?>>
                        <?php if($errors['permission_group']) :  ?>
                        <span class="text-danger"><?= $errors['permission_group'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="phone-number">phone-number :</label>
                        <input  type="number" maxlength="15" name="phone-number" id="phone-number" class="form-control" value=<?= last_value('phone-number') ?> >
                        <?php if($errors['phone_number']) :  ?>
                        <span class="text-danger"><?= $errors['phone-number'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="address">address :</label>
                        <input  type="text" name="address" id="address" class="form-control"   value=<?= last_value('address') ?> >
                        <?php if($errors['address']) :  ?>
                        <span class="text-danger"><?= $errors['address'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="class"> class :</label>
                        <input  type="text" name="class" id="class" class="form-control"  value=<?= last_value('class') ?>  >
                        <?php if($errors['class']) :  ?>
                        <span class="text-danger"><?= $errors['class'] ?></span>
                        <?php endif ?>
                    </div>
                        
                    <div class="form-group">
                        
                        <label  for="recheck"> <span class="text-danger">*</span> "type 'DONE' after recheck that all field are correct " </label>
                        <input  type="text" name="recheck" id="recheck"  class="form-control"  placeholder="type DONE" >
                        <?php if($errors['recheck']) :  ?>
                        <span class="text-danger"><?= $errors['recheck'] ?></span>
                        <?php endif ?>
                    </div>

                    <input type="submit" value="Sign In" name="submit" class="btn btn-primary mx-auto">
                    <span class="ml-4 text-danger"><?= $errors['submit']; ?></span>

                </form>
            </div>
        </div>
    </section>

</main>

<?php include_once "tpl/footer.php" ?>