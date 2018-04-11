<!DOCTYPE html>
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

//GETしてきたid名の画像の投稿者useridを取得
$sql = "SELECT userid FROM file WHERE fileid='${fileid}'";
$result = mysql_query($sql,$con);
$users = mysql_fetch_array( $result, MYSQL_NUM ); 

//取得したuseridの複数画像を配列に格納
$sql = "SELECT file FROM file WHERE userid='${users[0]}'";
$result = mysql_query($sql,$con);
While($files = mysql_fetch_array( $result, MYSQL_NUM )){
    $img[] = $files;
}

$sql = "SELECT fileid FROM file WHERE userid='${users[0]}'";
$result = mysql_query($sql,$con);
While($fileid = mysql_fetch_array( $result, MYSQL_NUM )){
    $Fid[] = $fileid;
}
//echo print_r($img);
//echo print_r($users);
//echo print_r($Fid);
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Swiper</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <!-- Link Swiper's CSS -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="css/swiper.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script>
$(function(){
  $("area").hover(on, off);
    function on(){
    $('img#map').attr(
        src: $('img#map').attr('src').replace(/^(.+?)(¥.(gif|jpg|jpeg|xbm|png))$/,"$1_f2$2")
    });
  }
    function off(){
    $('img#map').attr(
      src: $('img#map').attr('src').replace(/^(.+?)(?:-on)?(¥.(gif|jpg|jpeg|xbm|png))$/,"$1$2")
    });
  }
});    
    </script>
    
  <!-- Demo styles -->
  <style>
    html, body {
      position: relative;
      height: 100%;
    }
    body {
      background: #000;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color:#000;
      margin: 0;
      padding: 0;
    }
    .swiper-container {
      width: 100%;
      height: 300px;
      margin-left: auto;
      margin-right: auto;
    }
    .swiper-slide {
      background-size: cover;
      background-position: center;
    }
    .gallery-top {
      height: 80%;
      width: 100%;
    }
    .gallery-thumbs {
      height: 20%;
      box-sizing: border-box;
      padding: 10px 0;
    }
    .gallery-thumbs .swiper-slide {
      width: 25%;
      height: 100%;
      opacity: 0.4;
    }
    .gallery-thumbs .swiper-slide-active {
      opacity: 1;
    }
      .BTN{
          position: relative; 
          top: -50px; 
          z-index: 2;
      }
      
  </style>
</head>
<body class="content_body">
    
    <header>
        <div class="view_header">
            <a href="content.php"><img src="images/logo.png" alt="logo" class="view_logo"></a>
            
            <div class="view_header_right">
                <a class="slide_square_btn" href="content.php">Content List</a>
                <a class="slide_square_btn" href="mypage.php">Mypage</a>
                <a href="product_all.php" class="slide_square_btn">Product List</a>
            </div>
        </div>
    </header>
    
  <!-- Swiper -->
  <div class="swiper-container gallery-top">
    <div class="swiper-wrapper">
    <?php
    
    for($i=0; $i<count($img); $i++){
    echo "<img src='files/".$img[$i][0]."' class='swiper-slide' usemap='#map".$i."' style='width:100%; height:100%;'/>";  
    //echo "<div class='swiper-slide' style='background-image:url(files/".$img[$i][0]."); height:100%;' usemap='#map'>";
    //echo "</div>";
    echo "<div >";
    //echo "<a href='product_view.php?fileid=".$Fid[$i][0]."' class='slides_square_btn'>";
    //echo "click";
    //echo "</a>";
    echo "</div>";
    echo "<map name='map".$i."' id='slides_square_btn'>";
    echo "<area shape='rect' coords='0,0,2000,2000' href='product_view.php?fileid=".$Fid[$i][0]."' alt='自己紹介ページ'
    style='color:red;';
    >";
    echo "</map>";
    
    }
    ?>
    
      <!--
      <img src="images/top.jpg" class="swiper-slide" usemap="#map" />
      <map name="map" id="aa">
           <area shape="rect"
          coords="40,100,184,187"
          href="#" alt="自己紹介ページ">
      </map>
      <img src="images/content1.jpg" class="swiper-slide" usemap="#map2" />
        <map name="map2" id="aa">
           <area shape="rect"
          coords="45,120,450,280"
          href="Introduction.html" alt="自己紹介ページ">
        </map>-->
        
    </div>
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
  </div>
  

  <div class="swiper-container gallery-thumbs">
    <div class="swiper-wrapper">
    <?php
    
    for($i=0; $i<count($img); $i++){
        
    echo "<div class='swiper-slide' style='background-image:url(files/".$img[$i][0]."); '>";
    echo "</div>";
    //echo "<img src=files/".$img[$i][0]." alt=".$img[$i][0]." style='width:200%;' >";
    }
    ?>
    </div>
  </div>

  <!-- Swiper JS -->
  <script src="js/swiper.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
    var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 10,
      centeredSlides: true,
      slidesPerView: 'auto',
      touchRatio: 0.2,
      slideToClickedSlide: true,
    });
    galleryTop.controller.control = galleryThumbs;
    galleryThumbs.controller.control = galleryTop;
  </script>
    
</body>
</html>