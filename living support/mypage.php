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
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--<script type="text/javascript">
            $(function() {
            //クリックしたときのファンクションをまとめて指定
            $('.tab li').click(function() {

                //.index()を使いクリックされたタブが何番目かを調べ、
                //indexという変数に代入します。
                var index = $('.tab li').index(this);

                //コンテンツを一度すべて非表示にし、
                $('.content li').css('display','none');

                //クリックされたタブと同じ順番のコンテンツを表示します。
                $('.content li').eq(index).css('display','block');

                //一度タブについているクラスselectを消し、
                $('.tab li').removeClass('select');

                //クリックされたタブのみにクラスselectをつけます。
                $(this).addClass('select');
               });
            });
        </script>-->
        <style type="text/css">

            .mypage_aaa{
                height: 100px;
                width: 100px;
                padding-right: 120px;
            }
            
        </style>
        
	</head>
<body>
    <header>
        <div class="mypage_header">
            <a href="content.php"><img src="images/logo.png" alt="logo" class="mypage_logo"></a>
            
            <div class="mypage_header_right">
                <a class="mypage_square_btn" href="content.php">Content List</a>
                <a class="mypage_square_btn" href="mypage.php">Mypage</a>
                <a href="product_all.php" class="mypage_square_btn">Product List</a>
            </div>
        </div>
        </header>
        <div>
            <h1 class="mypage_h2">Mypage</h1>
        </div>
        <div class="mypage_main">
            
            <div class="mypage_left">
                <h2 class="h2">個人情報</h2>
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
                    <?php
                        //print_r($account);
                        echo "<p>"; echo $row["mail"]; echo "</p>";
                        echo "<p>"; echo "**********"; echo "</p>";
                        echo "<p>"; echo $row["name"]; echo "</p>";
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
                        echo "<form method='POST' action='mypage_change.php'>";
                        echo "<input type='submit' value='変更' name='sub1'>";
                        echo "</form>";
                    ?>
                    </div>
                </div>
                <br class="clear">
                <a href="logout.php">logout</a>
                <a href="lost.php">退会</a>
            </div>
            
            <div class="mypage_right">
                <h2 class="h2_2">部屋画像投稿</h2>
                <div class="mypage_tab2_twobox">
                <div class="mypage_tab2_toukou">
                    <div class="mypage_tab2_leftbox_columns" style="border-right:solid 1px;">イメージ画像選択</div>
                    
                    <div>
                     <form method = "post" action="upload-output.php" enctype="multipart/form-data" class="mypage_upbutton">
                        <div class="">
                            <input type="file" name="upfile" class="">
                        </div>
                        
                        <input type="submit" value="アップロード" class="mypage_button" style="margin-left:33px;">
                    </form>
                    </div>
                    
                </div>
                
                    <div class="mypage_flex">
                        
                    <?php 
                    //print_r($showfile);
                    //print_r($Fileid);
                    echo $message;
                    
                    if(isset($showfile) == true){
                        for($i=0; $i<count($showfile); $i++){
                        echo "<div class='mypage_aaa'>";
                        echo "<img src=files/".$showfile[$i][0]." alt=".$showfile[$i][0]." style='width:200%; height:150%;' >";

                        echo "<form method='POST' action='product_insert.php?fileid=".$Fileid[$i][0]."'>";
                        echo "<input type='submit' value='編集する' name='sub1'>";
                        echo "</form>";
                        echo "</div>";
                        }
                    }
                    
                    //DB切断
                    mysql_close( $con );
                    ?> 
                    </div>
                </div>
                </div>
            
            <div class="" style="background-color:">
                <h2>かご</h2>
                
            </div>
            
    </div><!--main-->
</body>
    
</html>
