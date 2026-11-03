
<?php
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid student ID.");
}

$stmt = $conn->prepare(
    "SELECT * FROM students WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$student = $result->fetch_assoc();

$stmt->close();

if (!$student) {
    exit("Student not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    if ($name === "" || $course === "" ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter valid details.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE students
             SET name=?, email=?, course=?, phone=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "ssssi",
            $name,
            $email,
            $course,
            $phone,
            $id
        );

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Update failed. Check whether the email is already used.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Edit Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="card p-4 shadow-sm">

        <h2>Edit Student</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label>Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="<?= htmlspecialchars($student['name']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="<?= htmlspecialchars($student['email']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Course</label>
                <input type="text"
                       name="course"
                       class="form-control"
                       value="<?= htmlspecialchars($student['course']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="tel"
                       name="phone"
                       class="form-control"
                       value="<?= htmlspecialchars($student['phone'] ?? '') ?>">
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Update Student
            </button>

            <a href="index.php"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>

</body>
</html>
