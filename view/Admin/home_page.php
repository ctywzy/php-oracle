<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Online | Memo</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/js/jquery.js">
    <link rel="stylesheet" type="text/css" href="/js/bootstrap.min.js">
</head>
<body background ="#31C5BE">
	<nav class="navbar navbar-default" role="navigation">
       <div class="navbar-header">
          <a class="navbar-brand" href="#">Online Memo</a>
       </div>
       <div class="navbar-header ">
        <a class="navbar-brand" href="#">Admin用户</a>

       </div>


        <div class="navbar-header navbar-right">
            <form class="navbar-form navbar-right" role="search" action="/index.php?r=Admin/user_search" method="POST">
                <input type="text" class="form-control" placeholder="keyword"  name="keyword">


                <button type="submit" class="btn btn-info">查找用户</button>
            </form>
        </div>

        <div class="navbar-header navbar-right">
            <form action="/index.php?r=Admin/home_page" method="POST" class="navbar-form navbar-left">
                <button type="submit" class="btn btn-info">用户信息</button>
            </form>
        </div>


        <div class="navbar-header navbar-right">
            <form action="/index.php?r=login/login_page" method="POST" class="navbar-form navbar-left">
                <button type="submit" class="btn btn-info">退出登录</button>
            </form>
        </div>
        <div class="navbar-header navbar-right">
            <form action="/index.php?r=Admin/today_logs" method="POST" class="navbar-form navbar-left">
                <button type="submit" class="btn btn-info">Today-Memos</button>
            </form>
        </div>

    </nav>
    <?php
      //echo $getdate;
    ?>
    

    <table class="table table-bordered">

        <tr bgcolor="#31C5BE">
           <th style="text-align: center;width: 400px" class="col-sm-3">注册时间</th>
           <th style="text-align: center;width: 400px" class="col-sm-3">用户权限</th>
           <th style="text-align: center;width: 400px" class="col-sm-3">邮箱</th>
           <th style="text-align: center;width: 400px" class="col-sm-3">密码</th>
        </tr>
        <?php foreach ($users as $user) : ?>
          <tr class="warning">
            <td style="text-align: center;font-size: 25px;width: 400px" ><?= $user['CREATE_AT']  ?></td>
            <td style="text-align: center;font-size: 25px;width: 400px"><?= $user['USERS_ROLE'] ?>
            <td style="text-align: center;font-size: 25px;width: 400px"><?= $user['UEMAIL'] ?></td>
            <form action="/index.php?r=Visitor/do_delete" method="POST">
              <input type="hidden" name="getdate" value=<?= $user['CREATE_AT']?>>
                <input type="hidden" name="id" value=<?= $user['UEMAIL'] ?> >
              <td align="center" style="width: 400px;font-size: 20px"><?= $user['USERS_PASSWORD'] ?>
                
              </td>
            </form>
            
          </tr>
            
        <?php endforeach; ?>
    </table>
    <div>
      <form  action="/index.php?r=Admin/home_page" method="POST" class="col-xs-offset-4 col-sm-2">
        <input type="hidden" name="page" value=<?=  $page-1?> >
        <button class="btn btn-warning" type="submit" >
      上一页
        </button>
      </form>
      <a class="navbar-brand col-sm-2" href="#"><?= "第".$page."页"?></a>
      <form action="/index.php?r=Admin/home_page" method="POST" class="col-sm-3">
        <input type="hidden" name="page" value=<?= $page+1?> >
        <button class="btn btn-warning" type="submit">
        下一页
        </button>

      </form>
    </div>


</body>
</html>