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
	$rounded = ceil($num);
	
	if ($rounded < 1000) {
	   return $rounded." ₽";
	}
	else {
		return number_format($rounded, 0 , "." , " ")." ₽";
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
?>