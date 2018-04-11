<!doctype html>
<?php
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
			$message = "<p>DB登録でエラーが発生しました</p>";
		}
        else if( $_GET["err"] == 2 ){
			$message = "<p>既に存在するIDです</p>";
		}
        else if( $_GET["err"] == 3 ){
			$message = "<p>パスワードが一致しません</p>";
		}
    }

?>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
<body class="body">
    <header>
        <div class="top_header">
            
            <div class="top_header_right">
                <p><a href="login.html">ログイン</a></p>
                <p><a href="new.html">新規登録</a></p>
            </div>
        </div>
        <div class="new_main">
            <div class="">
                <p class="new_h2">新規登録</p>
                <div class="new_leftbox">
                    <p class="new_form">ユーザー名：</p>
                    <p class="new_form">メールアドレス：</p>
                    <p class="new_form">パスワード：</p>
                    <p class="new_form">パスワード確認：</p>
                </div>

                <div class="new_rightbox">
                <form method = "post" action="new.php" class="new_login">
                    <input type="text" name="name" value="" placeholder="terouchi" class="new_id"><br>
                    <input type="text" name="mail" value="" placeholder="Address" class="new_id"><br>
                    <input type="password" name="pw" placeholder="Password" class="new_id"><br>
                    <input type="password" name="pws" placeholder="Password" class="new_id"><br>
                    <div class="buttonmain">
                    <input type="submit" value="新規登録" class="new_square_btn1">
                    </div>
                </form>
                
                </div>
                <?php echo $message; ?>
                <div class="login_btn">
                <a href="login.php" class="login_square_btn">
	               <i class="fa fa-chevron-right"></i> Loginへ
                </a>
                <a href="content.php" class="login_square_btn">
	               <i class="fa fa-chevron-right"></i> ログインせずに進む
                </a>
                </div>
                <br class="clear">
            </div>
        </div>
    </header>
</body>
</html>
