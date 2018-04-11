<!doctype html>

<?php

$checkSuccess = true;

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

$mail = $_POST["mail"];
$pw = $_POST["pass"];

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
if(trim($mail) == false ){
    header("Location: login.html?err=1");
    exit;
}



//loginチェック
$sql = "SELECT * FROM account WHERE mail ='${mail}' AND pass ='${pw}' ";
$res = mysql_query( $sql );


$row = mysql_fetch_array( $res, MYSQL_ASSOC ); 
    if($row["mail"] !== $mail)
    {
        header("Location: login.html?err=2");
        exit;
    }
    else{
        $userid = $row["userid"];
    }
//SQL発行
//$sql = "SELECT * FROM account WHERE mail='${mail}'";


//実行チェック
if(!$result){
    //簡易エラー処理
    echo "[", mysql_errno(), "]";
    echo mysql_error();
}

if($checkSuccess){
    //セッション開始
    session_start();//必ず必要
    
    //セッション領域にデータ保持
    $_SESSION["userid"] = $userid;
}

mysql_close( $con );
header("Location:content.php");