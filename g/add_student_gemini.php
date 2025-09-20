<?php
// ส่วนนี้คือโค้ดเชื่อมต่อฐานข้อมูล ซึ่งตามที่คุณแจ้งว่ามีไฟล์ connectdb.php อยู่แล้ว
// คุณสามารถแทนที่โค้ดส่วนนี้ด้วยบรรทัดล่างสุดนี้
// include 'connectdb.php';
// เพื่อความสมบูรณ์ของโค้ด ผมได้ใส่โค้ดเชื่อมต่อฐานข้อมูลไว้ที่นี่แทน
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "msu";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// กำหนด Charset ให้เป็น UTF-8 เพื่อรองรับภาษาไทย
$conn->set_charset("utf8mb4");

// สร้างตัวแปรสำหรับเก็บข้อความแจ้งเตือน
$message = "";
$message_type = "";

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มมาหรือไม่ (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $s_id = $_POST['s_id'];
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_gpax = $_POST['s_gpax'];
    $f_id = $_POST['f_id'];

    // เตรียมคำสั่ง SQL สำหรับการ INSERT ข้อมูล
    $sql = "INSERT INTO student (s_id, s_name, s_address, s_gpax, f_id) VALUES (?, ?, ?, ?, ?)";
    
    // ใช้ prepared statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare($sql);
    
    // ผูกตัวแปรกับพารามิเตอร์ในคำสั่ง SQL
    $stmt->bind_param("sssdi", $s_id, $s_name, $s_address, $s_gpax, $f_id);
    
    // เรียกใช้คำสั่ง
    if ($stmt->execute()) {
        $message = "บันทึกข้อมูลนิสิตเรียบร้อยแล้ว!";
        $message_type = "success";
    } else {
        $message = "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
        $message_type = "danger";
    }

    // ปิด prepared statement
    $stmt->close();
}

// ดึงข้อมูลคณะจากตาราง faculty เพื่อนำไปใช้ใน dropdown menu
$faculty_result = $conn->query("SELECT f_id, F_name FROM faculty ORDER BY F_name ASC");

// ปิดการเชื่อมต่อเมื่อจบการทำงานทั้งหมด
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มเพิ่มข้อมูลนิสิต</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 700px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white text-center rounded-top-3">
            <h4 class="mb-0">ฟอร์มเพิ่มข้อมูลนิสิต</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="s_id" class="form-label">รหัสนิสิต</label>
                    <input type="text" class="form-control rounded-pill" id="s_id" name="s_id" required>
                </div>
                <div class="mb-3">
                    <label for="s_name" class="form-label">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control rounded-pill" id="s_name" name="s_name" required>
                </div>
                <div class="mb-3">
                    <label for="s_address" class="form-label">ที่อยู่</label>
                    <textarea class="form-control rounded-4" id="s_address" name="s_address" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="s_gpax" class="form-label">เกรดเฉลี่ย (GPAX)</label>
                    <input type="number" step="0.01" min="0" max="4.00" class="form-control rounded-pill" id="s_gpax" name="s_gpax" required>
                </div>
                <div class="mb-3">
                    <label for="f_id" class="form-label">คณะ</label>
                    <select class="form-select rounded-pill" id="f_id" name="f_id" required>
                        <option value="">-- เลือกคณะ --</option>
                        <?php
                        if ($faculty_result->num_rows > 0) {
                            while($row = $faculty_result->fetch_assoc()) {
                                if (!empty($row["F_name"])) {
                                    echo "<option value='" . $row["f_id"] . "'>" . $row["F_name"] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center text-muted bg-light rounded-bottom-3">
            ฟอร์มบันทึกข้อมูลนิสิต มหาวิทยาลัยมหาสารคาม
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
