<?php
include 'ketnoi.php';
check_login();

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sql_sua = "SELECT * FROM sanpham WHERE ma_sp = '$id'";
$result_sua = $conn->query($sql_sua);
$row_sp = $result_sua->fetch_assoc();

if (!$row_sp) {
    die("Không tìm thấy sản phẩm cần sửa!");
}

$list_dm = $conn->query("SELECT * FROM danhmuc");
$list_ncc = $conn->query("SELECT * FROM nhacungcap");

if (isset($_POST['btn_capnhat'])) {
    $ten_sp = $_POST['ten_sp'];
    $gia = $_POST['gia'];
    $so_luong = $_POST['so_luong'];
    $ma_dm = $_POST['ma_dm'];
    $ma_ncc = $_POST['ma_ncc'];

    if ($_FILES['hinh_anh']['name'] != "") {
        $hinh_anh = $_FILES['hinh_anh']['name'];
        $target_dir = "images/";
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_dir . basename($hinh_anh));
        
        $sql_update = "UPDATE sanpham SET ten_sp='$ten_sp', ma_dm='$ma_dm', ma_ncc='$ma_ncc', gia='$gia', so_luong='$so_luong', hinh_anh='$hinh_anh' WHERE ma_sp='$id'";
    } else {
        $sql_update = "UPDATE sanpham SET ten_sp='$ten_sp', ma_dm='$ma_dm', ma_ncc='$ma_ncc', gia='$gia', so_luong='$so_luong' WHERE ma_sp='$id'";
    }

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật sản phẩm!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Sản Phẩm</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #f0f2f5; padding: 20px; }
        .form-container { background: white; border: 1px solid #dcdcdc; border-radius: 4px; padding: 20px; max-width: 600px; margin: 30px auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        h2 { color: #0056b3; margin-bottom: 20px; font-size: 20px; }
        .form-group { display: flex; flex-direction: column; margin-bottom: 12px; }
        .form-group label { font-weight: bold; font-size: 13px; margin-bottom: 5px; color: #333; }
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ccc; border-radius: 3px; font-size: 13px; }
        .form-buttons { display: flex; gap: 10px; margin-top: 15px; }
        .btn-submit { background: #007bff; color: white; border: none; padding: 8px 20px; border-radius: 3px; cursor: pointer; font-weight: bold; }
        .btn-back { background: #6c757d; color: white; padding: 8px 20px; text-decoration: none; border-radius: 3px; font-size: 13px; text-align: center; line-height: normal; display: inline-flex; align-items: center; }
        .file-upload-wrapper { display: flex; align-items: center; gap: 10px; margin-top: 5px; }
        .custom-file-upload { background: #e0e0e0; color: #333; padding: 6px 12px; border-radius: 3px; cursor: pointer; font-size: 13px; font-weight: bold; border: 1px solid #ccc; display: inline-block; }
        .custom-file-upload:hover { background: #d0d0d0; }
        .file-name-display { font-size: 13px; color: #555; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>CẬP NHẬT THÔNG TIN SẢN PHẨM</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="ten_sp" value="<?php echo $row_sp['ten_sp']; ?>" required>
            </div>
            <div class="form-group">
                <label>Giá (VNĐ):</label>
                <input type="number" name="gia" value="<?php echo $row_sp['gia']; ?>" required>
            </div>
            <div class="form-group">
                <label>Số lượng:</label>
                <input type="number" name="so_luong" value="<?php echo $row_sp['so_luong']; ?>" required>
            </div>
            <div class="form-group">
                <label>Danh mục:</label>
                <select name="ma_dm" required>
                    <?php while ($dm = $list_dm->fetch_assoc()) { ?>
                        <option value="<?php echo $dm['ma_dm']; ?>" <?php if($dm['ma_dm'] == $row_sp['ma_dm']) echo 'selected'; ?>>
                            <?php echo $dm['ten_dm']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nhà cung cấp:</label>
                <select name="ma_ncc" required>
                    <?php while ($ncc = $list_ncc->fetch_assoc()) { ?>
                        <option value="<?php echo $ncc['ma_ncc']; ?>" <?php if($ncc['ma_ncc'] == $row_sp['ma_ncc']) echo 'selected'; ?>>
                            <?php echo $ncc['ten_ncc']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Ảnh hiện tại:</label>
                <img src="images/<?php echo $row_sp['hinh_anh']; ?>" width="100" style="margin-bottom: 8px; border: 1px solid #ddd; padding: 2px;">
                <div class="file-upload-wrapper">
                    <label class="custom-file-upload">
                        <input type="file" name="hinh_anh" style="display: none;" onchange="document.getElementById('file-name-text').textContent = this.files[0] ? this.files[0].name : 'Chưa có tệp nào được chọn'">
                        Chọn tệp
                    </label>
                    <span id="file-name-text" class="file-name-display">Chưa có tệp nào được chọn</span>
                </div>
                <small style="color: #666; margin-top: 3px;">(Bỏ trống nếu không muốn đổi ảnh mới)</small>
            </div>
            <div class="form-buttons">
                <button type="submit" name="btn_capnhat" class="btn-submit">Lưu thay đổi</button>
                <a href="index.php" class="btn-back">Quay lại</a>
            </div>
        </form>
    </div>

</body>
</html>