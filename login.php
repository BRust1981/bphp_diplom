<?php
  require 'init.php';
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  function bruteLog($login, $errArray){
    if(!file_exists('log')){
      mkdir('log');
    }
    $dir = 'log/';
    $file = fopen($dir . $login . '.log', 'a+');
    foreach($errArray as $key => $errorTime){
      fwrite($file, date('Y-m-d H:i:s', $errorTime) . "\n");
    }
    fclose($file);
  }
  /*
  Фиксировать в куках будем время ошибки и логироавть только данные с момента 
  попытки взлома (третья попытка в 60 секунд считается брутом, ее и фиксируем)
  */
  // $users = [
  //         'admin' => 'admin1234',
  //         'randomUser' => 'somePassword',
  //         'janitor' => 'nimbus2000'
  //   ];
  // сразу фиксим время
  $time = time();
  $errortime = [];
  
  if(!isset($_COOKIE['logintime'])){
    //если не зафиксирована попытка перебора
    if(!isset($_COOKIE['bruteforcedetected']) ||
        isset($_COOKIE['bruteforcedetected']) && $time - $_COOKIE['bruteforcedetected'] > 60){
      //Если пришли значения login и password
      if(isset($_POST['login']) && isset($_POST['password'])){
        $log = $_POST['login'];
        $psw = $_POST['password'];
      //учтем пустые, хотя форма ввода и не позволяет этого
      } else {
        $log = '';
        $psw = '';
      }
      //если пришедшие значения логина-пароля совпали с существующими в системе
      if(array_key_exists($log, AUTHORIZED_USERS) && AUTHORIZED_USERS[$log] == $psw){
        // создаем куку об успешной авторизации
        setcookie('logintime', $time, $time + 86400);       // на 1 минуты
        //Переходим на правильную страницу
        header('HTTP/1.1 200 OK'); 
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/form.php');
              // иначе фиксируем ошибку
      } else {
        // если кука с ошибками уже заводилась
        if(isset($_COOKIE['errortime'])){
          $errorTime = unserialize($_COOKIE['errortime']);
          $countErrors = count($errorTime[$log]);

          if($countErrors >= 2 && $time - $errorTime[$log][0] < 60 ||                 // три в минуту
            $countErrors >= 1 && $time - $errorTime[$log][$countErrors - 1] < 5     // между входами меньше 5 сек
            ){    
            $errorTime[$log][] = $time;
            setcookie('bruteforcedetected', $time, $time + 60); //, date_add($time, date_interval_create_from_date_string("1 minute")));  //пока ставим признак брута на минуту
            //здесь будем кидать инфу в файл
            bruteLog($log, $errorTime[$log]);
            //сбрасываем куку об ошибках после вынесения в лог
            setcookie('errortime', null, -1);
          } else {
            $errorTime[$log][] = $time;
            setcookie('errortime', serialize($errorTime), $time + 60); //date_add($time, date_interval_create_from_date_string("1 minute")));
          }
        } else {
          //
          $errorTime[$log][] = $time;
          setcookie('errortime', serialize($errorTime), $time + 60); //, date_add($time, date_interval_create_from_date_string("1 minute")));
        }
      } 
    }

    if(isset($_COOKIE['bruteforcedetected'])){
      if($time - $_COOKIE['bruteforcedetected'] > 60){
        setcookie('bruteforcedetected', null, -1);                //скидываем признак брута
      } else {
        if(isset($_POST['login']) && isset($_POST['password'])){
          $errorTime[] = $time;
          bruteLog($_POST['login'], $errorTime);
          setcookie('bruteforcedetected', $time, $time + 60);  //обновляем признак брута пока пользователь не успокоится
        }
      }
    }
  }
  header('HTTP/1.1 200 OK'); 
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');

?>
