<?php
include_once "ini/config.php";
include_once "ini/functions.php";
include "style/header.php";

$sql = get_post_prev();
?>

<!-- Page Header -->
  <header class="masthead" style="background-image: url('style/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Clean Blog</h1>
            <span class="subheading">A Blog Theme by Start Bootstrap</span>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
          <?php

          while ($post = $sql->fetch()){
          ?>
          <!-- POST -->
          <div class="post-preview">
          <a href="post.php?post_id=<?=$post['id']?>">
            <h2 class="post-title"><?=$post['title']?></h2>
            <h3 class="post-subtitle"><?=crop_string(strip_tags($post['content']), 150)?></h3>
          </a>
          <p class="post-meta">Posted by <a href="#"><?=$post['name']?></a> on <?=$post['date_add']?></p>
        </div>
        <hr>
        <?php } ?>
        <!-- Pager -->
        <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
        </div>
      </div>
    </div>
  </div>

  <hr>
<?php
include "style/footer.php";
?>