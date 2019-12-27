<?php 

    /*
        You Can Add | Edit | Remove Members From Here
    */

    session_start();
    if (isset($_SESSION['userName'])) {
        include 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') { 
            // Select all user except Admin
            $stmt = $con->prepare("SELECT * FROM users WHERE group_id != 1");   
            $stmt->execute();
            $rows = $stmt->fetchAll();?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive rounded-top">
                    <table class="table main-table text-center">
                        <tr>
                            <td>ID</td>
                            <td>User Name</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registered Date</td>
                            <td>Control</td>
                        </tr>
                        <?php foreach ($rows as $row) {
                            echo '<tr>';
                                echo '<td>' . $row['user_id'] . '</td>';
                                echo '<td>' . $row['user_name'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>' . $row['full_name'] . '</td>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>
                                        <a href="members.php?do=Edit&userId=' . $row['user_id'] . '" class="btn btn-outline-info btn-sm mr-1"><i class="fa fa-edit pr-1"></i>Edit</a>
                                        <a href="members.php?do=Delete&userId=' . $row['user_id'] . '" class="btn btn-outline-danger btn-sm  confirm"><i class="fa fa-times pr-1"></i>Delete</a>
                                      </td>';
                            echo '</tr>';
                        }?>
                    </table>
                </div>
                <a href="members.php?do=Add" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Add New Member</a>
            </div>

        <?php
        } elseif ($do == 'Add'){?>
            <h1 class="text-center">Add Member</h1>
            <div class="container">
                <form action="?do=Insert" method="POST">
                    <div class="form-group row">
                        <lable for="userName" class="col-sm-2 offset-md-2 col-form-label">User Name</lable>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="userName" class="form-control" autocomplete="off" placeholder=" Obada" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <lable for="password" class="col-sm-2 offset-md-2 col-form-label">Password</lable>
                        <div class="col-sm-10 col-md-6">
                            <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder=" Aa#123" required>
                            <i class="show-pass fa fa-eye fa-2x"></i>
                        </div>
                    </div>
                    <div class="form-group row">
                        <lable for="email" class="col-sm-2 offset-md-2 col-form-label">Email</lable>
                        <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" class="form-control" placeholder=" obada@email.com" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <lable for="fullName" class="col-sm-2 offset-md-2 col-form-label">Full Name</lable>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="fullName" class="form-control" placeholder=" Obada Al Dakkak" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 col-md-6 offset-sm-2 offset-md-4">
                            <input type="submit" value="Add" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div><?php
        } elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<h1 class="text-center">Add Member</h1>';
                echo '<div class="container">';

                
                $userName = $_POST['userName'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $fullName = $_POST['fullName'];

                $hashPass = sha1($_POST['Password']);

                //Validate Form Data
                $formErrors = array();
                if (empty($userName)) { $formErrors[] = 'User name can\'t be empty'; }
                if (empty($password)) { $formErrors[] = 'Password can\'t be empty'; }
                if (empty($email)) { $formErrors[] = 'Email can\'t be empty'; }
                if (empty($fullName)) { $formErrors[] = 'Full name can\'t be empty'; }

                foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                //Update Database
                if (empty($formErrors)) {
                    // Is user unique
                    if (checkItem('users', 'user_name', $userName) == 0) {
                        $stmt = $con->prepare("INSERT INTO users(user_name,password,email,full_name, date)
                                VALUES(:userName, :hashPass, :email, :fullName, now())");
                        $stmt->execute(array(
                            'userName' => $userName,
                            'hashPass' => $hashPass,
                            'email' => $email,
                            'fullName' => $fullName,
                        ));
                        $message = '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record<small>(s)</small> Inserted</div>';
                        redirectHome($message, 'back');
                    } else {
                        $message = '<div class="alert alert-danger">Please choose another name</div>';
                        redirectHome($message, 'back');
                    }
                }
                echo '</div>';
            } else {
                echo '<div class=""container>';
                $message = '<div class="alert alert-danger">You Can\'t Browse This Page</div>';
                redirectHome($message, 'back');
                echo '</div>';
            }
            
        } elseif ($do == 'Edit') {
            $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0 ; 
            $stmt = $con->prepare("SELECT * FROM users 
                                   WHERE user_id = ?
                                   LIMIT 1");
            $stmt->execute(array($userId));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) { ?>
                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form action="?do=Update" method="POST">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <div class="form-group row">
                            <lable for="userName" class="col-sm-2 offset-md-2 col-form-label">User Name</lable>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="userName" class="form-control" value="<?php echo $row['user_name']; ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <lable for="newPass" class="col-sm-2 offset-md-2 col-form-label">Password</lable>
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden" name="oldPass" value="<?php echo $row['password']; ?>">
                                <input type="password" name="newPass" class="form-control" autocomplete="new-password" placeholder="Keep old password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <lable for="email" class="col-sm-2 offset-md-2 col-form-label">Email</lable>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <lable for="fullName" class="col-sm-2 offset-md-2 col-form-label">Full Name</lable>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="fullName" class="form-control" value="<?php echo $row['full_name']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 col-md-6 offset-sm-2 offset-md-4">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            <?php 
            } else {
                echo '<div class="container">';
                $message = '<div class="alert alert-danger">There\'s no such ID</div>';
                redirectHome($message);
                echo '</div>';
            }
             
        } elseif ($do == 'Update') {
            echo '<h1 class="text-center">Update Member</h1>';
            echo '<div class="container">';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['userId'];
                $userName = $_POST['userName'];
                $email = $_POST['email'];
                $fullName = $_POST['fullName'];
                $password = empty($_POST['newPass']) ? $_POST['oldPass'] : sha1($_POST['newPass']);

                //Validate Form Data
                $formErrors = array();
                if (empty($userName)) { $formErrors[] = 'User name can\'t be empty'; }
                if (empty($fullName)) { $formErrors[] = 'Full name can\'t be empty'; }
                if (empty($email)) { $formErrors[] = 'Email can\'t be empty'; }

                foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                //Update Database
                if (empty($formErrors)) {
                    $stmt = $con->prepare("UPDATE users SET user_name = ?, email = ?, full_name = ?, password = ? WHERE user_id = ?");
                    $stmt->execute(array($userName,$email,$fullName,$password,$id));
                }
                
                $message = '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record<small>(s)</small> Updated</div>';
                redirectHome($message, 'back');
            } else {
                $message = '<div class="alert alert-danger">You Can\'t Browse This Page</div>';
                redirectHome($message);
            }
            echo '</div>';
        } elseif ($do == 'Delete')
        {
            echo '<h1 class="text-center">Delete Member</h1>';
            echo '<div class="container">';
                $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0 ;
                if (checkItem('users', 'user_id', $userId) > 0) {
                    $stmt = $con->prepare("DELETE FROM users WHERE user_id = :userId");
                    $stmt->bindParam(":userId", $userId);
                    $stmt->execute();
                    $message = '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record<small>(s)</small> Deleted</div>';
                    redirectHome($message);
                } else {
                    $message = '<div class="alert alert-danger">ID isn\'t exist</div>';
                    redirectHome($message);
                }
            echo '</div>';
        }

        include $tp1 . 'footer.php';
    }
    else {
        header('Location: index.php');
        exit();
    }