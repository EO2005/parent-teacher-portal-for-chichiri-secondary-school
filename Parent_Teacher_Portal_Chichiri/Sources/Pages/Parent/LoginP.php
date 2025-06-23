<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent | Login</title>
    <link rel="stylesheet" href="../Styles/StyleMobile.css">
</head>
<body class="Login">
    <img src="../../../Assets/Images/chichiri.png" alt="">
    <br>
    <h1>Parent Portal</h1>
    <br>
    <form action="Login.php" method="post">
        <input type="text" name="parent_id" required placeholder="Student ID">
        <br>
        <br>
        <input type="password" name="password" required placeholder="Password">
        <br>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>