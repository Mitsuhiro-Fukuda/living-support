<!doctype html>
<?php
session_start();

if( !isset( $_SESSION["userid"] ) ){
    header("Location: content.php");
    exit;
}
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


$sql = "SELECT fileid,image_name,imageid FROM product";
$result = mysql_query($sql,$con);

      While($pr = mysql_fetch_array($result, MYSQL_NUM)){
      $pro[] = $pr;
      }
 //print_r($pro);
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
            
            <?php   
            for($i=0; $i<count($pro); $i++){
                echo "<a href='product_detailed.php?imageid=".$pro[$i][2]."'>";
                echo "<div class='content_c'>";
                echo "<img src='product_image/".$pro[$i][1]."'  alt=".$pro[$i][1]." class='content_slide-left'>"; 
                echo "</div>";
             }
         echo "</div>";
                    echo "</a>";
                    //DB切断
                    mysql_close( $con );
                    
            ?> 
            </div>
        </div>
        <br class="clear">
    
</body>
</html>
