<?php

// ВОПРОС 8
// Напишите на php функцию для распределения рублевой скидки по купону на все товары в корзине пропорционально стоимости товара. 
// На входе в функцию передаются два параметра: размер скидки в рублях (!) и массив из цен товаров, на выходе тот же массив цен, 
// но уже с учетом скидки: distribute_discount(int $discount, array $prices) → return array $prices;

function distribute_discount(int $discount, array $prices) {
    // Сумма стоимостей всех товаров в корзине
    $total_price = array_sum($prices);
    
    // Рассчитываем долю каждого товара в общей стоимости
    $proportions = array_map(function($price) use ($total_price) {
        return $price / $total_price;
    }, $prices);
    
    // Рассчитываем сумму скидки для каждого товара рублях (!)
    $discounts = array_map(function($proportion) use ($discount) {
        return $discount * $proportion;
    }, $proportions);
    
    // Рассчитываем новую цену для каждого товара
    $new_prices = array_map(function($price, $discount) {
        return $price - $discount;
    }, $prices, $discounts);
    
    return $new_prices;
}

?>
