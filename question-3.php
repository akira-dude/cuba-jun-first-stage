<?php

// ВОПРОС 3
/*
Есть код и запрос к БД, чтобы вы в нем изменили? Почему?:
$DB->query("SELECT * FROM abc WHERE id=" . $_GET['id']);
*/

// ОТВЕТ
// Прямая вставка пользовательского ввода может привести к SQL-инъекции. Для этого нужно предварительно подготовить запрос. Пример:

// Создание соединения
$conn = new mysqli("localhost", "root", "root", "cuba-test");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Подготовка SQL-запроса
$query = "SELECT * FROM abc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Обработка результатов
    }
} else {
    echo "No results for query";
}

// Закрытие соединения
$conn->close();

?>
