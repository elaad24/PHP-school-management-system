<?php

require_once 'app/helpers.php';
require_once 'app/db_config.php';

session_start();
if (!user_auth()) {
    header('location: ./');
    exit();
}


$title = "profile";
include_once "./tpl/header.php" ;

;

$errors=[
    'email'=>'',
    'password'=>'',
    'new_password'=>'',
    'phone_number'=>'',
    'address'=>'',
    'submit'=>''
];

// get the info for the form 

$user_id=$_SESSION['user_id'];

$sql = " SELECT * FROM users WHERE id='$user_id' LIMIT 1  ";
$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
$result=mysqli_query($link,$sql);


if($result && mysqli_num_rows($result)===1){
    
    $user=mysqli_fetch_assoc($result);
    
    

}





if(isset($_POST['submit'])){
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
    $phone_number = filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    $email=mysqli_real_escape_string($link,$email);
    $password=mysqli_real_escape_string($link,$password);
    $new_password=mysqli_real_escape_string($link,$new_password);
    $phone_number=mysqli_real_escape_string($link,$phone_number);
    $address=mysqli_real_escape_string($link,$address);

    
    
    if ($email!=$user['email'] ) {
        
        $sql = "UPDATE users SET  email ='$email' WHERE users.id='$user[id]' ";
        $result =mysqli_query($link,$sql);
        if($result && mysqli_affected_rows($link)===1){
        
            echo "email has changed " ; }
        }
        
    if ($phone_number!=$user['phone_number'] ) {
        
        $sql = " UPDATE users SET phone_number='$phone_number' WHERE users.id='$user[id]'";
        $result =mysqli_query($link,$sql);
        if($result && mysqli_affected_rows($link)===1){
            echo "phone_number has changed " ; }
        }
        
    if ($address!=$user['address'] ) {
        
        $sql = " UPDATE users SET address='$address' WHERE users.id='$user[id]'";
        $result =mysqli_query($link,$sql);
        if($result && mysqli_affected_rows($link)===1){
            echo "address has changed " ; }
        }

    /* check if the fields password & new password are filled 
    and if there filled check if the old password is the same ass in the
    db and if it its so change the old pass word to the new password  */
    
    if($password && $new_password){
       
        if(password_verify($password,$user['password'])){
            $password=password_hash($new_password,PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password='$password' WHERE users.id='$user[id]'";
            $result =mysqli_query($link,$sql);
           
            if($result && mysqli_affected_rows($link)===1){
   
                echo "password has changed " ; }
            else{
       
                $errors['password']="the password is incorrect ! ";
     
            }
        }
    }}
?>

<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">profile page </h1>
                <p>from here you will be able to chang your parsonale settings  </p>
                
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mx-auto">
                <form action="" method="POST" novalidate="1" autocomplete="off">
                    
                    

                    <div class="form-group">
                        <label for="email"><span class="text-danger">*</span> Email:</label>
                        <input  type="email" name="email" id="email" class="form-control"  value=<?= $user['email'] ?>  >
                        <?php if($errors['email']) :  ?>
                        <span class="text-danger"><?= $errors['email'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span>Enter current password </label>
                        <input type="text" name="password" id="password" class="form-control"  >
                        <?php if($errors['password']) :  ?>
                        <span class="text-danger"><?= $errors['password'] ?></span>
                        <?php endif ?>
                    </div>  


                    <div class="form-group">
                        <label for="new_password"><span class="text-danger">*</span>Enter new password</label>
                        <input type="text" name="new_password" id="new_password" class="form-control"  >
                        <?php if($errors['new_password']) :  ?>
                        <span class="text-danger"><?= $errors['new_password'] ?></span>
                        <?php endif ?>
                    </div>  

                   

                    <div class="form-group">
                        <label for="phone-number">phone-number :</label>
                        <input  type="tel" maxlength="15" name="phone-number" id="phone-number" class="form-control" value=<?= $user['phone_number'] ?> >
                        <?php if($errors['phone_number']) :  ?>
                        <span class="text-danger"><?= $errors['phone-number'] ?></span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="address">address :</label>
                        <input  type="text" name="address" id="address" class="form-control"   value=<?= $user['address'] ?> >
                        <?php if($errors['address']) :  ?>
                        <span class="text-danger"><?= $errors['address'] ?></span>
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