<?php 
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    if (isset($_SESSION['userName'])) {
        header('Location: dashboard.php');
    }

    include "init.php";

    //Chech if The User's Coming From HTTP POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hasdPass = sha1($password);
        
        //Check If The User Exist In DB
        $stmt = $con->prepare("SELECT user_id,user_name,password FROM users 
                               WHERE user_name = ? AND password = ? AND group_id = 1
                               LIMIT 1");
        $stmt->execute(array($username,$hasdPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        //If Count > 0 => DB Found Data For The User
        if ($count > 0) {
            $_SESSION['userName'] = $username;
            $_SESSION['id'] = $row['user_id'];
            header('Location: dashboard.php');
            exit();
        }
    }
?>

    <form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <h4 class="text-center">Admin Login</h4>
        <input class="form-control input-lg" type="text" name="user" placeholder="User Name" autocomplete="off">
        <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password">
        <input class="btn btn-primary btn-block" type="submit" value="Login">
    </form>

<?php include $tp1 . 'footer.php'; ?>