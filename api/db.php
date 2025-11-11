<?php
/**
 * db.php
 * Thiết lập kết nối cơ sở dữ liệu bằng PDO.
 */

// Thông tin kết nối CSDL
define('DB_HOST', 'localhost');
define('DB_NAME', 'nhathuocantam'); // Tên CSDL của bạn
define('DB_USER', 'root');
define('DB_PASS', ''); // Mật khẩu của bạn (thường là rỗng nếu dùng XAMPP/WAMP mặc định)

/**
 * Hàm thiết lập và trả về đối tượng kết nối PDO.
 * @return PDO Đối tượng kết nối PDO
 */
function pdo() {
    static $pdo = null;
    
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Báo lỗi dưới dạng Exception
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mặc định trả về mảng kết hợp
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Tắt chế độ giả lập Prepare
        ];
        
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            // Dừng chương trình và báo lỗi nếu kết nối thất bại
            http_response_code(500);
            echo json_encode(['error' => 'Lỗi kết nối CSDL: ' . $e->getMessage()]);
            exit();
        }
    }
    return $pdo;
}

/**
 * Hàm chuẩn hóa đầu ra JSON cho API.
 * @param array $data Dữ liệu cần trả về.
 * @param string $message Thông báo kèm theo.
 * @param int $status Mã trạng thái HTTP (mặc định 200).
 */
function json_response($data, $message = 'Thành công', $status = 200) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($status);
    echo json_encode([
        'success' => $status === 200,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}
?>