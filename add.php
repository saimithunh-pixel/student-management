
<?php
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    if ($name === "" || $course === "" ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter valid student details.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO students
             (name, email, course, phone)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $course,
            $phone
        );

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Unable to add student. Check whether the email already exists.";
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

    <title>Add Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container mt-5">

    <div class="card p-4 shadow-sm">

        <h2 class="mb-4">Add New Student</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Student Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Course</label>
                <input type="text"
                       name="course"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel"
                       name="phone"
                       class="form-control">
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Save Student
            </button>

            <a href="index.php"
               class="btn btn-secondary">
                Back
            </a>

        </form>

    </div>

</div>

</body>
</html>
