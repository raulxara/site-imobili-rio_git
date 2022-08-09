<?php
	if(isset($_COOKIE['lembrar'])){
		$user = $_COOKIE['user'];
		$password = $_COOKIE['password'];
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
		$sql->execute(array($user,$password));
		if($sql->rowCount() == 1){
				$info = $sql->fetch();
				$_SESSION['login'] = true;
				$_SESSION['user'] = $user;
				$_SESSION['id_user'] = $info['id'];
				$_SESSION['password'] = $password;
				$_SESSION['cargo'] = $info['cargo'];
				$_SESSION['nome'] = $info['nome']; 
				$_SESSION['img'] = $info['img'];
				Painel::redirect(INCLUDE_PATH_PAINEL);
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>fonts-6/css/all.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo INCLUDE_PATH_PAINEL; ?>css/style.css" rel="stylesheet">
	<link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="image/x-icon" />
	<title>Painel de controle</title>
</head>
<body>
<div class="overlay"></div>
	<div class="box-login">
		<?php
			if(isset($_POST['acao'])){
				$user = $_POST['user'];
				$password = $_POST['password'];
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
				$sql->execute(array($user,$password));
				if($sql->rowCount() == 1){
					$info = $sql->fetch();
					$_SESSION['login'] = true;
					$_SESSION['user'] = $user;
					$_SESSION['password'] = $password;
					$_SESSION['id_user'] = $info['id'];
					$_SESSION['cargo'] = $info['cargo'];
					$_SESSION['nome'] = $info['nome']; 
					$_SESSION['img'] = $info['img'];
					if (isset($_POST['lembrar'])) {
						setcookie('lembrar',true,time()+(60*60*24),'/');
						setcookie('user',$user,time()+(60*60*24),'/');
						setcookie('password',$password,time()+(60*60*24),'/');
					}
					header('Location: '.INCLUDE_PATH_PAINEL);
					die();
				}else{
					echo '<div class="erro-box"><i class="fa fa-times"></i> Usuário ou senha incorretos.</div>';
				}
			}
		?>
		<h2><i style="padding: 0 10px;" class="fa-solid fa-database"></i>Forma Adm</h2>
		<form method="post">
			<input type="text" name="user" placeholder="Username" required>
			<input type="password" name="password" placeholder="Senha" required>
			<div class="form-group-login">
				<input type="submit" name="acao" value="Entrar">
			</div>
			<div class="form-group-login">
				<label>Lembrar-me</label>
				<input type="checkbox" name="lembrar" />
			</div>
			<div class="clear"></div>
		</form>

	</div>

</body>
</html>