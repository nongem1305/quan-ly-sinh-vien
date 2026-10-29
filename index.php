<?php 
include 'ketnoi.php'; 
check_login();

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'trangchu';

if (isset($_POST['btn_themdm'])) {
    $ten_dm = $_POST['ten_dm'];
    if(!empty($ten_dm)) {
        $conn->query("INSERT INTO danhmuc (ten_dm) VALUES ('$ten_dm')");
        echo "<script>alert('Thêm danh mục thành công!'); window.location.href='index.php?tab=danhmuc';</script>";
    }
}

if (isset($_POST['btn_themncc'])) {
    $ten_ncc = $_POST['ten_ncc'];
    $dien_thoai = $_POST['dien_thoai'];
    $dia_chi = $_POST['dia_chi'];
    if(!empty($ten_ncc)) {
        $conn->query("INSERT INTO nhacungcap (ten_ncc, dien_thoai, dia_chi) VALUES ('$ten_ncc', '$dien_thoai', '$dia_chi')");
        echo "<script>alert('Thêm nhà cung cấp thành công!'); window.location.href='index.php?tab=nhacungcap';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cửa Hàng Thiết Bị Tin Học</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #f0f2f5; padding: 20px; }
        
        .header { background: #0056b3; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: 4px; }
        .header h1 { font-size: 22px; }
        .header-right { display: flex; align-items: center; gap: 15px; }
        .user-info { font-size: 14px; }
        .btn-logout { background: #dc3545; color: white; padding: 6px 12px; border-radius: 3px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-logout:hover { background: #bd2130; }

        .search-box { display: flex; gap: 5px; }
        .search-box input { padding: 6px 10px; width: 220px; border: none; border-radius: 3px; }
        .search-box button { background: #004085; color: white; border: none; padding: 6px 15px; border-radius: 3px; cursor: pointer; }

        .navbar { background: white; display: flex; gap: 20px; padding: 12px 20px; margin-top: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 4px; }
        .navbar a { text-decoration: none; color: #333; font-weight: bold; }
        .navbar a.active, .navbar a:hover { color: #0056b3; }

        .section-title { margin: 20px 0 10px 0; color: #333; font-size: 18px; }
        
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 15px; }
        .product-card { background: white; border: 1px solid #dcdcdc; border-radius: 4px; padding: 12px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .product-card img { width: 100%; height: 140px; object-fit: contain; margin-bottom: 10px; }
        .product-card h3 { font-size: 15px; color: #222; margin-bottom: 5px; }
        .product-price { color: #dc3545; font-weight: bold; font-size: 16px; margin-bottom: 5px; }
        .product-card p { font-size: 13px; color: #555; margin-bottom: 3px; }
        
        .card-actions { display: flex; gap: 8px; margin-top: 10px; }
        .btn-sua { flex: 1; background: #007bff; color: white; text-align: center; padding: 6px; text-decoration: none; border-radius: 3px; font-size: 13px; }
        .btn-xoa { flex: 1; background: #dc3545; color: white; text-align: center; padding: 6px; text-decoration: none; border-radius: 3px; font-size: 13px; }

        .form-container { background: white; border: 1px solid #dcdcdc; border-radius: 4px; padding: 20px; margin-top: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px; }
        .form-group { display: flex; flex-direction: column; margin-bottom: 12px; }
        .form-group label { font-weight: bold; font-size: 13px; margin-bottom: 5px; color: #333; }
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ccc; border-radius: 3px; font-size: 13px; }
        
        .form-buttons { display: flex; gap: 10px; margin-top: 15px; }
        .btn-submit { background: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 3px; cursor: pointer; font-weight: bold; }
        .btn-reset { background: #6c757d; color: white; border: none; padding: 8px 20px; border-radius: 3px; cursor: pointer; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; border-radius: 4px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background-color: #0056b3; color: white; }

        .file-upload-wrapper { display: flex; align-items: center; gap: 10px; margin-top: 5px; }
        .custom-file-upload { background: #e0e0e0; color: #333; padding: 6px 12px; border-radius: 3px; cursor: pointer; font-size: 13px; font-weight: bold; border: 1px solid #ccc; display: inline-block; }
        .custom-file-upload:hover { background: #d0d0d0; }
        .file-name-display { font-size: 13px; color: #555; }
    </style>
</head>
<body>

    <div class="header">
        <h1>CỬA HÀNG THIẾT BỊ TIN HỌC</h1>
        <div class="header-right">
            <form class="search-box" method="GET" action="index.php">
                <input type="hidden" name="tab" value="<?php echo $tab; ?>">
                <input type="text" name="search" placeholder="Nhập tên sản phẩm..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Tìm kiếm</button>
            </form>
            <span class="user-info">Xin chào, <b><?php echo $_SESSION['hoten']; ?></b></span>
            <a href="dangxuat.php" class="btn-logout">Đăng xuất</a>
        </div>
    </div>

    <div class="navbar">
        <a href="index.php?tab=trangchu" class="<?php echo ($tab == 'trangchu') ? 'active' : ''; ?>">Trang chủ</a>
        <a href="index.php?tab=sanpham" class="<?php echo ($tab == 'sanpham') ? 'active' : ''; ?>">Sản phẩm</a>
        <a href="index.php?tab=danhmuc" class="<?php echo ($tab == 'danhmuc') ? 'active' : ''; ?>">Danh mục</a>
        <a href="index.php?tab=nhacungcap" class="<?php echo ($tab == 'nhacungcap') ? 'active' : ''; ?>">Nhà cung cấp</a>
        <a href="index.php?tab=lienhe" class="<?php echo ($tab == 'lienhe') ? 'active' : ''; ?>">Liên hệ</a>
    </div>

    <?php if ($tab == 'trangchu'): ?>
        <div class="section-title">DANH SÁCH SẢN PHẨM</div>
        <div class="product-grid">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="product-card">
                        <div>
                            <img src="images/<?php echo $row['hinh_anh']; ?>" alt="<?php echo $row['ten_sp']; ?>">
                            <h3><?php echo $row['ten_sp']; ?></h3>
                            <div class="product-price"><?php echo number_format($row['gia'], 0, ',', '.'); ?> VNĐ</div>
                            <p>Danh mục: <?php echo $row['ten_dm']; ?></p>
                            <p>Nhà cung cấp: <?php echo $row['ten_ncc']; ?></p>
                            <p>Số lượng: <?php echo $row['so_luong']; ?></p>
                        </div>
                        <div class="card-actions">
                            <a href="sua.php?id=<?php echo $row['ma_sp']; ?>" class="btn-sua">Sửa</a>
                            <a href="index.php?xoa=<?php echo $row['ma_sp']; ?>" class="btn-xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        </div>
                    </div>
            <?php 
                }
            } else {
                echo "<p>Không tìm thấy sản phẩm nào.</p>";
            }
            ?>
        </div>

        <div class="form-container">
            <div class="section-title" style="margin-top: 0;">THÊM SẢN PHẨM MỚI</div>
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div>
                        <div class="form-group">
                            <label>Tên sản phẩm:</label>
                            <input type="text" name="ten_sp" placeholder="Nhập tên sản phẩm..." required>
                        </div>
                        <div class="form-group">
                            <label>Giá (VNĐ):</label>
                            <input type="number" name="gia" placeholder="Nhập giá..." required>
                        </div>
                        <div class="form-group">
                            <label>Số lượng:</label>
                            <input type="number" name="so_luong" placeholder="Nhập số lượng..." required>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Danh mục:</label>
                            <select name="ma_dm" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php 
                                mysqli_data_seek($list_dm, 0);
                                while ($dm = $list_dm->fetch_assoc()) { 
                                ?>
                                    <option value="<?php echo $dm['ma_dm']; ?>"><?php echo $dm['ten_dm']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nhà cung cấp:</label>
                            <select name="ma_ncc" required>
                                <option value="">-- Chọn nhà cung cấp --</option>
                                <?php 
                                mysqli_data_seek($list_ncc, 0);
                                while ($ncc = $list_ncc->fetch_assoc()) { 
                                ?>
                                    <option value="<?php echo $ncc['ma_ncc']; ?>"><?php echo $ncc['ten_ncc']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                           <label>Ảnh sản phẩm:</label>
                           <div class="file-upload-wrapper">
                               <label class="custom-file-upload">
                                   <input type="file" name="hinh_anh" style="display: none;" onchange="document.getElementById('file-name-text').textContent = this.files[0] ? this.files[0].name : 'Chưa có tệp nào được chọn'" required>
                                   Chọn tệp
                               </label>
                               <span id="file-name-text" class="file-name-display">Chưa có tệp nào được chọn</span>
                           </div>
                        </div> 
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="submit" name="btn_them" class="btn-submit">Thêm sản phẩm</button>
                    <button type="reset" class="btn-reset" onclick="document.getElementById('file-name-text').textContent = 'Chưa có tệp nào được chọn'">Nhập lại</button>
                </div>
            </form>
        </div>

    <?php elseif ($tab == 'sanpham'): ?>
        <div class="container" style="background: white; padding: 20px; margin-top: 20px; border-radius: 4px;">
            <h2>Quản Lý Danh Sách Sản Phẩm</h2>
            <table>
                <tr>
                    <th>Mã SP</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Nhà cung cấp</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                </tr>
                <?php
                $kq = $conn->query("SELECT sp.*, dm.ten_dm, ncc.ten_ncc FROM sanpham sp JOIN danhmuc dm ON sp.ma_dm = dm.ma_dm JOIN nhacungcap ncc ON sp.ma_ncc = ncc.ma_ncc");
                while ($row = $kq->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['ma_sp']; ?></td>
                    <td><img src="images/<?php echo $row['hinh_anh']; ?>" style="width: 50px; height: 50px; object-fit: contain;"></td>
                    <td><?php echo $row['ten_sp']; ?></td>
                    <td><?php echo $row['ten_dm']; ?></td>
                    <td><?php echo $row['ten_ncc']; ?></td>
                    <td style="color: red; font-weight: bold;"><?php echo number_format($row['gia'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo $row['so_luong']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

    <?php elseif ($tab == 'danhmuc'): ?>
        <div class="container" style="background: white; padding: 20px; margin-top: 20px; border-radius: 4px;">
            <h2>Quản Lý Danh Mục</h2>
            <form action="" method="POST" style="margin-top: 15px; display: flex; gap: 10px;">
                <input type="text" name="ten_dm" placeholder="Nhập tên danh mục mới..." required style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 3px;">
                <button type="submit" name="btn_themdm" style="padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; font-weight: bold;">Thêm danh mục</button>
            </form>
            <table>
                <tr>
                    <th>Mã danh mục</th>
                    <th>Tên danh mục</th>
                </tr>
                <?php
                $res_dm = $conn->query("SELECT * FROM danhmuc");
                while ($row_dm = $res_dm->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row_dm['ma_dm']; ?></td>
                    <td><?php echo $row_dm['ten_dm']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

    <?php elseif ($tab == 'nhacungcap'): ?>
        <div class="container" style="background: white; padding: 20px; margin-top: 20px; border-radius: 4px;">
            <h2>Quản Lý Nhà Cung Cấp</h2>
            <form action="" method="POST" style="margin-top: 15px; display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px;">
                <input type="text" name="ten_ncc" placeholder="Tên nhà cung cấp..." required style="padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
                <input type="text" name="dien_thoai" placeholder="Số điện thoại..." style="padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
                <input type="text" name="dia_chi" placeholder="Địa chỉ..." style="padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
                <button type="submit" name="btn_themncc" style="padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; font-weight: bold;">Thêm NCC</button>
            </form>
            <table>
                <tr>
                    <th>Mã NCC</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                </tr>
                <?php
                $res_ncc = $conn->query("SELECT * FROM nhacungcap");
                while ($row_ncc = $res_ncc->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row_ncc['ma_ncc']; ?></td>
                    <td><?php echo $row_ncc['ten_ncc']; ?></td>
                    <td><?php echo $row_ncc['dien_thoai']; ?></td>
                    <td><?php echo $row_ncc['dia_chi']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

    <?php elseif ($tab == 'lienhe'): ?>
        <div class="container" style="background: white; padding: 30px; margin-top: 20px; border-radius: 4px; line-height: 1.6;">
            <h2 style="color: #0056b3; margin-bottom: 15px;">Thông Tin Liên Hệ</h2>
            <p><strong>Cửa Hàng Thiết Bị Tin Học</strong></p>
            <p>Địa chỉ: Lạng Sơn, Việt Nam</p>
            <p>Điện thoại hỗ trợ: 0377777777</p>
            <p>Email: chamsockhachhang@gmail.com</p>
            <p>Hệ thống quản lý thiết bị tin học phục vụ học tập cho mọi gia đình.</p>
        </div>
    <?php endif; ?>

</body>
</html>