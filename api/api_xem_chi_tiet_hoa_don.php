<?php
/**
 * api_xem_chi_tiet_hoa_don.php
 * API: Lấy chi tiết đơn hàng dựa trên mã đơn hàng (sodh).
 * Method: GET
 */
require_once 'db.php';

try {
    // 1. Kiểm tra tham số đầu vào
    if (!isset($_GET['sodh']) || !is_numeric($_GET['sodh'])) {
        json_response(null, 'Thiếu hoặc sai định dạng mã đơn hàng (sodh).', 400);
    }

    $sodh = (int)$_GET['sodh'];
    $pdo = pdo();

    // 2. Truy vấn lấy chi tiết đơn hàng
    $sql = "
        SELECT 
            dh.*, 
            kh.hoten AS ten_khachhang, 
            nv.hoten AS ten_nhanvien
        FROM donhang dh
        LEFT JOIN khachhang kh ON dh.makh = kh.makh
        LEFT JOIN nhanvien nv ON dh.manv = nv.manv
        WHERE dh.sodh = :sodh
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sodh', $sodh, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch();

    if (!$order) {
        json_response(null, 'Không tìm thấy đơn hàng với mã: ' . $sodh, 404);
    }
    
    // 3. Xử lý trường JSON (chitiet) để trả về mảng
    if (isset($order['chitiet'])) {
        $order['chitiet'] = json_decode($order['chitiet'], true);
    }

    json_response($order, 'Lấy chi tiết đơn hàng thành công');

} catch (\PDOException $e) {
    json_response(null, 'Lỗi truy vấn dữ liệu: ' . $e->getMessage(), 500);
} catch (\Exception $e) {
    json_response(null, 'Lỗi hệ thống không xác định: ' . $e->getMessage(), 500);
}
?>