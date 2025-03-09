<?php
$servername = "localhost";  // MySQL 서버 주소
$username = "root";         // 기본 사용자 이름
$password = "";             // 기본 비밀번호 (XAMPP는 기본적으로 비밀번호 없음)
$dbname = "my_project";     // 데이터베이스 이름 (생성한 DB 이름으로 변경!)

$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}
?>
