<?php
include 'connectdb.php'; // เชื่อมต่อฐานข้อมูล

// ฟังก์ชันเพิ่มข้อมูลนิสิต
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s_id = $_POST['s_id'];
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_gpax = $_POST['s_gpax'];
    $f_id = $_POST['f_id'];

    $stmt = $conn->prepare("INSERT INTO student (s_id, s_name, s_address, s_gpax, f_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdi", $s_id, $s_name, $s_address, $s_gpax, $f_id);

    if ($stmt->execute()) {
        $success = "เพิ่มข้อมูลเรียบร้อยแล้ว";
    } else {
        $error = "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
}

// ดึงข้อมูลคณะ
$faculties = [];
$result = $conn->query("SELECT * FROM faculty WHERE F_name != ''");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faculties[] = $row;
    }
}

$conn->close();
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>เพิ่มข้อมูลนิสิต</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">ฟอร์มเพิ่มข้อมูลนิสิต</h4>
        </div>
        <div class="card-body">

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="s_id" class="form-label">รหัสนิสิต</label>
                    <input type="text" class="form-control" id="s_id" name="s_id" required>
                </div>
                <div class="mb-3">
                    <label for="s_name" class="form-label">ชื่อนิสิต</label>
                    <input type="text" class="form-control" id="s_name" name="s_name" required>
                </div>
                <div class="mb-3">
                    <label for="s_address" class="form-label">ที่อยู่</label>
                    <textarea class="form-control" id="s_address" name="s_address" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="s_gpax" class="form-label">GPAX</label>
                    <input type="number" step="0.01" min="0" max="4" class="form-control" id="s_gpax" name="s_gpax" required>
                </div>
                <div class="mb-3">
                    <label for="f_id" class="form-label">คณะ</label>
                    <select class="form-select" id="f_id" name="f_id" required>
                        <option value="">-- เลือกคณะ --</option>
                        <?php foreach ($faculties as $faculty): ?>
                            <option value="<?= $faculty['f_id'] ?>"><?= $faculty['F_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">บันทึก</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>
