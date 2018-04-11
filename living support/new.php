<!doctype html>
<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

$name = $_POST["name"];
$mail = $_POST["mail"];
$pw = $_POST["pw"];
$pws = $_POST["pws"];

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
if(trim($name) == false ){
    header("Location: new_form.php?err=1");
    exit;
}

//パスワード確認チェック
if($pw !== $pws){
    header("Location:new_form.php?err=3");
    exit;
}

//SQL発行(実行)
$sql = "INSERT INTO account(name,mail,pass) VALUES('$name','$mail','$pw')";
$result = mysql_query($sql,$con);


//実行チェック
if(!$result){
    //簡易エラー処理
    echo "[", mysql_errno(), "]";
    echo mysql_error();

}

mysql_close( $con );
header("Location:new_form.php?true=0");

