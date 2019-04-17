<?php
include_once "ini/config.php";
include_once "ini/functions.php";
include "style/header.php";

if (isset($_GET['post_id'])) $post = get_post($_GET['post_id']);
if (isset($_POST['comment'])) add_comment($_POST['comment'], $_GET['post_id']);
if (isset($_GET['delete'])) del_comment($_GET['delete']);
?>

  <!-- Page Header -->
  <header class="masthead" <?php get_post_bg($_GET['post_id']);?> >
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading">
            <h1><?=$post['title']?></h1>
            <h2 class="subheading">Problems look mighty small from 150 miles up</h2>
            <span class="meta">Posted by
              <a href="#"><?=$post['author']?></a>
              on <?=$post['date_add']?></span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Post Content -->
  <article>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?=$post['content']?>
        </div>
      </div>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <hr>
                <?php
                   $comments = get_comments($_GET['post_id']);
                    foreach ($comments AS $k => $comment){
                        ?>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="https://image.ibb.co/jw55Ex/def_face.jpg" alt ="avatar" class="img img-rounded img-fluid"/>
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <span class="float-left" ><strong><?=$comment['name']?></strong></span>
                                    <span class="float-right"><?=$comment['date_comment']?></span>
                                </p>
                                <div class="clearfix"></div>
                                <p><?=$comment['text']?></p>
                                <p>
                                    <?php if (is_admin() || is_auth() && $_SESSION['user_id'] == $comment['user_id']){ ?>
                                    <a href="post.php?post_id=<?=$_GET['post_id']?>&amp;delete=<?=$comment['cid']?>" class="float-right btn text-white btn-danger" > <i class="fa fa-trash"></i> Видалити</a>
<!--                                    <a href="#" class="float-right btn text-white btn-success"> <i class="fa fa-pen"></i> Редагувати</a>-->
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> <br>
                <?php    }       ?>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <br>
            <?php if (is_auth()){ ?>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#commentModal"><i class="fas fa-comment"></i> Коментувати</a>
            <?php }else { ?>
                <p>Щоб залишити коментар <a href="login.php">Авторизуйтеся</a></p>
            <?php } ?>
        </div>
      </div>
    </div>
  </article>

    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Коментувати допис</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="post.php?post_id=<?=$_GET['post_id']?>" method="post">
                        <label for="comment">Ваш коментар</label>
                        <textarea name="comment" class="form-control" id="comment" cols="30" rows="10" required></textarea>
                        <br><button type="submit" class="btn btn-primary">Відправити</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

  <hr>

<?php
include "style/footer.php";
?>