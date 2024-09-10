<?php
require "db_connect.php";

$select = "SELECT `id`, `name`, `email`, `password` FROM users";
$result = mysqli_query($conn, $select);

if (isset($_POST['delete-btn'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM users where `id` = $id";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: update.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $name = $_POST['update_name'];
    $email = $_POST['update_email'];
    $password = $_POST['update_password'];

    $update = "UPDATE users SET id='$id',name = '$name',email='$email', password='$password' where id='$id'";
    $result = mysqli_query($conn, $update);
    if ($result) {
        header("location:update.php");
        echo "Update Successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .toggle-btn {
            margin-left: -40px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container my-4">

        <a href="index.php" class="btn btn-primary">Add</a>
        <div class="border">
            <h1 class="text-center">View Details</h1>
            <hr>

            <table class="table mt-2">
                <thead class="text-center">
                    <tr>
                        <th>Sr No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    if ($result) {
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $count ++;

                            $id = $row['id'];
                            $name = $row['name'];
                            $email = $row['email'];
                            $password = $row['password'];

                            echo '
                            <tr>
                                <td>' . $count . '</td>
                                <td>' . $name . '</td>
                                <td>' . $email . '</td>
                                <td>
                                <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">
                                    <input type="hidden" name="id" value="' . $id . '">
                                    <button type="button" class="btn btn-primary" name="edit-btn" data-bs-toggle="modal" data-bs-target="#editModal' . $id . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                    <button type="submit" class="btn btn-danger" name="delete-btn"><i class="bi bi-trash3"></i> Delete</button>
                                </form>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="editModal' . $id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModal' . $id . '" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel' . $id . '">Edit ' .$name.'</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST">
                                                <div class="mb-3">
                                                    <label for="name$id" class="form-label">Your Name</label>
                                                    <input type="text" class="form-control" name="update_name" id="name' . $id . '" value="' . $name . '">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email$id" class="form-label">Email address</label>
                                                    <input type="email" class="form-control" name="update_email" id="email' . $id . '" value="' . $email . '">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password$id" class="form-label">Password</label>
                                                    <div class="d-flex">
                                                    <input type="password" class="form-control" name="update_password" id="password' . $id . '" value="' . $password . '">
                                                    <button type="button" class="btn border-0 toggle-btn" data-target="#password' . $id . '"><i class="bi bi-eye"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="update_id" value="' . $id . '">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        ';
                        }
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const passwordField = document.querySelector(button.getAttribute('data-target'));
                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        button.innerHTML = '<i class="bi bi-eye-slash"></i>';
                    } else {
                        passwordField.type = 'password';
                        button.innerHTML = '<i class="bi bi-eye"></i>';
                    }
                });
            });
        });
    </script>
</body>

</html>