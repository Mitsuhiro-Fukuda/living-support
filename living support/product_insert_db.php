<!doctype html>
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if( !isset( $_SESSION["userid"] ) ){
    exit;
}

$fileid = $_GET['fileid'];
$userid = $_SESSION["userid"];
$upfile = $_FILES["upfile"]["name"];
$title = $_POST["title"];
$money = $_POST["money"];
$category = $_POST["category"];
$sentence = nl2br($_POST['sentence']);


$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

$con = @mysql_connect(
            $dbhost,$dbuser,$dbpass);

if( !$con ){
    $error = mysql_error();
    exit;
}

//文字コードの設定
mysql_set_charset("utf-8",$con );

//DBの選択
mysql_select_db("kadai",$con );

//空文字チェック
if(trim($upfile) == false){
    header("Location: mypage.php?err=1");
    exit;
}


//productテーブルにuseridとfileを保存
    //$sql = "INSERT INTO product(userid,fileid) VALUES('$userid','$fileid')";
    //$result = mysql_query($sql,$con);

//productテーブルにもろもろ保存

//$sql = "UPDATE product SET image_name='${upfile}',title='${title}',category='${category}',sentence='${sentence}' WHERE fileid='${fileid}'";
$sql = "INSERT INTO product(image_name,title,category,sentence,price) VALUES('$upfile','$title','$category','$sentence','$money')";
$result = mysql_query($sql,$con);
$sql = "UPDATE product SET userid='${userid}',fileid='${fileid}' WHERE image_name='${upfile}'";
$result = mysql_query($sql,$con);


//画像の保存先のパスを指定
$filedir = "C:\xampp\htdocs\wp32\presen\product_image";

//$filesdirで指定したファイルに画像を保存する。
if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
  if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "product_image/" . $_FILES["upfile"]["name"])) {
    chmod("product_image/" . $_FILES["upfile"]["name"], 0644);
    echo $_FILES["upfile"]["name"] . "をアップロードしました。";
  } else {
    echo "ファイルをアップロードできません。";
  }
} else {
  echo "ファイルが選択されていません。";
}


//実行チェック
if(!$result){
    //簡易エラー処理
    echo "[", mysql_errno(), "]";
    echo mysql_error();

}

mysql_close( $con );
header("Location:mypage.php?true=0");

