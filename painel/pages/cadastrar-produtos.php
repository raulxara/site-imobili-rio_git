<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-store"></i> Cadastrar Produto</h2>

	<form method="post" enctype="multipart/form-data">
		<?php
		if(isset($_POST['acao'])){
			$nome = $_POST['nome'];
			$descricao = $_POST['descricao'];
			$largura = $_POST['largura'];
			$altura = $_POST['altura'];
			$peso = $_POST['peso'];
			$comprimento = $_POST['comprimento'];
			$quantidade = $_POST['quantidade'];

			$imagens = array();
			$amountFiles = count($_FILES['imagem']['name']);

			$sucesso = true;

			if($_FILES['imagem']['name'][0] != ''){

			for($i =0; $i < $amountFiles; $i++){
				$imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
				'size'=>$_FILES['imagem']['size'][$i]];
				if(Painel::imagemValida($imagemAtual) == false){
					$sucesso = false;
					Painel::alert('erro','Uma ou mais imagens são inválidas!');
					break;
				}
			}

			}else{
				$sucesso = false;
				Painel::alert('erro','Você precisa selecionar pelo menos uma imagem!');
			}


			if($sucesso){
				//TODO: Cadastrar informacoes e imagens e realizar upload.
				for($i =0; $i < $amountFiles; $i++){
					$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
						'name'=>$_FILES['imagem']['name'][$i]];
					$imagens[] = Painel::uploadFile($imagemAtual);
				}

				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque` VALUES (null,?,?,?,?,?,?,?)");
				$sql->execute(array($nome,$descricao,$largura,$altura,$comprimento,$peso,$quantidade));
				$lastId = MySql::conectar()->lastInsertId();
				foreach ($imagens as $key => $value) {
					MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$lastId,'$value')");
				}
				Painel::alert('sucesso','O produto foi cadastrado com sucesso!');
			}

			
		}
		?>

		<div class="form-group">
			<label>Nome do Produto:</label>
			<input type="text" name="nome">
		</div>

		<div class="form-group">
			<label>Descrição do Produto:</label>
			<textarea class="tinymce" name="descricao"></textarea>
		</div>

		<div class="form-group">
			<label>Largura do Produto:</label>
			<input type="number" name="largura" min="0" max="999999" step="1" value="0">
		</div>

		<div class="form-group">
			<label>Altura do Produto:</label>
			<input type="number" name="altura" min="0" max="999999" step="1" value="0">
		</div>

		<div class="form-group">
			<label>Comprimento do Produto:</label>
			<input type="number" name="comprimento" min="0" max="999999" step="1" value="0">
		</div>

		<div class="form-group">
			<label>Peso do produto:</label>
			<input type="number" name="peso" min="0" max="900" step="1" value="0">
		</div><!--form-group-->

		<div class="form-group">
			<label>Quatidade atual do Produto:</label>
			<input type="number" name="quantidade" min="0" max="999999" step="1" value="0">
		</div>

		<div class="form-group">
			<label>Selecione as imagens:</label>
			<input multiple type="file" name="imagem[]">
		</div>

		<div class="form-group">
			<input type="submit" name="acao" value="Adicionar">
		</div>
	</form>

</div>