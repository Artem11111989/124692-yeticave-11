<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('functions.php');
require_once('db.php');

$category = get_all_categories();
$lots = get_all_lots();

//$header = include_template('header.php', []);
//$footer = include_template('footer.php', ['category' => $category]);

//$lot_content = include_template('lot.php', ['category' => $category, 'header' => $header, 'footer' => $footer]);
//print($lot_content);

$page_content = include_template('main.php', ['category' => $category, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Главная', 'category' => $category/*, 'header' => $header*/]);

print($layout_content);


?>
