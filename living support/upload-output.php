<!doctype html>
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if( !isset( $_SESSION["userid"] ) ){
    exit;
}
$userid = $_SESSION["userid"];
$upfile = $_FILES["upfile"]["name"];

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

//SQL発行(実行)
$sql = "SELECT * FROM account WHERE userid='${userid}'";
    $result = mysql_query($sql,$con);
    $row = mysql_fetch_array( $result, MYSQL_ASSOC ); 
    if($row["userid"] == $_SESSION["userid"])
    {
        $file = $row["file"];
    }
//一つも入っていなかったら
if(isset($file) == true){
    //accountテーブルにfile名を追加
    $sql = "UPDATE account SET file='${upfile}' WHERE userid='${userid}'";
    $result = mysql_query($sql,$con);
    
    //fileテーブルにuseridとfileを保存
    $sql = "INSERT INTO file(userid,file) VALUES('$userid','$upfile')";
    $result = mysql_query($sql,$con);
}else{
    //fileテーブルにuseridとfileを保存
    $sql = "INSERT INTO file(userid,file) VALUES('$userid','$upfile')";
    $result = mysql_query($sql,$con);
}





//画像の保存先のパスを指定
$filedir = "C:\xampp\htdocs\wp32\presen\upfile";

//$filesdirで指定したファイルに画像を保存する。

if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
  if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/" . $_FILES["upfile"]["name"])) {
    chmod("files/" . $_FILES["upfile"]["name"], 0644);
    echo $_FILES["upfile"]["name"] . "をアップロードしました。";
  } else {
    echo "ファイルをアップロードできません。";
  }
} else {
  echo "ファイルが選択されていません。";
}

//fileテーブルからfileidぬき出す
$sql = "SELECT * FROM file WHERE userid='${userid}'";
    $result = mysql_query($sql,$con);
    $row = mysql_fetch_array( $result, MYSQL_ASSOC ); 
    if(!$row["userid"] == $_SESSION["userid"])
    {
        $message = "<p>naiyo</p>";
    }else{
        $fileid = $row["fileid"];
    }

//productテーブルにuserid,fileidを保存
$sql = "INSERT INTO product(userid,fileid) VALUES('$userid','$fileid')";
$result = mysql_query($sql,$con);



//実行チェック
if(!$result){
    //簡易エラー処理
    echo "[", mysql_errno(), "]";
    echo mysql_error();

}

mysql_close( $con );
header("Location:mypage.php?true=0");

