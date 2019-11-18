<section class = "promo">
        <h2 class = "promo__title">Нужен стафф для катки?</h2>
        <p class = "promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class = "promo__list">
            <!--заполните этот список из массива категорий-->
			<?php //$category = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"]; ?>
			<?php 
			$index = 0;
			$num = count($category);
			while ($index < $num): ?>
            <li class = "promo__item promo__item--boards">
                <a class = "promo__link" href = "pages/all-lots.html"><?= $category[$index]; ?></a>   
				<?php $index++; ?>
                <?php endwhile; ?>
            </li>
        </ul>
    </section>
    <section class = "lots">
        <div class = "lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class = "lots__list">	
            <!--заполните этот список из массива с товарами-->
			<?php /*$lots = [["title" => "2014 Rossignol District Snowboard", "category" => "Доски и лыжи", "price" => "10999", "picture_URL" => "img/lot-1.jpg", "date_end" => "2019-12-24"],
                          ["title" => "DC Ply Mens 2016/2017 Snowboard", "category" => "Доски и лыжи", "price" => "159999", "picture_URL" => "img/lot-2.jpg", "date_end" => "2019-11-23"],
						  ["title" => "Крепления Union Contact Pro 2015 года размер L/XL", "category" => "Крепления", "price" => "8000", "picture_URL" => "img/lot-3.jpg", "date_end" => "2020-01-01"],
						  ["title" => "Ботинки для сноуборда DC Mutiny Charocal", "category" => "Ботинки", "price" => "10999", "picture_URL" => "img/lot-4.jpg", "date_end" => "2019-11-18"],
						  ["title" => "Куртка для сноуборда DC Mutiny Charocal", "category" => "Одежда", "price" => "7500", "picture_URL" => "img/lot-5.jpg", "date_end" => "2019-12-12"],
						  ["title" => "Маска Oakley Canopy", "category" => "Разное", "price" => "5400", "picture_URL" => "img/lot-6.jpg", "date_end" => "2019-12-01"]]; */?>
		    <?php foreach ($lots as $key => $value): ?>   
            <li class = "lots__item lot">
                <div class = "lot__image">
                    <img src = "" width = "350" height = "260" alt = "">
                </div>
                <div class = "lot__info">
                    <span class = "lot__category"><?= $value["name_cat"]; ?></span> <!-- тут было = $value["category"] -->
                    <h3 class = "lot__title"><a class = "text-link" href = "pages/lot.html"><?= $value["name_lots"]; ?></a></h3>   <!-- тут было = $value["title"] -->
                    <div class = "lot__state">
                        <div class = "lot__rate">
                            <span class = "lot__amount">Стартовая цена</span>
						 	<span class = "lot__cost"><?= format_sum($value["start_price"]); ?></span>   <!-- тут было = format_sum($value["price"]) -->
                        </div>
						<div class = "lot__timer timer <?php if($hour == 0): ?>timer--finishing<?php endif ?>">  <!-- 3 ЛЕКЦИЯ 2 ЗАДАНИЕ!!! используем переменную, которой присвоили глобальное значение в функции time_remain для вывода дополнительного класса элемента, когда времени осталось меньше часа -->
                            <?= time_remain($value["date_finish"]); ?>        <!-- тут было = time_remain($value["date_end"]) -->                                      <!-- 3 ЛЕКЦИЯ 2 ЗАДАНИЕ!!! в цикле обхода массива лотов выводим количество часов и минут оставшихся до даты убирания лота с сайта-->
                        </div>
					</div>
                </div>
            </li>
			<?php endforeach; ?>
        </ul>
    </section>