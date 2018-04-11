<!doctype html>
<?php
session_start();

if( !isset( $_SESSION["userid"] ) ){
    header("Location: content.php");
    exit;
}
$userid = $_SESSION["userid"];
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



//SQL発行
//fileパス名取り出し
$sql = "SELECT file FROM file";
    $result = mysql_query($sql,$con);
    $file[] = mysql_fetch_array( $result, MYSQL_NUM );


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

$sql = "SELECT file,max(fileid) FROM file GROUP BY userid";
$result = mysql_query($sql,$con);

      While($fileall = mysql_fetch_array($result, MYSQL_NUM)){
      $fall[] = $fileall;
      }  


?>

<html>
	<head>
		<meta charset="utf-8">
		<title></title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
<body>
    <header>
        <div class="content_header">
            <a href="content.html"><img src="images/logo.png" alt="logo" class="top_logo"></a>
            <div class="content_header_right">
                <a class="content_square_btn" href="content.php">Content List</a>
                <a class="content_square_btn" href="mypage.php">Mypage</a>
                <a href="product_all.php" class="content_square_btn">Product List</a>
            </div>
        </div>
        <h1 class="content_h1">Content List</h1>
        <div class="block">
            <!--<a href="content2.html"><div class="slide-top" data-plugin-options='{"speed":800}'></div></a>!-->
            <a href="content2.html"><div class="content_top"></div></a>
        </div>
        <div class="content_block">
        <div class="block2">
            <?php   
            //print_r($fall);
            
            for($i=0; $i<count($fall); $i++){
                echo "<a href='slide.php?fileid=".$fall[$i][1]."'>";
                echo "<div class='aaa'>";
                echo "<img src='files/".$fall[$i][0]."'  alt=".$fall[$i][0]." class='content_slide-left'/>"; 
                echo "</div>";
             }
         echo "</div>";
                        //echo "<div class='aaa'>";
                        //echo "<img src=files/".$file[0][0]." alt=".$file[0][0]." class='slide-left'>";
                        //echo "</div>";
             
                    echo "</a>";
                    //DB切断
                    mysql_close( $con );
                    
            ?> 
            
            </div>
        </div>
    </header>
    
    <footer>
    
    
    </footer>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/jquery.fadethis.min.js"></script>
    <script>
        $(window).fadeThis();
    </script>
</body>
    
</html>
