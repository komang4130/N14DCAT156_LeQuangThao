<?php
	include("header.php");
	$error = "";
	if(isset($_SESSION["is_logged"]))
	{
		header("Location: index.php");
		exit();
	}
	if ( isset($_POST["submit"]))
	{
		$username = $_POST['usn'];
		$password = $_POST['pwd'];
		if (empty($username) || empty($password) || strlen($username) > 40 || strlen($password) > 40 ) {
			# code...
			$error = "<div class='alert alert-danger' role='alert'>
  							<strong>Input error</strong>
							</div>";
			$conn->close();
		}
		else
		{
			$query_check = $conn->prepare("SELECT name,username,password,admin FROM users WHERE username=?");
			$query_check->bind_param("s",$username);
			$query_check->execute();
			$query_check->store_result();
			if ( $query_check->num_rows != 1 )
			{
				$error = "<div class='alert alert-danger' role='alert'>
  							<strong>This username is not in our database</strong>
							</div>";
				$conn->close();
			}
			else
			{
				$query_check->bind_result($name,$check_username,$check_password,$admin);
				$query_check->fetch();
				if ( password_verify($password,$check_password))
				{
					$_SESSION["is_logged"] = true;
					$_SESSION["username"] = $name;
					$_SESSION["admin"] = $admin;
					header("Location: index.php");
					$conn->close();
					exit();
				}
				else
				{
					$error = "<div class='alert alert-danger' role='alert'>
  							<strong>Username or password is invalid</strong>
							</div>";
					$conn->close();
				}
			}
		}
		
	}
?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center text-white mb-4">Bootstrap 4 Login Form</h2>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <span class="anchor" id="formLogin"></span>

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <center><h3 class="mb-0">Login</h3></center>
                        </div>
                        <div class="card-body">
                            <form  action="login.php" method="POST" class="form" role="form" autocomplete="off" id="formLogin">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="usn" placeholder="Your username ...." required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="pwd" placeholder="Your password" required>
                                </div>
                                <center><button type="submit" name="submit" class="btn btn-success">Login</button></center>
                            </form>
						<?php echo $error; ?>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->