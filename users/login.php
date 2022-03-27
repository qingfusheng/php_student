<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>login</title>
    <style type="text/css">
    body {
		margin: 0;
		padding: 0;
		font-family: sans-serif;
		background: url("/users/bg.gif") 50% 0 no-repeat fixed;
		background-size: cover;
	}

	.users_login {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		width: 400px;
		padding: 40px;
		background: rgba(0, 0, 0, .8);
		box-sizing: border-box;
		box-shadow: 0 15px 25px rgba(0, 0, 0, .5);
		border-radius: 10px;
		opacity: 0.4;
	}
	.users_login h2 {
		margin: 0 0 30px;
		padding: 0;
		color: #fff;
		text-align: center;
	}

	.users_login .inputBox {
		position: relative;
	}
	.users_login .inputBox input {
    	width: 100%;
		padding: 10px 0;
		font-size: 16px;
		color: #fff;
		letter-spacing: 1px;
		margin-bottom: 30px;
		border: none;
		border-bottom: 1px solid #fff;
		outline: none;
		background: transparent;
	}

	.users_login .inputBox label {
		position: absolute;
		top: 0;
		left: 0;
		padding: 10px 0;
		letter-spacing: 1px;
		font-size: 16px;
		color: #fff;
		pointer-events: none;
		transition: .5s;
	}

	.users_login .inputBox input:focus~label,
	.users_login .inputBox input:valid~label {
		top: -18px;
		left: 0;
		color: #03a9f4;
		font-size: 12px;
	}

	.users_login input[type="submit"] {
		background: transparent;
		border: none;
		outline: none;
		color: #fff;
		background: #03a9f4;
		padding: 10px 20px;
		cursor: pointer;
		border-radius: 5px;
	}
    .login_header{
        text-align:center;
        margin-top:150px;
    }
    .login_header>h1{
        color:white;
        font-family: "宋体";
        font-size:40px;
    }
    </style>
    
  </head>
  <body>
    <div class="login_header"><h1>Student-Course Management System</h1></div>
    <div class="users_login">
      <form name="login_form" action="/users/login.php" method="post">
        <div class="inputBox">
          <input id="username_input" type="text" name="username" required="required">
          <label>Username</label>
        </div>
        <div class="inputBox">
          <input id="password_input" type="password" name="password" required="required">
          <label>password</label>
        </div>
        <input type="submit" name="submit" value="Submit">
      </form>
      <script type="text/javascript">
        document.getElementsByTagName("input")[0].value = "test";
        document.getElementsByTagName("input")[1].value = "123456";
    </script>
    </div>
  </body>
</html>
<?php
    include_once("../student/database/database.php");
?>
<?php
    if($_POST["username"]){
        $username = addslashes($_POST["username"]);
        $password = addslashes($_POST["password"]);
        $login_confirm_sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
        $SqlResult = mysqli_query($serverLink, $login_confirm_sql);
        if(mysqli_num_rows($SqlResult)>0){
            echo "<script>alert('用户名和密码输入正确，登录成功！')</script>";
            echo "<script>document.location.href='/'</script>";
        }else{
            echo "<script>alert('用户名或密码输入错误，登录失败！')</script>";
            echo "<script>document.location.href='/users/login.php';</script>";
        }
    }
?>