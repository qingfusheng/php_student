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
	.login_or_register{
		height:100px;
	}
	.login_register>input{
		outline:none;

	}
	.login_button{
		float:left;
		width:50%;
		height:50%;
	}
	.register_button{
		float:right;
		width:50%;
		height:50%;
	}
	
    </style>
	<script type="text/javascript">
		function switch_to(in_type){
			switch(in_type){
				case "login":
				register_form.style.display="none";
				login_form.style.display="block";
				document.getElementById("register_username").value="";
				document.getElementById("register_password").value="";
				document.getElementsByTagName("h2")[0].textContent="登录";
				break;
				case "register":
				login_form.style.display="none";
				register_form.style.display="block";
				document.getElementById("username_input").value = "";
				document.getElementById("password_input").value = "";
				document.getElementsByTagName("h2")[0].textContent="注册";
				break;
				default:break;
			}
		}
	</script>
    
  </head>
  <body>
    <div class="login_header">
		<h1>Student-Course Management System</h1>
		<h2 style="color:white;">登录</h2>
	</div>
    <div class="users_login">
		<div class="login_or_register">
			<input type="button" class='login_button' value="登录" onclick="switch_to('login')">
			<input type="button" class="register_button" value="注册" onclick="switch_to('register')">
		</div>
      <form name="login_form" action="/users/login.php" method="post">
        <div class="inputBox">
          <input id="username_input" type="text" name="username" required="required">
          <label>Username</label>
        </div>
        <div class="inputBox">
          <input id="password_input" type="password" name="password" required="required">
          <label>password</label>
        </div>
		<script type="text/javascript">
        	/*document.getElementById("username_input").value = "test";
        	document.getElementById("password_input").value = "123456";*/
    	</script>
        <input type="submit" name="submit" value="Submit">
      </form>
	  <form name="register_form" action="/users/login.php" method="post"style="display:none;">
        <div class="inputBox">
          <input id="register_username" type="text" name="register_username" required="required">
          <label>Username</label>
        </div>
        <div class="inputBox">
          <input id="register_password" type="password" name="register_password" required="required">
          <label>password</label>
        </div>
        <input type="submit" name="submit" value="Submit">
      </form>
      
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
<?php
if($_POST["register_username"]){
    
    $username = $_POST["register_username"];
    $password = $_POST["register_password"];
    echo "<script>alert('$password')</script>";
    $select_username_sql = "SELECT username from users WHERE username='$username'";
    $select_username_sql_result = mysqli_query($serverLink, $select_username_sql) or die("<script>alert('第一次用户插入失败');</script>");
    if(mysqli_num_rows($select_username_sql_result)==0){
        $insert_user_sql = "INSERT INTO users VALUES(null, '$username', '$password')";
        $insert_sql_result = mysqli_query($serverLink, $insert_user_sql) or die("<script>alert('第二处添加新用户失败');</script>");
        echo "<script>alert('添加新用户成功，请使用该账户登录');document.location.href='/users/login.php';</script>";
    }else{
        echo "<script>alert('该用户名已被注册')</script>";
        echo "<script>document.location.href='/users/register.php';</script>";
    }
}
?>