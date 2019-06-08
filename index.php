<?php
$array = '';
$host = 'localhost';
$login = 'root';
$password = '';
$name_bd = 'todo';

///Отправка формы с новым заданием ///
if (!empty($_POST)){
	// Подключаемся к БД / логин / пароль / имя БД
    $connect = new mysqli($host, $login, $password, $name_bd);

	//Записывает в переменную / trim(убираем пробелы в начале и в конце)
    $task = strip_tags(trim($_POST['task']));
	// Записываем значение поля textarea в таблицу
    $sql = "INSERT INTO task(task) VALUES ('$task')";
    $connect->query($sql);
	//Закрываем подключение к БД
    $connect->close();
	// Перезапускаем страницу
    header("Location: index.php");
    }

/////////////////////////////////////
///Загрузка данных на страницу //////
    
    // Подключаемся к БД / логин / пароль / имя БД
    $connect = new mysqli($host, $login, $password, $name_bd);
    $sql = "SELECT * FROM task";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
      foreach ($result as $key => $value){
      $new_arr[] = ["task" => $value['task'] ];
	 }
		
	$new_arr = array_reverse($new_arr);
    foreach ($new_arr as $key => $value){
         $array .= "<p><span>".$value['task']."</span></p>";
	}

}
echo '
<!DOCTYPE html>
<html lang="ru">
<head>
<title>Task</title>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="main.css">
</head>

<body>
<div class="todo">TO DO LIST</div>
<form method="POST">
<div class="cont_text">
<input type="submit" value="+">
<textarea name="task" maxlength="50" placeholder="Задание" required></textarea>
</div>
<div class="massege">'.$array.'</div>
</form>
</body>
</html>';
?>
