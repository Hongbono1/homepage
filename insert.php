<?php
include 'db.php'; // MySQL 연결

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $delivery = $_POST['delivery'];
    $open_hours = $_POST['open_hours'];

    // SQL 쿼리 실행
    $sql = "INSERT INTO hospital_info (name, category, delivery, open_hours) 
            VALUES ('$name', '$category', '$delivery', '$open_hours')";

    if ($conn->query($sql) === TRUE) {
        echo "병원 정보가 성공적으로 저장되었습니다!";
        header("Location: list.php"); // 저장 후 리스트 페이지로 이동
    } else {
        echo "오류: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
