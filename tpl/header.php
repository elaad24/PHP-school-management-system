<?php 

#the header MUST be after the user_auth() to work properly ! 

define('LOGO', '<i class="fas fa-graduation-cap"></i> Management System'); 
require_once "./app/helpers.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= isset($title_page) ? " SMS | $title_page" : 'School Management System'; ?> </title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="./css/style.css" />

    <!-- JS -->
    <script defer src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script defer src="./js/script.js"></script>

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-expand-sm navbar-dark bg-primary shadow-lg">
            <div class="container">
                <!-- LOGO -->
                <a class="navbar-brand" href="./">
                    <?= LOGO; ?>
                </a>
                <!-- BOOTSTRAP NAVBAR TOGGLER -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- NAVBAR LINKS -->
                <div class="collapse navbar-collapse" id="navbarsExample04">
                    <!-- NAVBAR LEFT LINKS -->
                    <ul class="navbar-nav mr-auto">
                        <?php if(user_auth()):?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./contacts.php">contacts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./grades.php">grades</a>
                            </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="./howToUse.php">How To Use</a>
                                </li>
                        <?php endif ?>
                        <?php  if( isset($_SESSION['user_id'])){
                                    if($_SESSION['permission_group']==0){
                                        ?>
                                            <li class="nav-item">
                                                <a class="nav-link text-white" href="./adduser.php">add users</a>
                                             </li>
                                        <?php 
                                    }    
                                 }
                                        ?>
                        
                    </ul>
                    <!-- NAVBAR RIGHT LINKS -->
                    <ul class="navbar-nav ml-auto ">
                        <?php if (!user_auth()) : ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./login.php">Log In</a>
                            </li>
                            
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./profile.php"><?= $_SESSION['user_name']; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./logout.php">Sign Out</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>

            </div>
        </nav>
    </header>