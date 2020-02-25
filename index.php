<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Дипломный проект по курсу "Основы PHP"</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body class="">
    <header class="header">
    </header>
  <div class="login" id="login">
          <div class="dialog">
              <div class="content">
                  <div class="header">
                      <h4 class="title">Вход</h4>
                  </div>
                  <div class="-body">
                      <form class="form" id="login-form" action="../login.php" method="post">
                          <div class="form-group">
                              <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                          </div>
                          <div class="form-group">
                              <input type="password" class="form-control" placeholder="Пароль" name="password" required>
                          </div>
                      </form>
                  </div>
                  <div class="footer">
                      <button type="submit" class="btn btn-primary" form="login-form">Войти</button>
                  </div>
              </div>
          </div>
      </div>
</body>
</html>
