<?php 
global $con;
$con = mysqli_connect("localhost", "root", "", "yeticave");
if($con == false) {
	print("Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8");

function get_all_lots() { 
    global $con;
	$sql_lots = 
	"SELECT lots.id, lots.name_lots, categories.name_cat, lots.date_create, lots.start_price, lots.date_finish, lots.picture FROM lots
	JOIN categories ON lots.category_name = categories.id                                                                                                      
	WHERE lots.date_finish BETWEEN '2019-11-09' AND '2019-12-31'
	AND lots.date_create BETWEEN '2019-11-01 00:00' AND '2019-11-20 00:00'
	ORDER BY lots.date_create DESC";

	$result_lots = mysqli_query($con, $sql_lots);

	if(!$result_lots) {
		$error = mysqli_error($con);
		print("Ошибка MySQL: " . $error);
	}
		
	$lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
	return $lots;
}

function get_all_categories() {
	global $con;
	$sql_cat = 
	"SELECT name_cat FROM categories";

	$result_cat = mysqli_query($con, $sql_cat);
		
		if(!$result_cat) {
		$error = mysqli_error($con);
		print("Ошибка MySQL: " . $error);
	}
	$category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
	return $category;
}

function get_lot_by_id() {
	if (!isset ($_GET['lot'])) {
		return false;
	}
	
	$lot_id = intval ($_GET['lot']);
	
	if (empty ($lot_id)) {
		return false;
	}
			
    global $con;
	
	$sql_lot = 
	"SELECT lots.name_lots, categories.name_cat, lots.description, lots.date_finish, lots.start_price, lots.bet_step FROM lots
    JOIN categories ON lots.category_name = categories.id
    WHERE lots.id = {$lot_id}"; 

    $result_lot = mysqli_query($con, $sql_lot);

    if(!$result_lot) {
	    $error = mysqli_error($con);
	    print("Ошибка MySQL: " . $error);
    }
	
    $lot = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
	
	if (!isset($lot[0]) or empty($lot[0])) {
		return false;
	}
	
	if(!isset($lot_id) or empty($sql_lot)) {
		return /*http_response_code(404);*/header("Location: 404.php");
	}
	
	return $lot[0];
}

function show404() {
	
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$new_lot = $_POST;
	
    $filename = uniqid() . '.jpg';
    $picture['path'] = $filename;
    move_uploaded_file($_FILES['picture']['tmp_name'], 'uploads/' . $filename);

    $sql_new_lot = 'INSERT INTO lots (id, date_create, name_lots, description, path, start_price, date_finish, bet_step, author_id, winner_id, category_name) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, 1, ?, ?)';

    $stmt_new_lot = db_get_prepare_stmt($con, $sql_new_lot, $picture);
    $res_new_lot = mysqli_stmt_execute($stmt_new_lot);
	
	if ($res_new_lot) {
        $lot_id = mysqli_insert_id($con);

        header("Location: lot.php?id=" . $lot_id);
        }
        else {
            print("Ошибка: " . mysqli_error());
        }
}

$sql_id = 'SELECT id, name FROM categories';
$res_id_cats = mysqli_query($con, $sql_id);

$cats_ids = [];

if ($res_id_cats) {
    $categories = mysqli_fetch_all($res_id_cats, MYSQLI_ASSOC);
    $cats_ids = array_column($categories, 'id');
}
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$required = ['name_lots', 'category_name', 'description', 'path', 'start_price', 'bet_step', 'date_finish'];
	    $errors = [];
		
		$rules = [
        'category_name' => function($value) use ($cats_ids) {
            return validateCategory($value, $cats_ids);
        },
        'name_lots' => function($value) {
            return validateLength($value, 10, 200);
        },
        'description' => function($value) {
            return validateLength($value, 10, 3000);
        },
		'start_price' => function($value) {
			return validate_start_price($value);
		},
		'bet_step' => function($value) {
			return validate_bet_step($value);
		},
		'date_finish' => function($value) {
			return is_date_valid($value);
		}
	  ];
	  
	  $new_lot = filter_input_array(INPUT_POST, ['category_name' => FILTER_DEFAULT, 'name_lots' => FILTER_DEFAULT, 'description' => FILTER_DEFAULT, 'start_price' => FILTER_DEFAULT, 'bet_step' => FILTER_DEFAULT, 'date_finish' => FILTER_DEFAULT], true);

      foreach ($new_lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        }
    }
 
      $errors = array_filter($errors);

	if (!empty($_FILES['picture']['name'])) {
		$tmp_name = $_FILES['picture']['tmp_name'];
		$path = $_FILES['picture']['name'];
        $filename = uniqid() . '.gif';
		
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
		if ($file_type !== "image/jpg" or $file_type !== "image/jpeg" or $file_type !== "image/png") {
		    $errors['file'] = 'Загрузите картинку в формате JPG, JPEG или PNG';
		}
		else {
			move_uploaded_file($tmp_name, 'uploads/' . $filename);
			$picture['path'] = $filename;
		}
	}
	else {
		$errors['file'] = 'Вы не загрузили файл';
	}
	if (count($errors)) {
		$page_content_add_lot = include_template('add.php', ['picture' => $picture, 'errors' => $errors, 'categories' => $categories]);
	}
    else {
        $sqlNewLot = 'INSERT INTO lots (id, date_create, name_lots, description, path, start_price, date_finish, bet_step, author_id, winner_id, category_name) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, 1, ?, ?)';
        $stmtNewLot = db_get_prepare_stmt($con, $sqlNewLot, $picture);
        $resNewLot = mysqli_stmt_execute($stmtNewLot);

        if ($resNewLot) {
            $lot_id = mysqli_insert_id($con);

            header("Location: lot.php?id=" . $lot_id);
        }
	}
}
else {
	$page_content = include_template('add.php', ['categories' => $categories]);
}

$layout_content = include_template('layout.php', ['content' => $page_content, 'categories' => [], 'title' => 'Добавление лота']);

print($layout_content);











?>