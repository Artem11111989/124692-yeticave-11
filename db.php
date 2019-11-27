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
	
	if(empty($lot_id) or empty($sql_lot)) {
		return http_response_code(404);
	}
	
	return $lot[0];
}

?>