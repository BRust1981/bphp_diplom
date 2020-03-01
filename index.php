<?php
  require 'init.php';
  //echo AUTHORIZED_USERS['user1'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Дипломный проект по курсу "Основы PHP"</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <header class="header">
    <h1>Бюро переводов</h1>
  </header>
  <div class="login" id="login">
    <div class="dialog">
      <div class="content">

        <div class="form-header">
          <h2 class="title">Вход</h2>
        </div>

        <div class="login-body">
          <form class="login-form" id="login-form" action="login.php" method="post">
            <div class="form-group">
              <input type="login" class="input-inner" placeholder="Логин" name="login" required>
            </div>
            <div class="form-group">
              <input type="password" class="input-inner" placeholder="Пароль" name="password" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn-submit">Войти</button>
            </div>
          </form>
        </div>


      </div>
    </div>
  </div>
</body>
</html>
