<?php

session_start();
//↑$_SESSIONを使う際、
//必ず必要


if( !isset( $_SESSION["name"] ) ){
    header("Location: index.php");
    exit;
}
