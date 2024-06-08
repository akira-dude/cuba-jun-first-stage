<?php

// ВОПРОС 2
// Как на php можно перенаправить стандартный лог ошибок в свой кастомный файл?

// ОТВЕТ
// Используя функцию set_error_handler(). Пример:

// Функция для обработки ошибок
function errorHandler($errno, $errstr, $errfile, $errline) {
    // Открываем или создаем файл для записи ошибок
    $errorLog = fopen('error.log', 'a');
    // Форматируем сообщение об ошибке
    $errorMessage = date('Y-m-d H:i:s') . " | Error: $errstr | File: $errfile | Line: $errline" . PHP_EOL;
    // Записываем сообщение в файл
    fwrite($errorLog, $errorMessage);
    // Закрываем файл
    fclose($errorLog);
}

// Устанавливаем пользовательскую функцию для обработки ошибок вместо стандартной error_log
set_error_handler("errorHandler");

// Генерируем ошибку (E_NOTICE). Она будет записана в кастомный файл error.log
echo $undefinedVariable;

?>
