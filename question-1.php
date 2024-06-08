<?php

// ВОПРОС 1
/*
В БД mysql  есть одна единственная таблица «abc» с полями: id (int), name (varchar), cnt (int). В таблице содержится порядка 10 млн записей. Что нужно сделать, что быстро работали следующие запросы (3 разных случая)? Все остальные факторы кроме скорости чтения не критичны.
SELECT * FROM abc WHERE name = 'xxx' AND cnt = yyy
SELECT * FROM abc WHERE cnt = xxx AND name LIKE 'yyy%'
SELECT * FROM abc ORDER BY cnt ASC
*/

// ОТВЕТ
// Создать простые индексы (INDEX) в базе данных. Пример:

// Создание соединения
$conn = new mysqli("localhost", "root", "root", "cuba-test");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Создание индексов
$result = $conn->query("CREATE INDEX idx_name_cnt ON abc (name, cnt)");
if (!$result) {
    die("Couldn't create index idx_name_cnt: " . $conn->error);
}

$result = $conn->query("CREATE INDEX idx_cnt_name ON abc (cnt, name)");
if (!$result) {
    die("Couldn't create index idx_cnt_name: " . $conn->error);
}

$result = $conn->query("CREATE INDEX idx_cnt ON abc (cnt)");
if (!$result) {
    die("Couldn't create index idx_cnt: " . $conn->error);
}

// Первый запрос | SELECT * FROM abc WHERE name = 'xxx' AND cnt = yyy
$name = "xyz";
$cnt = 123;

$query = "SELECT * FROM abc WHERE name = ? AND cnt = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $name, $cnt);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Query results 1:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"]. " | Count: " . $row["cnt"]. "<br>";
    }
} else {
    echo "No results for query 1.";
}

$stmt->close();

// Второй запрос | SELECT * FROM abc WHERE cnt = xxx AND name LIKE 'yyy%'
$cnt = 123;
$name = "yyy%";

$query = "SELECT * FROM abc WHERE cnt = ? AND name LIKE ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $cnt, $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Query results 2:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Count: " . $row["cnt"]. " | Name: " . $row["name"]. "<br>";
    }
} else {
    echo "No results for query 2.";
}

$stmt->close();

// Третий запрос | SELECT * FROM abc ORDER BY cnt ASC
$query = "SELECT * FROM abc ORDER BY cnt ASC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "Query results 3:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Count: " . $row["cnt"]. "<br>";
    }
} else {
    echo "No results for query 3.";
}

// Закрытие соединения
$conn->close();

?>
