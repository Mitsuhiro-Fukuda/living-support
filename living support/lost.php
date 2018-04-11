<?php
session_start();
$userid = $_SESSION["userid"];

//DB接続
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

$con = @mysql_connect(
            $dbhost,$dbuser,$dbpass);
//接続確認
if( !$con ){
    //エラー情報取得
    $error = mysql_error();
    exit;
}

//文字コードの設定
mysql_set_charset("utf-8",$con );

//DBの選択
mysql_select_db("kadai",$con );


$sql = "DELETE FROM account WHERE userid='${userid}'";
$result = mysql_query($sql,$con);

$sql = "DELETE FROM file WHERE userid='${userid}'";
$result = mysql_query($sql,$con);

$sql = "DELETE FROM product WHERE userid='${userid}'";
$result = mysql_query($sql,$con);

mysql_close( $con );
header("Location:top.php");