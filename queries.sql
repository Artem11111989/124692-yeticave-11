INSERT INTO categories
(id, name_cat, symbol_code)
VALUES
('1', 'Доски и лыжи', 'boards'),
('2', 'Крепления', 'attachment'),
('3', 'Ботинки', 'boots'),
('4', 'Одежда', 'clothing'),
('5', 'Инструменты', 'tools'),
('6', 'Разное', 'other');

INSERT INTO lots
(id, date_create, name_lots, description, picture, start_price, date_finish, bet_step, author_id, winner_id, category_name)
VALUES
('1', '2019-10-29 10:30', '2014 Rossignol District Snowboard', 'Описание1', 'img/lot-1.jpg', '10999', '2019-12-24', '500', '1', '0', '1'),
('2', '2019-10-30 11:30', 'DC Ply Mens 2016/2017 Snowboard', 'Описание2', 'img/lot-2.jpg', '159999', '2019-11-23', '500', '1', '2', '1'),
('3', '2019-10-31 12:30', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Описание3', 'img/lot-3.jpg', '8000', '2020-01-01', '500', '2', '0', '2'),
('4', '2019-11-01 13:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'Описание4', 'img/lot-4.jpg', '10999', '2019-11-18', '500', '2', '0', '3'),
('5', '2019-11-02 14:30', 'Куртка для сноуборда DC Mutiny Charocal', 'Описание5', 'img/lot-5.jpg', '7500', '2019-12-12', '500', '3', '0', '4'),
('6', '2019-11-03 15:00', 'Маска Oakley Canopy', 'Описание6', 'img/lot-6.jpg', '5400', '2019-12-01', '500', '3', '0', '6');

INSERT INTO bets
(id, bet_date, bet_sum, user_id, lot_id)
VALUES
('1', '2019-11-04 10:00', '160499', '1', '2'),
('2', '2019-11-05 11:00', '160999', '2', '2')
('3', '2019-11-06 12:00', '8000', '3', '5');

INSERT INTO users
(id, registration_date, email, name, password, contacts)
VALUES
('1', '2019-10-01 10:00', 'ivanov98@mail.ru', 'Ivan', '12345', '89272707070'),
('2', '2019-11-02 11:00', 'petrov99@yandex.ru', 'Petr', '67890', '89292909090'),
('3', '2019-11-03 12:00', 'sidorov00@gmail.ru', 'Sidor', '22222', '89299299090');

SELECT id, name_cat FROM categories;                                                                  /* получить id и название из таблицы категорий */

SELECT lots.name_lots, lots.start_price, lots.picture, bets.bet_sum, categories.name_cat FROM lots    /* из таблицы лотов выбираем имя лота, начальную цену, ссылку на изображение; */
JOIN categories ON lots.category_name = categories.id                                                 /* из таблицы категорий выбираем имя категорий;  */
JOIN bets ON lots.id = bets.lot_id                                                                    /* из таблицы ставок выбираем текущую цену на лот */
WHERE lots.date_finish BETWEEN '2019-11-09' AND '2019-12-31'
AND lots.date_create BETWEEN '2019-11-01 00:00' AND '2019-11-09 00:00';

SELECT lots.name, categories.name FROM lots                                                           /* из таблицы лотов выбираем название лота, */
JOIN categories ON lots.category_name = categories.id                                                 /* а из таблицы категорий выбираем название категории */   
WHERE lots.id = '3';

UPDATE lots SET name = '2014 Rossignol District Snowboard NEW!!'                                      /* обновили название лота по его идентификатору */
WHERE id = '1';

SELECT bet_date, bet_sum FROM bets                                                                    /* из таблицы ставок выбрали ставки для лота с определенным id и */ 
WHERE lot_id = '2'                                                                                    /* отсортировали их по дате от самой ранней до самой поздней */
ORDER BY bet_date DESC;