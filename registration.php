<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php include "includes/functions.php" ?>

<?php 
    if(isset($_POST['submit'])){
        $firstname = escape($_POST['firstname']);
        $lastname = escape($_POST['lastname']);
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $password = escape($_POST['password']);

        if(!empty($username) && !empty($email) && !empty($password)){
            $username = mysqli_escape_string($connection, $username);
            $email = mysqli_escape_string($connection, $email);
            $password = mysqli_escape_string($connection, $password);

            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

            // $query = "SELECT randSalt FROM users";
            // $select_randsalt_query = mysqli_query($connection, $query);

            // if(!$select_randsalt_query){
            //     die('query failed' . mysqli_error($connection));
            // }

             // $row = mysqli_fetch_assoc($select_randsalt_query);
             // $salt = $row['randSalt'];
             // $password = crypt($password, $salt);

            $query = "INSERT INTO users (username, user_firstname, user_lastname, user_email, user_password, user_role) ";
            $query .= "VALUES('{$username}', '{$firstname}', '{$lastname}', '{$email}','{$password}', 'subscriber')";
            $register_user_query = mysqli_query($connection, $query);
            if(!$register_user_query){
                die('query failed' . mysqli_error($connection));
            }else{
                header('Location: index.php');
            }
        }
    }
?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Your First Name">
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Your Last Name">
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
