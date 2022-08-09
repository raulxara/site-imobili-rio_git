<?php
	verificaPermissaoPagina(2);
?>
<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-user-plus"></i> Adicionar Usuário</h2>

	<form method="post" enctype="multipart/form-data">

		<?php
			if(isset($_POST['acao'])){
				$login = $_POST['login'];
				$nome = $_POST['nome'];
				$senha = $_POST['password'];
				$imagem = $_FILES['imagem'];
				$cargo = $_POST['cargo'];

				if($login == ''){
					Painel::alert('erro','O login está vázio!');
				}else if($nome == ''){
					Painel::alert('erro','O nome está vázio!');
				}else if($senha == ''){
					Painel::alert('erro','A senha está vázia!');
				}else if($cargo == ''){
					Painel::alert('erro','O cargo precisa estar selecionado!');
				}else if($imagem['name'] == ''){
					Painel::alert('erro','A imagem precisa estar selecionada!');
				}else{
					//Podemos cadastrar!
					if($cargo > $_SESSION['cargo']){
						Painel::alert('erro','Você precisa selecionar um cargo menor que o seu!');
					}else if(Painel::imagemValida($imagem) == false){
						Painel::alert('erro','O formato especificado não está correto!');
					}else if(Painel::senhaForte($senha) == false){
						Painel::alert('erro','Sua senha precisa conter ao menos 1 letra maiúscula, 1 letra normal e 1');
					}else if(Usuario::userExists($login)){
						Painel::alert('erro','O login já existe, selecione outro por favor!');
					}else{
						$usuario = new Usuario();
						$imagem = Painel::uploadFile($imagem);
						$usuario->cadastrarUsuario($login,$senha,$imagem,$nome,$cargo);
						Painel::alert('sucesso','O cadastro do usuário '.$login.' foi feito com sucesso!');
					}
				}


				
				
			}
		?>

		<div class="form-group">
			<label>Login:</label>
			<input type="text" name="login">
		</div>
		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome">
		</div>
		<div class="form-group">
			<label>Senha:</label>
			<input type="password" name="password">
		</div>
		<div class="form-group">
			<label>Cargo:</label>
			<select name="cargo">
				<?php
					foreach (Painel::$cargos as $key => $value) {
						if($key <= $_SESSION['cargo']) echo '<option value="'.$key.'">'.$value.'</option>';
					}
				?>
			</select>
		</div>
		<div class="form-group">
			<label>Imagem:</label>
			<input type="file" name="imagem">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Adicionar">
		</div>
		
	</form>
</div>
