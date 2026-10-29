<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "quanlythietbi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: dangnhap.php");
        exit();
    }
}

if (isset($_POST['btn_them'])) {
    check_login();
    $ten_sp = $_POST['ten_sp'];
    $gia = $_POST['gia'];
    $so_luong = $_POST['so_luong'];
    $ma_dm = $_POST['ma_dm'];
    $ma_ncc = $_POST['ma_ncc'];
    
    $hinh_anh = $_FILES['hinh_anh']['name'];
    $target_dir = "images/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($hinh_anh);
    move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file);

    $sql_them = "INSERT INTO sanpham (ten_sp, ma_dm, ma_ncc, gia, so_luong, hinh_anh) 
                 VALUES ('$ten_sp', '$ma_dm', '$ma_ncc', '$gia', '$so_luong', '$hinh_anh')";
    if ($conn->query($sql_them) === TRUE) {
        echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm sản phẩm!'); window.location.href='index.php';</script>";
    }
}

if (isset($_GET['xoa'])) {
    check_login();
    $ma_sp = $_GET['xoa'];
    $sql_xoa = "DELETE FROM sanpham WHERE ma_sp = '$ma_sp'";
    if ($conn->query($sql_xoa) === TRUE) {
        echo "<script>alert('Xóa sản phẩm thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa sản phẩm!'); window.location.href='index.php';</script>";
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_dm = isset($_GET['danhmuc']) ? $_GET['danhmuc'] : '';

$sql = "SELECT sp.*, dm.ten_dm, ncc.ten_ncc 
        FROM sanpham sp
        JOIN danhmuc dm ON sp.ma_dm = dm.ma_dm
        JOIN nhacungcap ncc ON sp.ma_ncc = ncc.ma_ncc WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND sp.ten_sp LIKE '%$search%'";
}
if (!empty($filter_dm)) {
    $sql .= " AND sp.ma_dm = '$filter_dm'";
}

$result = $conn->query($sql);

$list_dm = $conn->query("SELECT * FROM danhmuc");
$list_ncc = $conn->query("SELECT * FROM nhacungcap");
?>