<html>

<body>
<form action="Login.php" method="post">
    User Name:<br>
    <input type="text" name="username" required><br><br>
    Password:<br>
    <input type="password" name="password" required><br><br>
    <input type="submit" name="submit" value="Login">
    <input type="submit" name="submit" value="Create">
    <input type="submit" name="submit" value="Validate">

</form>
<?php
    session_start();
    if (isset($_SESSION['ret'])){
        $ret = $_SESSION['ret'];
        unset($_SESSION['ret']);
        echo $ret['mess'];
    }
?>

</body>

</html>