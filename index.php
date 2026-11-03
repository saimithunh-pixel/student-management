
<?php
require_once "db.php";

$result = $conn->query(
    "SELECT * FROM students ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Student Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            Student Management System
        </a>
    </div>
</nav>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h2>Student Records</h2>

        <a href="add.php" class="btn btn-success">
            + Add Student
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php while ($row = $result->fetch_assoc()): ?>

                <tr>
                    <td><?= (int)$row['id'] ?></td>

                    <td>
                        <?= htmlspecialchars($row['name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['course']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['phone'] ?? '') ?>
                    </td>

                    <td>
                        <a href="edit.php?id=<?= (int)$row['id'] ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="delete.php"
                              method="POST"
                              class="d-inline delete-form">

                            <input type="hidden"
                                   name="id"
                                   value="<?= (int)$row['id'] ?>">

                            <button type="submit"
                                    class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

            <?php endwhile; ?>

            </tbody>
        </table>
    </div>

</div>

<script src="js/script.js"></script>

</body>
</html>
