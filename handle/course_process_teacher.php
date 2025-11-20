<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../functions/db_connection.php';
require_once __DIR__ . '/../functions/auth.php';

// Phần còn lại giữ nguyên


// Chỉ cho teacher
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    die("Bạn không có quyền truy cập trang này.");
}

// Lấy kết nối DB
function getDb() {
    return getDbConnection();
}

// Lấy tất cả khóa học của teacher
function getCoursesByTeacher($teacher) {
    $conn = getDb();
    $stmt = $conn->prepare("SELECT * FROM courses WHERE teacher=? ORDER BY created_at DESC");
    $stmt->bind_param("s", $teacher);
    $stmt->execute();
    $courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close(); $conn->close();
    return $courses;
}

// Lấy khóa học theo ID (chỉ của teacher)
function getCourseById($id, $teacher) {
    $conn = getDb();
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id=? AND teacher=? LIMIT 1");
    $stmt->bind_param("is", $id, $teacher);
    $stmt->execute();
    $course = $stmt->get_result()->fetch_assoc();
    $stmt->close(); $conn->close();
    return $course;
}

// Tổng học viên đăng ký
function getTotalEnrollmentsByTeacher($teacher) {
    $conn = getDb();
    $stmt = $conn->prepare("
        SELECT COUNT(e.id) AS total
        FROM enrollments e
        INNER JOIN courses c ON e.course_id=c.id
        WHERE c.teacher=?
    ");
    $stmt->bind_param("s", $teacher);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close(); $conn->close();
    return $row['total'] ?? 0;
}

// Khóa học mới nhất
function getLatestCourseTitle($teacher) {
    $conn = getDb();
    $stmt = $conn->prepare("SELECT title FROM courses WHERE teacher=? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $teacher);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close(); $conn->close();
    return $row['title'] ?? 'Chưa có khóa học';
}

// ===== CRUD =====

function handleCreateCourse() {
    $teacher = $_SESSION['username'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $imagePath = '';

    if (empty($title)) {
        header("Location: ../views/teacher/create_course.php?error=Vui lòng nhập tên khóa học"); exit;
    }

    // Upload ảnh
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/courses/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = time().'_'.basename($_FILES['thumbnail']['name']);
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir.$filename);
        $imagePath = 'uploads/courses/'.$filename;
    }

    $conn = getDb();
    $stmt = $conn->prepare("INSERT INTO courses (title, description, teacher, price, category_id, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssdis", $title, $description, $teacher, $price, $category_id, $imagePath);
    $stmt->execute();
    $stmt->close(); $conn->close();
    header("Location: ../views/teacher/manage_my_courses.php?success=Thêm khóa học thành công");
}

function handleEditCourse() {
    $teacher = $_SESSION['username'];
    $id = intval($_POST['id']);
    $course = getCourseById($id, $teacher);
    if (!$course) { header("Location: ../views/teacher/manage_my_courses.php?error=Không có quyền chỉnh sửa"); exit; }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $imagePath = $course['image'];

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/courses/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = time().'_'.basename($_FILES['thumbnail']['name']);
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir.$filename);
        if (!empty($course['image']) && file_exists(__DIR__ . '/../'.$course['image'])) unlink(__DIR__ . '/../'.$course['image']);
        $imagePath = 'uploads/courses/'.$filename;
    }

    $conn = getDb();
    $stmt = $conn->prepare("UPDATE courses SET title=?, description=?, price=?, category_id=?, image=? WHERE id=? AND teacher=?");
    $stmt->bind_param("ssdissi", $title, $description, $price, $category_id, $imagePath, $id, $teacher);
    $stmt->execute();
    $stmt->close(); $conn->close();
    header("Location: ../views/teacher/manage_my_courses.php?success=Cập nhật khóa học thành công");
}

function handleDeleteCourse() {
    $teacher = $_SESSION['username'];
    $id = intval($_GET['id']);
    $course = getCourseById($id, $teacher);
    if (!$course) { header("Location: ../views/teacher/manage_my_courses.php?error=Không có quyền xóa"); exit; }

    if (!empty($course['image']) && file_exists(__DIR__ . '/../'.$course['image'])) unlink(__DIR__ . '/../'.$course['image']);
    $conn = getDb();
    $stmt = $conn->prepare("DELETE FROM courses WHERE id=? AND teacher=?");
    $stmt->bind_param("is", $id, $teacher);
    $stmt->execute();
    $stmt->close(); $conn->close();
    header("Location: ../views/teacher/manage_my_courses.php?success=Xóa khóa học thành công");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') handleCreateCourse();
    if ($_POST['action'] === 'edit') handleEditCourse();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    handleDeleteCourse();
}