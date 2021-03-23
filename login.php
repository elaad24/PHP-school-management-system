<?php

require_once 'app/helpers.php';
require_once 'app/db_config.php';

session_start();
if (user_auth()) {
    header('location: ./');
    exit();
}


$title = "Log In";
include_once "./tpl/header.php" ;



$errors=[
    'email'=>'',
    'password'=>'',
    'submit'=>''
];



if(isset($_POST['submit'])){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    if (!$email || !$password) {
        $errors['submit'] = '* All field are required';

        
    } else{

        $link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
        $email=mysqli_real_escape_string($link,$email);
        $password=mysqli_real_escape_string($link,$password);

        $sql="SELECT * FROM users WHERE email='$email' LIMIT 1";

        $result=mysqli_query($link,$sql);
 
        if($result && mysqli_affected_rows($link)===1){
            
            $user=mysqli_fetch_assoc($result);

            if(password_verify($password,$user['password'])){
                login_user($user['id'],$user['name'],$user['permission_group']);
            }
            
        }



    }};


?>

<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">Login to the school management system </h1>
                <p>from this site you will be able to manage thing from home insted of doing it in school ! </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mx-auto">
                <form action="" method="POST" novalidate="1" autocomplete="off">
                    <div class="form-group">
                        <label for="email"><span class="text-danger">*</span> Email:</label>
                        <input  type="email" name="email" id="email" class="form-control" autofocus value=<?= last_value('email') ?>  >
                        <?php if($errors['email']) :  ?>
                        <span class="text-danger"><?= $errors['email'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span>Password</label>
                        <input type="text" name="password" id="password" class="form-control">
                        <?php if($errors['password']) :  ?>
                        <span class="text-danger"><?= $errors['password'] ?></span>
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