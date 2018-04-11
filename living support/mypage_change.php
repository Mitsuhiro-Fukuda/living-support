<!doctype html>
<?php
//phpinfo();
session_start();

if( !isset( $_SESSION["userid"] ) ){
    header("Location: content.php");
    exit;
}
$userid = $_SESSION["userid"];

$message = "";
    if( isset($_GET["true"]) ){
		if( $_GET["true"] == 0 ){
			$message = "<p>正常に登録されました</p>";
		}
    }else if( isset($_GET["err"]) ){
        if( $_GET["err"] == 0 ){
			$message = "<p>不正なリクエストです</p>";
		}
        else if( $_GET["err"] == 1 ){
			$message = "<p>fileが指定されていません</p>";
		}
        else if( $_GET["err"] == 2 ){
			$message = "<p>既に存在するIDです</p>";
		}
        else if( $_GET["err"] == 3 ){
			$message = "<p>パスワードが一致しません</p>";
		}
    }

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

$sql = "SELECT * FROM account WHERE userid='${userid}'";

//SQL発行
    $result = mysql_query($sql,$con);
    $row = mysql_fetch_array( $result, MYSQL_ASSOC ); 
    if(!$row["userid"] == $_SESSION["userid"])
    {
        $message = "<p>naiyo</p>";
    }else{
        $showname = $row["name"];
    }

//account情報ぬき出し
//$sql = "SELECT * FROM account WHERE userid='${userid}'";
//$result = mysql_query($sql,$con);
//$account = mysql_fetch_array( $result, MYSQL_ASSOC ));


$sql = "SELECT file FROM file WHERE userid='${userid}'";
    $result = mysql_query($sql,$con);

    While($file = mysql_fetch_array($result, MYSQL_NUM )){
        $showfile[] = $file;
    }

//fileテーブルからfileidぬき出す
$sql = "SELECT fileid FROM file WHERE userid='${userid}'";
$result = mysql_query($sql,$con);

    if(!$row["userid"] == $_SESSION["userid"]){
        
    }else{
        While($fileid = mysql_fetch_array( $result, MYSQL_NUM )){
            $Fileid[] = $fileid;
        }
            
    }
    

?>

<html>
	<head>
		<meta charset="utf-8">
		<title></title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript">
            
        </script>
        <style type="text/css">

            .aaa{
                height: 100px;
                width: 100px;
            }
            
        </style>
        
	</head>
<body>
    <header>
        <div class="content_header">
            <a href="content.php"><img src="images/logo.png" alt="logo" class="top_logo"></a>
            <div class="top_header_right">
                <p><a href="mypage.php">
                    <?php
                    echo $showname;
                    ?>
                    さんのマイページ
                    </a></p>
            </div>
        </div>
        <div>
            <h2 class="mypage_h2">マイページ</h2>
        </div>
        
        <div class="mypage_ul">
        <ul class="tab">
            <li class="select">ユーザ情報</li>
        </ul>
        
        <ul class="content">
            <li class="mypage_tab1">
                <div class="mypage_twobox">
                    <div class="mypage_leftbox">
                        
                        <p>メールアドレス：</p>
                        <p>パスワード：</p>
                        <p>ユーザー名：</p>
                        <p>名前：</p>
                        <p>電話番号：</p>
                        <p>住所：</p>
                    </div>
                    <div class="mypage_rightbox">
                        <form method = "post" action="new.php" class="new_login">
                    <?php
                        //print_r($account);
                        
                        echo "<input type='text' name='name' value='' placeholder=".$row["mail"]." class='new_id'>"; 
                        echo "<input type='text' name='name' value='' placeholder=".$row["mail"]." class='new_id'>"; 
                        echo "<input type='text' name='name' value='' placeholder=".$row["mail"]." class='new_id'>"; 
                        if($row["fullname"] == true){
                        echo "<p>"; echo $row["fullname"]; echo "</p>";
                        }else{
                        echo "<p>"; echo "-"; echo "</p>";
                        }
                        if($row["number"] == true){
                        echo "<p>"; echo $row["number"]; echo "</p>";
                        }else{
                        echo "<p>"; echo "-"; echo "</p>";
                        }
                        if($row["address"] == true){
                        echo "<p>"; echo $row["address"]; echo "</p>";
                        }else{
                        echo "<p>"; echo "-"; echo "</p>";
                        }
                        
                        echo "<input type='submit' value='変更' name='sub1'>";
                        
                    ?>
                     </form>
                    </div>
                </div>
                <br class="clear">
            </li>
            
            
        </ul>
        </div>
    </header>
    
    
</body>
    
</html>
