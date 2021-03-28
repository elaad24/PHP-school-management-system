<?php 

session_start();


$title_page = 'Home Page';
include_once "tpl/header.php" ;


?>


<!-- MAIN -->
<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">Welcome to the school management system </h1>
                <p>from this site you will be able to manage thing from home insted of doing it in school ! </p>
                <p class="mt-4">
                    <?php if(!user_auth()):?>
                    <a href="./login.php" class="btn btn-outline-success btn-lg">
                        Log in
                    </a>
                    <?php endif ?>
                </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row mb-2">
            <div class="col-md-6">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">

                        <h3 class="mb-0 text-primary">Grades </h3>
                        <div class="mb-1 text-muted">last grade </div>
                        <p class="card-text mb-auto">GRADE AND DATE</p>
                        <?php if(user_auth()):?>
                        <a href="./grades.php" class="stretched-link">SEE FULL LIST &rightarrow;</a>
                        <?php else :?>
                        <a href="./login.php" class="stretched-link">SEE FULL LIST &rightarrow;</a>
                        <?php endif?>
                    </div>
                    <div class="col-auto d-none d-lg-block ">
                        <i class="fab fa-autoprefixer fa-7x mr-5 mt-3"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">

                        <h3 class="mb-0 text-primary">CONTACTS </h3>
                        <div class="mb-1 text-muted">LAST UPDATED @ DATE </div>
                        <p class="card-text mb-auto">CONTACT LIST</p>
                        <?php if(user_auth()):?>
                        <a href="./contacts.php" class="stretched-link">SEE FULL LIST &rightarrow;</a>
                        <?php else :?>
                        <a href="./login.php" class="stretched-link">SEE FULL LIST &rightarrow;</a>
                        <?php endif?>
                    </div>
                    <div class="col-auto d-none d-lg-block ">
                        <i class="fas fa-address-book fa-7x mr-5 mt-3"></i>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php include_once "tpl/footer.php" ?>