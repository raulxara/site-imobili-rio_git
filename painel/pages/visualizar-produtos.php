<?php
	if(isset($_GET['pendentes']) == false){
?>

<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-store"></i> Produtos no Estoque</h2>
	<div class="busca">
		<form method="post">
			<input type="text" name="busca" placeholder='Procure pelo nome do produto...'>
			<input type="submit" name="acao" value="Buscar" >
		</form>
	</div>
	<?php  

		if(isset($_GET['deletar'])){
			$id = (int)$_GET['deletar'];
			$imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
			$imagens->execute();
			$imagens = $imagens->fetchAll();
			foreach ($imagens as $key => $value) {
				@unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
			}
			MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
			MySql::conectar()->exec("DELETE FROM `tb_admin.estoque` WHERE id = $id");
			Painel::alert('sucesso',"O produto foi deletado do estoque com sucesso!");
		}

		if(isset($_POST['atualizar'])){
			$quantidade = $_POST['quantidade'];
			$produto_id = $_POST['produto_id'];
			if($quantidade < 0){
				Painel::alet('erro','Você não pode atualizar a quantidade para menor ou igual a 0');
			}else{
				MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
				Painel::alert('sucesso','Você atualizou a quantidade do produto com ID: <b>'.$_POST['produto_id'].'</b>.');
			}
		}

		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
		$sql->execute();
		if($sql->rowCount() > 0){
		Painel::alert('atencao','Voce esta com produtos em falta! Clique <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?pendentes">aqui</a> para visualiza-los.');
			}

	?>
	<div class="boxes">
		<?php 
			$query = "";
			if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar'){
				$nome = $_POST['busca'];
				$query = "WHERE (nome LIKE '%$nome%' OR descricao LIKE '%$nome%')";
			}
			if($query == ''){
				$query2 = "WHERE quantidade > 0";
			}else{
				$query2 = "AND quantidade > 0";
			}
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query $query2");
			$sql->execute();
			$produtos = $sql->fetchAll();
			if($query != ''){
				echo '<div style="width:100%; padding:0 20px;" class="busca-result"><p>Foram encontrados <b>'.count($produtos).'</b> resultado(s)</p></div>';
			}
			foreach ($produtos as $key => $value) {
			$imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
			$imagemSingle->execute();
			$imagemSingle = $imagemSingle->fetch()['imagem'];

			
		?>
		<div class="box-single-wraper w33 left">
			<div class="box-single">
				<div class="topo-box">
				<?php
					if($imagemSingle == ''){

				?>
					<h1 style="font-size: 100px;width: 200px;height: 200px;border-radius: 15px;"><i class="fa-solid fa-ban"></i></h1>

				<?php }else{ ?>
					<img style="width: 200px;height: 200px;border-radius: 15px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle ?>">
				<?php } ?>
				</div>
				<div class="body-box">
					<p><b><i class="fa fa-pencil"></i> Nome do produto:</b> <?php echo $value['nome'] ?></p>
					<p><b><i class="fa-solid fa-bars"></i> Descrição:</b> <?php echo substr(strip_tags($value['descricao']),0,15).'...'; ?></p>
					<p><b><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Largura:</b> <?php echo $value['largura'] ?>cm</p>
					<p><b><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Altura:</b> <?php echo $value['altura'] ?>cm</p>
					<p><b><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Comprimento:</b> <?php echo $value['comprimento'] ?>cm</p>
					<p><b><i class="fa-solid fa-scale-balanced"></i> Peso:</b> <?php echo $value['peso'] ?></p>
					<div class="group-btn">
						<form method="post">
							<label>Quantidade atual:</label>
							<input type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $value['quantidade'] ?>">
							<input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
							<input type="submit" name="atualizar" value="Atualizar">
						</form>
					</div>
					<div class="group-btn">
						<a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $value['id'] ?>;"><i class="fa fa-pencil"></i> Editar</a>
						<a class="btn delete " item_id="<?php echo $value['id'] ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?deletar=<?php echo $value['id']; ?>"><i class="fa fa-times"></i> Excluir</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>

</div>

<?php }else{ ?>
<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-store"></i> <a style= "color: #0d1d33;" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Produtos no Estoque</a> >> Produtos em Falta</h2>
	<?php  
		if(isset($_POST['atualizar'])){
			$quantidade = $_POST['quantidade'];
			$produto_id = $_POST['produto_id'];
			if($quantidade < 0){
				Painel::alet('erro','Você não pode atualizar a quantidade para menor ou igual a 0');
			}else{
				MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
				Painel::alert('sucesso','Você atualizou a quantidade do produto com ID: <b>'.$_POST['produto_id'].'</b>.');
			}
		}
		echo '<br />';
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
		$sql->execute();
		$produtos = $sql->fetchAll();
		if(count($produtos) > 0)
			Painel::alert('atencao','Todos os produtos listados estão em falta no estoque.');
		else
			Painel::alert('sucesso','Nenhum produto esta em falta');
	?>
	<div class="boxes">
		<?php
			foreach ($produtos as $key => $value) {
			$imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
			$imagemSingle->execute();
			$imagemSingle = $imagemSingle->fetch()['imagem'];

			
		?>
		<div class="box-single-wraper w33 left">
			<div class="box-single">
				<div class="topo-box">
				<?php
					if($imagemSingle == ''){

				?>
					<h1 style="font-size: 100px;width: 200px;height: 200px;border-radius: 15px;"><i class="fa-solid fa-ban"></i></h1>

				<?php }else{ ?>
					<img style="width: 200px;height: 200px;border-radius: 15px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle ?>">
				<?php } ?>
				</div>
				<div class="body-box">
					<p><b><i class="fa fa-pencil"></i> Nome do produto:</b> <?php echo $value['nome'] ?></p>
					<p><b><i class="fa-solid fa-bars"></i> Descrição:</b> <?php echo substr(strip_tags($value['descricao']),0,15).'...'; ?></p>
					<p><b><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Largura:</b> <?php echo $value['largura'] ?>cm</p>
					<p><b><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Altura:</b> <?php echo $value['altura'] ?>cm</p>
					<p><b><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Comprimento:</b> <?php echo $value['comprimento'] ?>cm</p>
					<p><b><i class="fa-solid fa-scale-balanced"></i> Peso:</b> <?php echo $value['peso'] ?></p>
					<div class="group-btn">
						<form method="post">
							<label>Quantidade atual:</label>
							<input type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $value['quantidade'] ?>">
							<input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
							<input type="submit" name="atualizar" value="Atualizar">
						</form>
					</div>
					<div class="group-btn">
						<a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $value['id'] ?>;"><i class="fa fa-pencil"></i> Editar</a>
						<a class="btn delete " item_id="<?php echo $value['id'] ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa fa-times"></i> Excluir</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
</div>

<?php } ?>