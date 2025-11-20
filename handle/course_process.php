<?php
require_once __DIR__ . '/../functions/course_functions.php';

/**
 * Xác định hành động
 */
$action = $_GET['action'] ?? $_POST['action'] ?? '';

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
    default:
        // Không làm gì nếu không có action
        break;
}

/**
 * Lấy tất cả danh sách khóa học
 */
function handleGetAllCourses()
{
    $keyword = $_GET['keyword'] ?? '';
    $minPrice = 0;
    $maxPrice = 0;

    if (!empty($_GET['priceRange'])) {
        list($min, $max) = explode('-', $_GET['priceRange']);
        $minPrice = floatval($min);
        $maxPrice = floatval($max);

        // Nếu max = 0 (trên 1 triệu), không giới hạn trên
        if ($maxPrice == 0) {
            $maxPrice = 0;
        }
    }

    return getAllCourses($keyword, $minPrice, $maxPrice);
}


/**
 * Lấy khóa học theo ID
 */
function handleGetCourseById($id)
{
    return getCourseById($id);
}

/**
 *  Lấy danh sách khóa học phổ biến (nhiều lượt đăng ký nhất)
 */
function handleGetPopularCourses($limit = 3)
{
    require __DIR__ . '/../database/db_connect.php';

    $sql = "
        SELECT c.*, COUNT(e.course_id) AS enroll_count
        FROM courses c
        LEFT JOIN enrollments e ON c.id = e.course_id
        GROUP BY c.id
        ORDER BY enroll_count DESC
        LIMIT ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    return $courses;
}

/**
 * Xử lý tạo khóa học mới
 */
function handleCreateCourse()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/admin/manage_courses.php?error=Phương thức không hợp lệ");
        exit();
    }

    $fields = ['title', 'description', 'teacher', 'price', 'image'];
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            header("Location: ../views/admin/create_course.php?error=Thiếu thông tin $field");
            exit();
        }
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher = trim($_POST['teacher']);
    $price = floatval($_POST['price']);
    $image = trim($_POST['image']);

    if (empty($title) || empty($teacher)) {
        header("Location: ../views/admin/create_course.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    $result = addCourse($title, $description, $teacher, $price, $image);

    if ($result) {
        header("Location: ../views/admin/manage_courses.php?success=Thêm khóa học thành công");
    } else {
        header("Location: ../views/admin/create_course.php?error=Có lỗi xảy ra khi thêm khóa học");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa khóa học
 */
function handleEditCourse()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/admin/manage_courses.php?error=Phương thức không hợp lệ");
        exit();
    }

    $required = ['id', 'title', 'description', 'teacher', 'price', 'image'];
    foreach ($required as $r) {
        if (empty($_POST[$r])) {
            header("Location: ../views/admin/manage_courses.php?error=Thiếu thông tin $r");
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
        header("Location: ../views/admin/edit_course.php?id=$id&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    $result = updateCourse($id, $title, $description, $teacher, $price, $image);

    if ($result) {
        header("Location: ../views/admin/manage_courses.php?success=Cập nhật khóa học thành công");
    } else {
        header("Location: ../views/admin/edit_course.php?id=$id&error=Cập nhật khóa học thất bại");
    }
    exit();
}

/**
 * Xử lý xóa khóa học
 */
function handleDeleteCourse()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/admin/manage_courses.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: ../views/admin/manage_courses.php?error=ID khóa học không hợp lệ");
        exit();
    }

    $id = intval($_GET['id']);
    $result = deleteCourse($id);

    if ($result) {
        header("Location: ../views/admin/manage_courses.php?success=Xóa khóa học thành công");
    } else {
        header("Location: ../views/admin/manage_courses.php?error=Xóa khóa học thất bại");
    }
    exit();
}
?>