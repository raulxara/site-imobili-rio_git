<?php
	$id = (int)$_GET['id'];
	$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
	$sql->execute(array($id));
	if($sql->rowCount() == 0){
		Painel::alert('erro','O produto que você quer editar não existe.');
		die();
	}

	$infoProduto = $sql->fetch();

	$pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
	$pegaImagens->execute();
	$pegaImagens = $pegaImagens->fetchAll();

	if(isset($_GET['deletarImagem'])){
		$idImagem = $_GET['deletarImagem'];
		@unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
		MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = '$idImagem'");
		Painel::alert('sucesso','A imagem foi deletada com sucesso!');
		$pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
		$pegaImagens->execute();
		$pegaImagens = $pegaImagens->fetchAll();
	}

?>

<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-store"></i> Editando Produto: <?php echo $id; ?></h2>
	

	<div style="background: #fa8564;" class="card-title">Informações do Produto:</div>
	<form method="post" action="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $id; ?>" enctype="multipart/form-data">

		<?php
		if(isset($_POST['acao'])){
			$nome = $_POST['nome'];
			$descricao = $_POST['descricao'];
			$largura = $_POST['largura'];
			$altura = $_POST['altura'];
			$comprimento = $_POST['comprimento'];
			$peso = $_POST['peso'];
			$quantidade = $_POST['quantidade'];

			$imagens = [];

			$sucesso = true;
			$amountFiles = count($_FILES['imagem']['name']);
			if($_FILES['imagem']['name'][0] != ''){
				for($i =0; $i < $amountFiles; $i++){
					$imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
					'size'=>$_FILES['imagem']['size'][$i]];
					if(Painel::imagemValida($imagemAtual) == false){
						$sucesso = false;
						Painel::alert('erro','Uma das imagens selecionadas são inválidas!');
						break;
					}
				}
			}

			if($sucesso){
				if($_FILES['imagem']['name'][0] != ''){
					for($i =0; $i < $amountFiles; $i++){
						$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
							'name'=>$_FILES['imagem']['name'][$i]];
						$imagens[] = Painel::uploadFile($imagemAtual);
					}

					foreach ($imagens as $key => $value) {
						MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$id,'$value')");
					}
				}

				$sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET nome = ?,descricao = ?, altura = ?,
				largura = ?, comprimento = ?, peso = ?, quantidade = ? WHERE id = $id");
				$sql->execute(array($nome,$descricao,$altura,$largura,$comprimento,$peso,$quantidade));

				Painel::alert('sucesso','Você atualizou seu produto com sucesso!');
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
				$sql->execute(array($id));
				$infoProduto = $sql->fetch();
				$pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
				$pegaImagens->execute();
				$pegaImagens = $pegaImagens->fetchAll();
			}
		}
	?>

		<div class="form-group">
			<label>Nome do Produto:</label>
			<input type="text" name="nome" value="<?php echo $infoProduto['nome']; ?>">
		</div>

		<div class="form-group">
			<label>Descrição do Produto:</label>
			<textarea class="tinymce" name="descricao"><?php echo $infoProduto['descricao']; ?></textarea>
		</div>

		<div class="form-group">
			<label>Largura do Produto:</label>
			<input type="number" name="largura" min="0" max="999999" step="1" value="<?php echo $infoProduto['largura']; ?>">
		</div>

		<div class="form-group">
			<label>Altura do Produto:</label>
			<input type="number" name="altura" min="0" max="999999" step="1" value="<?php echo $infoProduto['altura']; ?>">
		</div>

		<div class="form-group">
			<label>Comprimento do Produto:</label>
			<input type="number" name="comprimento" min="0" max="999999" step="1" value="<?php echo $infoProduto['comprimento']; ?>">
		</div>

		<div class="form-group">
			<label>Peso do produto:</label>
			<input type="number" name="peso" min="0" max="900" step="1" value="<?php echo $infoProduto['peso']; ?>">
		</div><!--form-group-->

		<div class="form-group">
			<label>Quatidade atual do Produto:</label>
			<input type="number" name="quantidade" min="0" max="999999" step="1" value="<?php echo $infoProduto['quantidade']; ?>">
		</div>

		<div class="form-group">
			<label>Selecione as imagens:</label>
			<input multiple type="file" name="imagem[]">
		</div>

		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
		</div>
	</form>
	<div style="background: #fa8564;" class="card-title">Imagens do Produto:</div>
	<?php  
		foreach($pegaImagens as $key => $value){
	?>
	<div class="box-single-wraper w33 left">
			<div class="box-single">
				<div class="topo-box">
					<img style="width: 200px;height: 200px;border-radius: 15px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem'] ?>">
				</div>
				<div style="text-align: center;" class="group-btn">
					<a class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $id; ?>&deletarImagem=<?php echo $value['imagem'] ?>"><i class="fa fa-times"></i> Excluir</a>
				</div>
			</div>
	</div>

	<?php } ?>

	<div class="clear"></div>
</div>