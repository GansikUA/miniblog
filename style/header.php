<!DOCTYPE html>
<html lang="ua">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Blog</title>

    <!-- Bootstrap core CSS -->
    <link href="../style/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../style/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../style/css/clean-blog.min.css" rel="stylesheet">

    <!-- include summernote css -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">


</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="../index.php">My Blog</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://<?=$_SERVER['HTTP_HOST']?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://<?=$_SERVER['HTTP_HOST']?>/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                       <?php if (is_admin()){ ?>
                       <a class="nav-link" href="http://<?=$_SERVER['HTTP_HOST']?>/admin/post_add.php"><i class="fas fa-pen"></i> Додати запис</a>
                           <?php } ?>
                </li>
                <li class="nav-item">
                    <?php if (is_auth()){ ?>
                        <a class="nav-link" href="http://<?=$_SERVER['HTTP_HOST']?>/exit.php"><i class="fas fa-door-open"></i> Вихід</a>
                    <?php }else {?>
                       <a class="nav-link" href="http://<?=$_SERVER['HTTP_HOST']?>/login.php"><i class="fas fa-user"></i> Авторизація</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</nav>