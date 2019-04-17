<?php
include_once "ini/config.php";
include_once "ini/functions.php";
include "style/header.php";
?>
<!-- Page Header -->
<header class="masthead" style="background-image: url('style/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Login</h1>
                    <span class="subheading">This is login page</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 mx-auto">
<?php

if (is_auth()) {

 ?>
     <div class="alert alert-info">Ви авторизовані</div>
<?php

}else {

        if (isset($_POST['login']) && isset($_POST['password']) ){

           if (auth_user($_POST['login'], $_POST['password'])) {

               ?>

               <div class="alert alert-success">
                   Ви успішно авторизовані<br>
                   <a href="index.php">На головну</a>
               </div>

               <?php

           }else {
               ?>
               <div class="alert alert-danger">Невірний пароль</div>
               <?php
           }


        }

    ?>
    <form action="?" method="post">
        <label for="login">Логін</label>
        <input type="text" class="form-control" name="login" id="login">
        <label for="pass">Пароль</label>
        <input type="password" class="form-control" name="password" id="pass"><br>
        <button type="submit" class="btn btn-dark">Вхід</button>
    </form>
            <?php
}
?>
        </div>
    </div>
</div>

<?php
include "style/footer.php";
?>
