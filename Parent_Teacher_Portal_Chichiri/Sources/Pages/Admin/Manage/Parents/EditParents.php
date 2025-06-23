<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "parent_teacher_portal_chichiri";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!isset($_GET["parent_id"])) {
            header('location: manageclass.php');
            exit;
        }
    
        $parent_id = $_GET['parent_id'];
        $sql = "SELECT * FROM parents WHERE parent_id = '$parent_id'";
        $result = $connection->query($sql);
    
        // Check if the query was successful and if any rows were fetched
        if (!$result || $result->num_rows == 0) {
            header('location: manageSubject.php');
            exit;
        }
    
        // Fetch the parent's information
        $row = $result->fetch_assoc();
        $parent_id = $row['parent_id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $password = $row['password'];
        $phone_number = $row['phone_number'];
        $email_address = $row['email_address'];
        $address = $row['address'];
    }else {
        $parent_id = $_POST['parent_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];
        $email_address = $_POST['email_address'];
        $address = $_POST['address'];
        
        // Validate input and perform the update
        if (empty($parent_id) || empty($first_name) || empty($last_name) || empty($password) || empty($phone_number) || empty($email_address) || empty($address)) {
            $errorMessage = "All the fields are required";
        } else {
            // Use prepared statement to prevent SQL injection
            $stmt = $connection->prepare("UPDATE parents SET first_name=?, last_name=?, password=?, phone_number=?, email_address=?, address=? WHERE parent_id=?");
            if (!$stmt) {
                $errorMessage = "Prepare failed: " . $connection->error;
            } else {
                $stmt->bind_param("sssssss", $first_name, $last_name, $password, $phone_number, $email_address, $address, $parent_id);
    
                if ($stmt->execute()) {
                    $successMessage = "Parent Updated Successfully";
                } else {
                    $errorMessage = "Update failed: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Parents</title>
    <link rel="stylesheet" href="../../../Styles/Style.css">
    <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
<header>
        <img src="../../../../../Assets/Images/chichiri.png" alt="">
        <h1>Admin | Manage Parents</h1>
    </header>
        <nav>
        <a href="../../Dashboard.php"><img src="../../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
        <a href="../Manage.php"><img src="../../../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
        <a href="../"><img src="../../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../../../Login.html">Logout</a>
    </nav>
    <main class="form">
    <form action="" method="post">
        <h1>Edit Parents</h1>
        <br>
        <input type="text" name="parent_id" value="<?php echo $parent_id;?>" placeholder="Parent ID" required >
        <br>
        <input type="text" name="first_name" value="<?php echo $first_name;?>" placeholder="First Name" required>
        <br>
        <input type="text" name="last_name" value="<?php echo $last_name;?>" placeholder="Last Name" required>
        <br>
        <input type="password" name="password" value="<?php echo $password;?>" placeholder="Password" required>
        <br>
        <input type="text" name="phone_number" value="<?php echo $phone_number;?>" placeholder="Phone Number" required>
        <br>
        <input type="text" name="email_address" value="<?php echo $email_address;?>" placeholder="Email Address" required>
        <br>
        <input type="text" name="address" value="<?php echo $address;?>" placeholder="Home Address" required>
        <br>
        <input type="submit" value="Edit Parent">
        <a href="viewParents.php">Back</a>
    </form>
    </main>
</body>
</html>