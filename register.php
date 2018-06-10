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
    $name = $_POST['name'];
		if (empty($name)  ||empty($username) || empty($password) || strlen($username) > 40 || strlen($password) > 40 ) {
			# code...
			$error = "<div class='alert alert-danger' role='alert'>
  							<strong>Input error.</strong>
							</div>";
			$conn->close();
		}
		else
		{
			if ( !(preg_match("[a-z0-9]", $username) && preg_match("[a-zA-Z0-0]", $password) && preg_match("[a-zA-z ]", $name)) && (strlen($username) < 5 || strlen($password) < 5 || strlen($name) < 5) && (strlen($username) > 16 || strlen($password) > 16 || strlen($name) > 30)  )
      		{
        		$error = "<div class='alert alert-danger' role='alert'>
  							<strong>Name or Username or password is invalid</strong>
							</div>";
        		$conn->close();
      		} 
      		else
      		{
      			$query_check = $conn->prepare("SELECT username FROM users WHERE username=? ");
        		$query_check->bind_param("s",$username);
        		$query_check->execute();
        		$result = $query_check->get_result();
        		if ( $result->num_rows != 0)
        		{
          			$error = "<div class='alert alert-danger' role='alert'>
  							<strong>Username is already exist</strong>
							</div>";
          			$query_check->close();
          			$conn->close();
        		}
        		else
        		{
          			$password = password_hash($password,PASSWORD_BCRYPT);
          			$query = $conn->prepare("INSERT INTO users (name,username, password, admin) VALUES (?, ?, ?, false)");
          			$query->bind_param("sss",$name,$username,$password);
          			$query->execute();
                var_dump($query);
          			$query->close();
          			$conn->close();
          			$error = "<div class='alert alert-success' role='alert'>
  							<strong>Successfully registered. Please move to <a href='login.php'>login page</a> to login</strong>
							</div>
							";
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
                            <center><h3 class="mb-0">Register</h3></center>
                        </div>
                        <div class="card-body">
                            <form  action="register.php" method="POST" class="form" role="form" autocomplete="off" id="formLogin">
                              <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="name" placeholder="Your Name ...." required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="usn" placeholder="Your username ...." required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="pwd" placeholder="Your password" required>
                                </div>
                                <center><button type="submit" name="submit" class="btn btn-success">Register</button></center>
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