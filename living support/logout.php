<?php
//セッション開始
session_start();

//セッション(簡易)破棄
session_destroy();

//リダイレクト
header("Location: top.php");
