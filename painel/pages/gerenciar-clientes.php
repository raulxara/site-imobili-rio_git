

<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-table-list"></i> Clientes Cadastrados</h2>
	<div class="busca">
		<form method="post">
			<input type="text" name="busca" placeholder='Procure por:  nome, e-mail, cpf ou cnpj'>
			<input type="submit" name="acao" value="Buscar" >
		</form>
	</div>
	<div class="boxes">
	<?php
		$query = "";
		if(isset($_POST['acao'])){
			$busca = $_POST['busca'];
			$query = " WHERE nome LIKE '%$busca%' OR email LIKE '%$busca%' OR cpf_cnpj LIKE '%$busca%'";
		}
		$clientes = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` $query");
		$clientes->execute();
		$clientes = $clientes->fetchAll();
		if(isset($_POST['acao'])){
			echo '<div style="width:100%; padding:0 20px;" class="busca-result"><p>Foram encontrados <b>'.count($clientes).'</b> resultado(s)</p></div>';
		}
		foreach($clientes as $value){
	?>
		<div class="box-single-wraper w33 left">
			<div class="box-single">
				<div class="topo-box">
					<?php  
						if($value['imagem'] == ''){
					?>
					<h2><i class="fa fa-user"></i></h2>
					<?php }else{ ?>
						<img style="width: 70px;height: 70px;border-radius: 15px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>" />
					<?php } ?>
				</div>
				<div class="body-box">
					<p><b><i class="fa-regular fa-user"></i> Nome do cliente:</b> <?php echo $value['nome']; ?></p>
					<p><b><i class="fa-regular fa-envelope"></i> E-mail:</b> <?php echo $value['email']; ?></p>
					<p><b><i class="fa-solid fa-inbox"></i> Tipo:</b> <?php echo ucfirst($value['tipo']); ?></p>
					<p><b><i class="fa-solid fa-hashtag"></i> <?php  
						if($value['tipo'] == 'fisico')
							echo 'CPF';
						else
							echo 'CNPJ';
					?>:</b> <?php echo $value['cpf_cnpj']; ?></p>
					<div class="group-btn">
						<a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $value['id']; ?>"><i class="fa fa-pencil"></i> Editar</a>
						<a class="btn delete " item_id="<?php echo $value['id']; ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa fa-times"></i> Excluir</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>

</div>