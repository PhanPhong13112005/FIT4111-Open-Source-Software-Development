<?php
require_once __DIR__ . '/../functions/course_functions.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateCourse();
        break;
    case 'edit':
        handleEditCourse();
        break;
    case 'delete':
        handleDeleteCourse();
        break;
    // default:
    //     header("Location: ../views/course.php?error=Hành động không hợp lệ");
    //     exit();
}

/**
 * Lấy tất cả danh sách khóa học
 */
function handleGetAllCourses() {
    return getAllCourses();
}

function handleGetCourseById($id) {
    return getCourseById($id);
}

/**
 * Xử lý tạo khóa học mới
 */
function handleCreateCourse() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/course.php?error=Phương thức không hợp lệ");
        exit();
    }

    // Kiểm tra dữ liệu
    $fields = ['title', 'description', 'teacher', 'price', 'image'];
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            header("Location: ../views/course/create_course.php?error=Thiếu thông tin $field");
            exit();
        }
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher = trim($_POST['teacher']);
    $price = floatval($_POST['price']);
    $image = trim($_POST['image']);

    if (empty($title) || empty($teacher)) {
        header("Location: ../views/course/create_course.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm
    $result = addCourse($title, $description, $teacher, $price, $image);

    if ($result) {
        header("Location: ../views/course.php?success=Thêm khóa học thành công");
    } else {
        header("Location: ../views/course/create_course.php?error=Có lỗi xảy ra khi thêm khóa học");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa khóa học
 */
function handleEditCourse() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/course.php?error=Phương thức không hợp lệ");
        exit();
    }

    $required = ['id', 'title', 'description', 'teacher', 'price', 'image'];
    foreach ($required as $r) {
        if (!isset($_POST[$r])) {
            header("Location: ../views/course.php?error=Thiếu thông tin $r");
            exit();
        }
    }

    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher = trim($_POST['teacher']);
    $price = floatval($_POST['price']);
    $image = trim($_POST['image']);

    if (empty($title) || empty($teacher)) {
        header("Location: ../views/course/edit_course.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    $result = updateCourse($id, $title, $description, $teacher, $price, $image);

    if ($result) {
        header("Location: ../views/course.php?success=Cập nhật khóa học thành công");
    } else {
        header("Location: ../views/course/edit_course.php?id=" . $id . "&error=Cập nhật khóa học thất bại");
    }
    exit();
}

/**
 * Xử lý xóa khóa học
 */
function handleDeleteCourse() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/course.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/course.php?error=Không tìm thấy ID khóa học");
        exit();
    }

    $id = $_GET['id'];
    if (!is_numeric($id)) {
        header("Location: ../views/course.php?error=ID khóa học không hợp lệ");
        exit();
    }

    $result = deleteCourse($id);

    if ($result) {
        header("Location: ../views/course.php?success=Xóa khóa học thành công");
    } else {
        header("Location: ../views/course.php?error=Xóa khóa học thất bại");
    }
    exit();
}
?>
