<?php

function check($str)
{
    $str = trim(htmlspecialchars($str));
    $str = str_replace("\'", "&#39;", $str);
    $str = str_replace("\r\n", "<br />", $str);
    $str = strtr($str, array(chr("0") => "", chr("1") => "", chr("2") => "", chr("3") => "", chr("4") => "", chr("5") => "", chr("6") => "", chr("7") => "", chr("8") => "", chr("9") => "", chr("10") => "", chr("11") => "", chr("12") => "", chr("13") => "", chr("14") => "", chr("15") => "", chr("16") => "", chr("17") => "", chr("18") => "", chr("19") => "", chr("20") => "", chr("21") => "", chr("22") => "", chr("23") => "", chr("24") => "", chr("25") => "", chr("26") => "", chr("27") => "", chr("28") => "", chr("29") => "", chr("30") => "", chr("31") => ""));
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    $str = str_replace('\\', "&#92;", $str);
    $str = str_replace("|", "I", $str);
    $str = str_replace("||", "I", $str);
    $str = str_replace("/\\\$/", "&#36;", $str);
    $str = str_replace("$", "&#36;", $str);
    $str = str_replace("@", "&#64;", $str);
    $str = str_replace("`", "", $str);
    $str = str_replace("^", "", $str);
    $str = str_replace("%", "&#37;", $str);
    $str = str_replace("[l]http://", "[l]", $str);
    $str = str_replace("[l] http://", "[l]", $str);
    return $str;
}

function auth_user ($login,$password){

    global $DBH;
    $login = check($login);
    $password = md5(strrev(md5($password)));

    $sql = $DBH->prepare("SELECT * FROM `users` WHERE login = ? AND password = ?");
    $sql->execute(array($login,$password));
    $res = $sql->fetch();

    $col = $sql->rowCount();

    if ($col){

        setcookie('login', $res['login']);
        setcookie('password', $res['password']);
        $_SESSION['user_id'] = $res['id'];

        return true;

    }else {

        return false;
    }

}

function is_auth()
{

    global $DBH;

    if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {

        $login = $_COOKIE['login'];
        $password = $_COOKIE['password'];


        $sql = $DBH->prepare("SELECT * FROM `users` WHERE login = ? AND password = ?");
        $sql->execute(array($login, $password));
        $res = $sql->fetch();
        if ($sql) {

            $_SESSION['user_id'] = $res['id'];

            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function is_admin(){
    global $DBH;

    if(is_auth()) {
        $user_id = $_SESSION['user_id'];

        $sql = $DBH->prepare("SELECT level FROM users WHERE id = ?");
        $sql->execute(array($user_id));

        $res = $sql->fetch();

        if ($res['level'] > 0) {
            return true;
        }else {
            return false;
        }
    } else {
        return false;
    }
}

function crop_string($str, $size){
    return mb_substr($str,0,mb_strrpos(mb_substr($str,0,$size,'utf-8'),' ','utf-8'),'utf-8');
}

function exit_auth(){

    if (is_auth()){
        setcookie('login', '', -100);
        setcookie('password', '', -100);
        unset($_SESSION['user_id']);
        session_destroy();

        return true;

    }else {

        return false;
    }
}

function get_post ($post_id){

    global $DBH;

    $sql = $DBH->prepare("SELECT  posts.id, 
                                                posts.title, 
                                                posts.content, 
                                                posts.date_add, 
                                                users.name AS author 
                                        FROM posts INNER JOIN users ON posts.users_id = users.id
                                        WHERE posts.id = ? ");

    $sql->execute(array($post_id));
    $post = $sql->fetch();

    return $post;
}


function get_post_prev(){

    global $DBH;

    $sql = $DBH->query("SELECT  posts.id, 
                                                posts.title, 
                                                posts.content, 
                                                posts.date_add, 
                                                users.name 
                                        FROM posts INNER JOIN users ON posts.users_id = users.id ORDER BY posts.id DESC ");

    return $sql;
}

function get_comments($post_id, $list = true){

    global $DBH;
    $post_id = abs(intval($post_id));

    $sql = $DBH->query("SELECT *, comments.id AS cid FROM comments INNER JOIN users ON comments.user_id = users.id WHERE post_id = $post_id");
    if ($list){
        $res = $sql->fetchAll();

    }else {
        $res = $sql->fetch();
    }


    return $res;
}

function get_comment_info ($comment_id,$field){

    global  $DBH;

    $comment_id = intval($comment_id);
    $select_field = $field;

    $sql = $DBH->prepare("SELECT $select_field FROM comments WHERE id = ?");
    $sql->execute(array($comment_id));
    $res = $sql->fetch();

    return $res[$select_field];
}

function add_comment ($comment,$post_id){

    global $DBH;

    $text = check($comment);
    $post_id = abs(intval($post_id));
    $date_comment = date('Y-m-d');

    $sql = $DBH->prepare("INSERT INTO comments (user_id, text, post_id, date_comment) VALUES (?,?,?,?)");
    $sql->execute(array($_SESSION['user_id'],$text,$post_id, $date_comment));
}

function del_comment($comment_id){

    global $DBH;

    $comment_uid = get_comment_info($comment_id, 'user_id');

    if (is_admin()){

        $sql = $DBH->prepare ("DELETE FROM comments WHERE id = ?");
        $sql->execute(array($comment_id));

    }elseif(is_auth() && $_SESSION['user_id'] == $comment_uid){

        $sql = $DBH->prepare ("DELETE FROM comments WHERE id = ? AND  user_id = ?");
        $sql->execute(array($comment_id, $_SESSION['user_id']));

    }
}

function get_post_bg ($post_id){

    global $DBH;
    $post_id = intval($post_id);

    $sql = $DBH->query("SELECT image FROM posts WHERE id = $post_id");
    $sql->execute();
    $post = $sql->fetch();

    if ($post['image']) {

        $image_url = '../uploads/post/'.$post["image"];

    } else {

        $image_url = '../style/img/home-bg.jpg';

    }

    $post_bg = ' style="background-image: url('.$image_url.')"';

    echo $post_bg;
}