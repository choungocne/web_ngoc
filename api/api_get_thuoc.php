<?php
/**
 * api_get_thuoc.php
 * API: Lấy danh sách sản phẩm (thuốc/TPCN) đang hoạt động.
 * Method: GET
 */
require_once 'db.php';

// Thiết lập tiêu đề Content-Type cho JSON (được gọi lại trong json_response)
// header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = pdo();
    
    // Lấy tham số phân trang nếu có
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = max(1, $limit); // Đảm bảo limit > 0
    $offset = max(0, $offset); // Đảm bảo offset >= 0

    // Truy vấn lấy sản phẩm
    $sql = "
        SELECT 
            sp.masp, sp.tensp, sp.giaban, sp.hinhsp, sp.xuatxu, sp.requires_rx, dm.tendm
        FROM sanpham sp
        JOIN danhmuc dm ON sp.madm = dm.madm
        WHERE sp.trangthai = 1
        ORDER BY sp.masp DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll();

    // Lấy tổng số lượng sản phẩm để tiện cho phân trang
    $total_sql = "SELECT COUNT(masp) FROM sanpham WHERE trangthai = 1";
    $total = $pdo->query($total_sql)->fetchColumn();

    json_response([
        'products' => $products,
        'total' => (int)$total,
        'limit' => $limit,
        'offset' => $offset
    ], 'Lấy danh sách sản phẩm thành công');

} catch (\PDOException $e) {
    json_response(null, 'Lỗi truy vấn dữ liệu: ' . $e->getMessage(), 500);
} catch (\Exception $e) {
    json_response(null, 'Lỗi hệ thống không xác định: ' . $e->getMessage(), 500);
}
?>