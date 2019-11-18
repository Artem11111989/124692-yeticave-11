<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('functions.php');
require_once('data.php');
$page_content = include_template('main.php', ['category' => $category, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Главная']);
print($layout_content);

$con = mysqli_connect("localhost", "root", "", "yeticave");
if($con == false) {
	print("Ошибка подключения: " . mysqli_connect_error());
}
else {
	print("Соединение установлено");
}

mysqli_set_charset($con, "utf8");

$sql_lots = <<<SQL
SELECT lots.name_lots, categories.name_cat, lots.date_create, lots.start_price, lots.date_finish, lots.picture FROM lots
JOIN categories ON lots.category_name = categories.id                                                                                                      
WHERE lots.date_finish BETWEEN '2019-11-09' AND '2019-12-31'
AND lots.date_create BETWEEN '2019-11-01 00:00' AND '2019-11-09 00:00'
ORDER BY lots.date_create DESC
SQL;

$result_lots = mysqli_query($con, $sql_lots);

if(!$result_lots) {
	$error = mysqli_error($con);
	print("Ошибка MySQL: " . $error);
}
	
$lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
var_dump($lots)."<br>";



$sql_cat = <<<SQL
SELECT name_cat FROM categories
SQL;

$result_cat = mysqli_query($con, $sql_cat);
	
	if(!$result_cat) {
	$error = mysqli_error($con);
	print("Ошибка MySQL: " . $error);
}
	
$category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
var_dump($category);
?>
