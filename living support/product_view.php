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

$sql = "SELECT * FROM product WHERE fileid='${fileid}'";
$result = mysql_query($sql,$con);
    While($row = mysql_fetch_array( $result, MYSQL_ASSOC )){
        $image[] = $row["image_name"];
        $title[] = $row["title"];
        $price[] = $row["price"];
        $category[] = $row["category"];
        $sentence[] = $row["sentence"];
    
    }

$sql = "SELECT * FROM product WHERE fileid='${fileid}'";
$result = mysql_query($sql,$con);
if(isset($result) == null){
    $message = "<p>naiyo</p>";
}
else{
    While($files = mysql_fetch_array( $result, MYSQL_NUM )){
        $img[] = array_filter($files, "strlen");
    }
}

?>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/jquery.accordion.js"></script>
        <script>
        $(function() {
        $('.accordion').accordion({
        controlElement  : 'li > span',
        contentElement  : 'li > ul',
        addClassElement : 'li'
            });
            var $allOpenBtn  = $('#all-open');
    var $allCloseBtn = $('#all-close');
 
 
    $allOpenBtn.on('click', function() {
        $accordion.accOpen();
    });
 
    $allCloseBtn.on('click', function() {
        $accordion.accClose();
    });
        });
        </script>
        <style type="text/css">
        
            .mypage_tab2_twobox{
                margin-left: 500px;
                margin-top: 130px;
            }
            .productbutton{
                margin-top: 10px;
            }
            .mypage_tab2_twobox{
                
            }
            .product_view_h3{
                text-align: left;
            }
        </style>
	</head>
<body class="introction_body">
   
    <header>
        <div class="product_view_header">
            <a href="content.php"><img src="images/logo.png" alt="logo" class="product_view_logo"></a>
            
            <div class="product_view_header_right">
                <a class="product_view_square_btn" href="content.php">Content List</a>
                <a class="product_view_square_btn" href="mypage.php">Mypage</a>
                <a href="product_all.php" class="product_view_square_btn">Product List</a>
            </div>
        </div>
        </header>
    <div class="main">
        <!--<h1><?php //echo $category; ?></h1>-->
        <div class="intro_leftbox">
            <ul class="accordion">
            <li><span class="menu">家具</span>
                <ul class="ul">
                    <li>ソファー</li>
                    <li>ベッド</li>
                    <li>テーブル</li>
                </ul>
            </li>
            <li><span class="menu">家電</span>
                <ul class="ul">
                    <li>テレビ</li>
                    <li>オーディオ</li>
                    <li>PC</li>
                </ul>
            </li>
            <li><span class="menu">料理</span>
                <ul class="ul">
                    <li>調理器具</li>
                    <li>食器</li>
                    <li>タオル</li>
                </ul>
            </li>
            <li><span class="menu">収納</span>
                <ul class="ul">
                    <li>用具入れ</li>
                </ul>
            </li>
            <li><span class="menu">掃除</span>
                <ul class="ul">
                    <li>ころころ</li>
                    <li>モップ</li>
                </ul>
            </li>
        </ul>
        </div>
             
        <div class="intro_rightbox">
            
            <div class="intro_rightbox_left">
                <?php 
                //print_r($img);
                if(isset($img[0][0]) == null){
                    echo "登録されていません";
                   
                }else{
                    
                    for($i=0; $i<count($img); $i++){
                    echo "<div class='aaa'>";
                    echo "<img src='product_image/".$img[$i][3]."' alt=".$img[$i][3]." style='width:80%;' class='bbb'/>";     
                    echo "</div>";
                    echo "<a href='product_detailed.php?imageid=".$img[$i][2]."'>商品詳細</a>";
                    }
                    
                }
                 
                ?> 
            </div>
            
            <div class="intro_textbox_right">
            <?php
            //print_r($title);
            if(isset($img[0][0]) == true){
                for($i=0; $i<count($img); $i++){
                echo "<div class='intro_textbox'>";
                echo "<div class='intro_text'>";
                    echo "<h2 class='product_view_h2'>";
                    echo $title[$i];
                    echo "</h2>";
                    echo "<p class='product_view_h3'>";
                    echo $sentence[$i];
                    echo "</p>";
                    
                    echo "<p class='intro_text2'>";
                    echo "価格:";
                    echo "￥ ";
                    echo $price[$i];
                    echo "</p>";
                echo "</div>";
            echo "</div>"; 
                }       
            }
            //DB切断
            mysql_close( $con );
            ?>
            </div>
        </div>
        <br class="clear">
    </div>
</body>
</html>
