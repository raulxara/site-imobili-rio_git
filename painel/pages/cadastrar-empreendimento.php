<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-warehouse"></i> Cadastrar Empreendimento</h2>

	<?php
			if(isset($_POST['acao'])){

				$nome = $_POST['nome'];
				$tipo = $_POST['tipo'];
				$preco = $_POST['preco'];
				$imagem = $_FILES['imagem'];

				if($_FILES['imagem']['name'] == ''){
					Painel::alert('erro','Você precisa selecionar uma imagem.');
				}else{

					//Imagem é válida?
					if(!(Painel::imagemValida($imagem))){
						Painel::alert('erro','Ops. Imagem inválida :(');
					}else{
						//Realizar cadastro e upload.
						$idImagem = Painel::uploadFile($imagem);
						$slug = Painel::generateSlug($nome);
						$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.empreendimentos` VALUES (null,?,?,?,?,?,?)");
						$sql->execute(array($nome,$tipo,$preco,$idImagem,$slug,0));
						$lastId = MySql::conectar()->lastInsertId();
						MySql::conectar()->exec("UPDATE `tb_admin.empreendimentos` SET order_id = $lastId WHERE id = $lastId");
						Painel::alert('sucesso','Cadastro do empreendimento foi feito com sucesso!');
					}
				}
			}
		?>

	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Nome:</label>
			<input required type="text" name="nome">
		</div>
		<div class="form-group">
			<label>Tipo:</label>
			<select name="tipo">
				<option value="residencial">Residencial</option>
				<option value="comercial">Comercial</option>
			</select>
		</div>
		<div class="form-group">
			<label>Preço:</label>
			<input type="text" name="preco">
		</div>
		<div class="form-group">
			<label>Imagem:</label>
			<input multiple type="file" name="imagem">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Adicionar">
		</div>
	</form>

</div>