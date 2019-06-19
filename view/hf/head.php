<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Online | Memo</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <link rel="stylesheet" href="css/swipebox.min.css" type="text/css">

    <!-- Custom Fonts -->


    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="css/owl.theme.css" type="text/css">
    <link rel="stylesheet" href="css/owl.transitions.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/animate.css" type="text/css">

  
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header ">
            <a class="navbar-brand" href="#">Online Memo</a>
        </div>
        <div class="navbar-header ">
            <a class="navbar-brand" href="#"><?="用户名:".$_SESSION['user']['UNAME']?></a>
        </div>
        <div class="navbar-header navbar-right " >
            <form action="/index.php?r=Visitor/home_page" method="POST" class="navbar-form navbar-left">
                <button type="submit" class="btn btn-info">返回日历</button>
            </form>
        </div>
        <div class="navbar-header navbar-right" >
            <form action="/index.php?r=login/login_page" method="POST" class="navbar-form navbar-left">
                <button type="submit" class="btn btn-info">切换用户</button>
            </form>
        </div>
    </nav>
