<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
</head>
<body>
    <div>
        <h2>Insert User</h2>
        <form action="" method="POST">
            <input type="text" name="firstname" placeholder="Firstname"> <br><br>
            <input type="text" name="lastname" placeholder="Lastname"> <br><br>
            <input type="checkbox" name="is_admin"> Is Admin <br><br>
            <input type="submit" name="save_btn" value="Save">
        </form>
    </div>


    <?php
    include 'Connection.php';
    if (isset($_POST['save_btn'])) {
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $admin = isset($_POST['is_admin']) ? 1 : 0;


        if (empty($fname) || empty($lname)) {
            echo "Please fill in all fields.";
        } else {
            $query = "INSERT INTO users (firstname, lastname, is_admin) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ssi', $fname, $lname, $admin);
            mysqli_stmt_execute($stmt);


            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>alert('Data Saved Successfully');</script>";
            } else {
                echo "<script>alert('Please try again');</script>";
            }
        }
    }

    echo "<h2>All Users</h2>";
    $query = "SELECT id FROM users";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>
                ID: {$row['id']} <br>
                <a href='index.php?id={$row['id']}'>View</a> |
                <a href='index.php?update_id={$row['id']}'>Update</a> |
                <a href='index.php?delete_id={$row['id']}'>Delete</a>
                </p>";
        }
    } else {
        echo "No users found.";
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);


        if ($row = mysqli_fetch_assoc($result)) {
            echo "<h2>User Details</h2>
            <p>
                ID: {$row["id"]} <br>
                Firstname: {$row["firstname"]} <br>
                Lastname: {$row["lastname"]} <br>
                Is Admin: " . ($row["is_admin"] ? "Yes" : "No") . "
            </p>";
        } else {
            echo "User not found.";
        }
    }

    if (isset($_GET['update_id'])) {
        $id = $_GET['update_id'];
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);


        if ($row = mysqli_fetch_assoc($result)) {
            echo "<h2>Update User</h2>
            <form action='' method='POST'>
                <input type='hidden' name='id' value='{$id}'>
                <input type='text' name='firstname' value='{$row["firstname"]}'> <br><br>
                <input type='text' name='lastname' value='{$row["lastname"]}'> <br><br>
                <input type='checkbox' name='is_admin' " . ($row["is_admin"] ? "checked" : "") . "> Is Admin <br><br>
                <input type='submit' name='update_btn' value='Update'>
            </form>";
        } else {
            echo "User not found.";
        }
    }


    if (isset($_POST['update_btn'])) {
        $id = $_POST['id'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $admin = isset($_POST['is_admin']) ? 1 : 0;


        if (empty($fname) || empty($lname)) {
            echo "Please fill in all fields.";
        } else {
            $query = "UPDATE users SET firstname = ?, lastname = ?, is_admin = ? WHERE id = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ssii', $fname, $lname, $admin, $id);
            mysqli_stmt_execute($stmt);


            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>alert('Data Updated Successfully');</script>";
            } else {
                echo "<script>alert('Please try again');</script>";
            }
        }
    }

    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);


        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<script>alert('User deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting user');</script>";
        }
    }
    ?>
</body>
</html>
