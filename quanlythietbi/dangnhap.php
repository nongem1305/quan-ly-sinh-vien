<?php
session_start();
include 'ketnoi.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if (isset($_POST['btn_dangnhap'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql_user = "SELECT * FROM nguoidung WHERE tentaikhoan = '$username' AND matkhau = '$password'";
    $res_user = $conn->query($sql_user);

    if ($res_user && $res_user->num_rows > 0) {
        $row_user = $res_user->fetch_assoc();
        $_SESSION['user_id'] = $row_user['id'];
        $_SESSION['hoten'] = $row_user['hoten'];
        echo "<script>alert('Đăng nhập thành công!'); window.location.href='index.php';</script>";
        exit();
    } else {
        $error = "Tài khoản hoặc mật khẩu không chính xác!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập - Quản Lý Thiết Bị Tin Học</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-card { background: white; width: 380px; padding: 30px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .login-card h2 { text-align: center; color: #0056b3; margin-bottom: 20px; font-size: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px; color: #333; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        .btn-login { width: 100%; background: #0056b3; color: white; border: none; padding: 10px; border-radius: 4px; font-weight: bold; font-size: 15px; cursor: pointer; }
        .btn-login:hover { background: #004085; }
        .error-msg { color: #dc3545; font-size: 13px; margin-bottom: 12px; text-align: center; }
        .demo-info { background: #e9ecef; padding: 10px; border-radius: 4px; margin-top: 15px; font-size: 12px; color: #555; text-align: center; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>ĐĂNG NHẬP HỆ THỐNG</h2>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label>Tên tài khoản:</label>
                <input type="text" name="username" placeholder="Nhập tên tài khoản..." required>
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu..." required>
            </div>
            <button type="submit" name="btn_dangnhap" class="btn-login">Đăng nhập</button>
        </form>
    </div>

</body>
</html>