<!doctype html>
<?php
session_start();

if( !isset( $_SESSION["userid"] ) ){
    header("Location: content.php");
    exit;
}
$userid = $_SESSION["userid"];
$imageid = $_GET['imageid'];


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
mysql_set_charset("utf-8",$con );
mysql_select_db("kadai",$con );


$sql = "SELECT * FROM account WHERE userid='${userid}'";
    $result = mysql_query($sql,$con);
    $row = mysql_fetch_array( $result, MYSQL_ASSOC ); 
    if(!$row["userid"] == $_SESSION["userid"])
    {
        $message = "<p>naiyo</p>";
    }else{
        $showname = $row["name"];
    }

$sql = "SELECT * FROM product WHERE imageid='${imageid}'";
$result = mysql_query($sql,$con);
    While($row = mysql_fetch_array( $result, MYSQL_ASSOC )){
        $image[] = $row["image_name"];
        $title[] = $row["title"];
        $price[] = $row["price"];
        $category[] = $row["category"];
        $sentence[] = $row["sentence"];
    
    }

$sql = "SELECT * FROM product WHERE imageid='${imageid}'";
$result = mysql_query($sql,$con);
if(isset($result) == null){
    $message = "<p>error</p>";
}
else{
    While($files = mysql_fetch_array( $result, MYSQL_NUM )){
        $img[] = array_filter($files, "strlen");
    }
}

//filepathぬき出し
$fileid = $img[0][1];
$sql = "SELECT * FROM file WHERE fileid='${fileid}'";
$result = mysql_query($sql,$con);
    $row = mysql_fetch_array( $result, MYSQL_ASSOC ); 
    if(!$row["fileid"] == $img[0][1])
    {
        $message = "<p>naiyo</p>";
    }else{
        $filename = $row["file"];
    }

//print_r($img);
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
            <?php 
                
                if(isset($img[0][0]) == null){
                    echo "sssss";
                   
                }else{
                    
                    for($i=0; $i<count($img); $i++){
                    echo "<div class='aaa'>";
                    echo "<img src='product_image/".$img[$i][3]."' alt=".$img[$i][3]." style='width:80%;' class='bbb'/>";     
                    echo "</div>";
                    echo "<a href='slide.php?fileid=".$img[$i][2]."'>戻る</a>";
                    }
                    
                }
                 
                ?> 
        </div>
             
        <div class="intro_rightbox">
            <?php 
                    
                    for($i=0; $i<count($img); $i++){
                    echo "<div class='aaa'>";
                    echo "<img src='files/".$filename."' alt=".$filename." style='width:80%;' class='bbb'/>";     
                    echo "</div>";
                    
                    }
                 
            ?>
            
            <!--<div class="intro_rightbox_left">
                
            </div>
            
            <div class="intro_textbox_detailed">
            
            </div>-->
            
        </div>
        
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
        echo "<a href='basket_back.php?product_id=".$img[0][2]."'>買い物かごへ</a>";
        
            //DB切断
            mysql_close( $con );
            ?>
        
        <br class="clear">
    </div>
</body>
</html>
