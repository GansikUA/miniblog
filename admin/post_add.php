<?php
include_once "../ini/config.php";
include_once "../ini/functions.php";
include "../style/header.php";

?>
<!-- Page Header -->
<header class="masthead" style="background-image: url('../style/img/add-post.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Admin Page</h1>
                    <span class="subheading">This is admin page</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <?php
            if (isset($_POST['title']) && isset($_POST['content'])) {


                $target_dir = "../uploads/post/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (isset($_POST["fileToUpload"])) {

                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

            }
                    if ($uploadOk == 0) {
                        echo "Ви не вибрали зображення. Стаття буде без обкладинки";
                    } else {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                            $post_image = basename( $_FILES["fileToUpload"]["name"]);

                        } else {

                            $post_image = '';
                        }
                    }


                $title = $_POST['title'];
                $content = $_POST['content'];
                $users_id = 1;
                $date_add = date('Y-m-d');

                $sql = $DBH->prepare("INSERT INTO posts (title,content,image,users_id,date_add) VALUE (?,?,?,?,?)");
                $sql->execute(array($title, $content,$post_image,$users_id, $date_add));

                if ($sql) {
                    ?>
                    <div class="alert alert-success">Успішно опубліковано</div>
                    <?php
                }

            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-10 mx-auto">
            <form action="?" method="post" enctype="multipart/form-data">
                <label for="title">Заголовок</label>
                <input class="form-control" type="text" name="title" id="title" required>
                <label for="fileToUpload">Зображення</label>
                <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                <label for="content">Зміст</label>
                <textarea class="form-control" id="content" name="content" required></textarea><br>
                <button type="submit" class="btn btn-dark">Додати</button>
            </form>

        </div>
    </div>
</div>
<?php
include "../style/footer.php";
?>

<script>
    $(document).ready(function () {
        $('#content').summernote(
            {
                placeholder: 'Введіть текст',
                tabsize: 1,
                height: 300
            }
        );
    });
</script>
