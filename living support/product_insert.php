<!doctype html>
<?php
session_start();

if( !isset( $_SESSION["userid"] ) ){
    header("Location: content.php");
    exit;
}
$userid = $_SESSION["userid"];
$fileid = $_GET['fileid'];

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

$sql = "SELECT * FROM file WHERE fileid='${fileid}'";
$result = mysql_query($sql,$con);
    $row = mysql_fetch_array( $result, MYSQL_ASSOC ); 
    if(!$row["fileid"] == $fileid)
    {
        $message = "<p>naiyo</p>";
    }else{
        $filename = $row["file"];
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
                height: 300px;
                width: 300px;
 
            }
            .mypage_tab2_twobox{
                margin-left: 500px;
                margin-top: 130px;
            }
            .productbutton{
                margin-top: 10px;
            }
            .mypage_tab2_twobox{
                
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
        <div>
            <h2 class="mypage_h2">編集ページ</h2>
        </div>
        <div class="insert_main">
        <div class="insert_img">
        
                    <?php   
                    echo "<div class='aaa'>";
                    if($filename == true){
                    echo "<img src=files/".$filename." alt=".$filename." style='width:200%;' >";
                    }
                    echo "</div>";
                    //DB切断
                    mysql_close( $con );
                    ?> 
        </div>
        <div class="insert_twobox">
                    <div class="insert_leftbox">
                        <div class="mypage_tab2_leftbox_column2">カテゴリ</div>
                        <div class="mypage_tab2_leftbox_column2">タイトル</div>
                        <div class="mypage_tab2_leftbox_column2">イメージ画像</div>
                        <div class="mypage_tab2_leftbox_column2">値段</div>
                        <div class="mypage_tab2_leftbox_column2">商品紹介</div>
                    </div>

                    <div class="insert_rightbox">
                        <form method = "post" action="product_insert_db.php?<?php echo 'fileid='.$fileid ?>" enctype="multipart/form-data" class="">
                            <div class="mypage_tab2_rightbox_column2"><select name="category" value="" class="">

                            <option value="kagu">家具</option>
                            <option value="kaden">家電</option>
                            <option value="ryouri">料理</option>
                            <option value="syuno">収納</option>
                            <option value="souji">掃除</option>
                            </select>

                            </div>

                            <div class="mypage_tab2_rightbox_column2"><input type="text" name="title" value="" placeholder="タイトル名" class="" style="padding-right:70px; height:30px;"></div>
                            <div class="mypage_tab2_rightbox_column2"><input type="file" name="upfile" class=""></div>
                            
                            <div class="mypage_tab2_rightbox_column2"><input type="text" name="money" value="" placeholder="100000" class="" style="padding-right:70px;"></div>
                            <div class="mypage_tab2_rightbox_column2"><textarea name="sentence" value="" placeholder="紹介文を入力してください"  cols=40 rows=4 class="" style="margin-left:17px; width:300px;"></textarea></div>

                            <input type="submit" value="編集確認" class="productbutton" >
                        </form>
                    </div>
                </div>   
        </div>
                
    </header>
    
    
</body>
    
</html>
