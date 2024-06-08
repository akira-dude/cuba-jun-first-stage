<?php

// ВОПРОС 4
/*
В БД есть таблица заказов (orders) с полями:
date - дата оформления заказа
customer_name - имя клиента
order_price - сумма заказа

Напиши sql запросы для выборки:
Запрос, который покажет сколько денег принес каждый отдельно взятый покупатель с группировкой по месяцам.
Запрос, который выведет  имена клиентов, у которых суммарные покупки за весь период превысили 10 тыс. руб. и одновременно никогда не было заказов менее 500 руб.
*/

$query_1 = <<<SQL
SELECT 
    customer_name,
    SUM(order_price) AS total_spent,
    DATE_FORMAT(date, '%Y-%m') AS month
FROM
    orders
GROUP BY
    customer_name, month
ORDER BY
    month, customer_name
SQL;

$query_2 = <<<SQL
SELECT 
    customer_name
FROM 
    orders
GROUP BY 
    customer_name
HAVING 
    SUM(order_price) > 10000 AND 
    MIN(order_price) >= 500;
SQL;

?>
