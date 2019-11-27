<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
		<?php foreach ($category as $value): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= $value['name_cat']; ?></a>   
			</li>   
		<?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">	
            <!--заполните этот список из массива с товарами-->
		    <?php foreach ($lots as $key => $value): ?>   
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $value["name_cat"]; ?></span> 
                    <h3 class="lot__title"><a class="text-link" href="lot.php?lot=<?php echo $value['id']; ?>"><?= $value["name_lots"]; ?></a></h3>   
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
						 	<span class="lot__cost"><?= format_sum($value["start_price"]); ?></span>   
                        </div>
						<div class="lot__timer timer <?php if($hour == 0): ?>timer--finishing<?php endif ?>">  <!-- 3 ЛЕКЦИЯ 2 ЗАДАНИЕ!!! используем переменную, которой присвоили глобальное значение в функции time_remain для вывода дополнительного класса элемента, когда времени осталось меньше часа -->
                            <?= time_remain($value["date_finish"]); ?>                                         <!-- 3 ЛЕКЦИЯ 2 ЗАДАНИЕ!!! в цикле обхода массива лотов выводим количество часов и минут оставшихся до даты убирания лота с сайта-->
                        </div>
					</div>
                </div>
            </li>
			<?php endforeach; ?>
        </ul>
    </section>