<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format_sum($num) {
	//$rounded = ceil($num);
	
	if ($num/*rounded*/ < 1000) {
	   return $num/*rounded*/." ₽";
	}
	else {
		return number_format($num/*rounded*/, 0 , "." , " ")." ₽";
	}									
}

function time_remain($date_end) {                                      // 3 ЛЕКЦИЯ 2 ЗАДАНИЕ!!! функция вычисляет количество оставшихся часов и минут до даты "date_end", указанной в массиве $lots
	date_default_timezone_set('Europe/Samara');                        // установил местное время
	
	$int = strtotime($date_end) - time();                              // нашел разницу между метками времени даты "date_end" и текущим моментом
	
	global $hour;                                                      // задали переменной глобальное значение, чтобы использовать ее вне функции для вывода дополнительного класса
	
	$hour = $remain_time[1] = floor($int / 3600);                      // разницу между метками времени перевели в часы, округлили и записали в первый элемент массива
	$remain_time[2] = floor(($int / 3600 - floor($int / 3600)) * 60);  // вычислили минуты и записали во второй элемент массива
	
	return array_shift($remain_time).":".array_pop($remain_time);      // возвращаем первый и второй элементы массива (часы:минуты)
}



// функция для вывода списка категорий

/* function echo_categories ($category, $li_class = '', $a_class = '') {
	$categories = '';
	
	if ( empty($categories) ) {
		return '';
	}
	
	foreach ($category as $value){
		$categories .= '<li class="' . $li_class . '">';
		$categories .= '<a class="' . $a_class . '" href="pages/all-lots.html">' . $value['name_cat'] . '</a>';  
		$categories .= </li>';
	}
	
	return $categories;
}

вместо <?=...?> используй <?php echo ...?>

<?= не рекомендуется   */


function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}
	
function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}

function validateLength($value, $min, $max) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }
    return null;
}

function validate_start_price($value) {
	if ($value <= 0) {
		return "Значение должно быть больше нуля";
	}
	return null;
}

function validate_bet_step($value) {
	if(!is_int($value) or $value <= 0) {
		return "Значение должно быть целым числом больше нуля";
	}
	return null;
}

function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);
	
	if(strtotime(date('Y-m-d')) - strtotime($dateTimeObj) >= 86400 and $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0) {
		return $dateTimeObj;
	}
	else {
		return "Дата окончания торгов должна быть больше текущей хотя бы на один день";
	}
	return null;

    //return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

function getPostVal($name) {
    return filter_input(INPUT_POST, $name);
}
?>