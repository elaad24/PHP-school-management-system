<?php 

$title_page = 'Guide';
include_once "tpl/header.php" ;


?>


<!-- MAIN -->
<main class="container flex-fill">

    <section id="main-top-content">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">Welcome to instructor for management system </h1>
                <p>here you will understand how to use this system </p>
            </div>
        </div>
    </section>

    <section id="main-content">
        <div class="row mb-2">
            <div class="col-md-6 mx-auto">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">

                        <h3 class="mb-0 text-primary">instruction </h3>
                        
                        <p class="card-text mb-auto"> </p>
                        <ul>
                            <li>First - Log in &rightarrow; <span><a  href="./login.php" class="stretched-link">log-in</a></span> <br/>to access the option in this site you need to login first </li>
                            <li>Second - do what you intended to </li>
                            <li>enter to contacts &rightarrow; <a href="./contacts.php" >contacts</a> &leftarrow;</li>
                            <li>enter to contacts &rightarrow; <a href="./grades.php" >grades</a> &leftarrow;</li>

                        </ul>

                       
                        
                    </div>
                    
                </div>
            </div>
           
           
        </div>
    </section>
</main>

<?php include_once "tpl/footer.php" ?>