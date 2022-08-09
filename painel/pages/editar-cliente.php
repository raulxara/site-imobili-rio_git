<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$cliente = Painel::select('tb_admin.clientes','id = ?',array($id));
	}else{
		Painel::alert('erro','Você precisa passar o parametro ID.');
		die();
	}
?>
<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-user-plus"></i> Editar Cliente</h2>

	<form  class="ajax" atualizar method="post" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/forms.php" enctype="multipart/form-data">

		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome" value="<?php echo $cliente['nome']; ?>">
		</div>
		<div class="form-group">
			<label>E-mail:</label>
			<input type="text" name="email" value="<?php echo $cliente['email']; ?>">
		</div>
		<div class="form-group">
			<label>Tipo:</label>
			<select name="tipo_cliente">
				<option <?php if($cliente['tipo'] == 'fisico') echo 'selected'; ?> value="fisico">Físico</option>
				<option <?php if($cliente['tipo'] == 'juridico') echo 'selected'; ?> value="juridico">Jurídico</option>
			</select>
		</div>

		<?php  
			if($cliente['tipo'] == 'fisico'){
		?>

		<div ref="cpf" class="form-group">
			<label>CPF:</label>
			<input type="text" name="cpf" value="<?php echo $cliente['cpf_cnpj']; ?>">
		</div>
		<div style="display: none;" ref="cnpj" class="form-group">
			<label>CNPJ:</label>
			<input type="text" name="cnpj">
		</div>

		<?php }else{ ?>

		<div style="display: none;" ref="cpf" class="form-group">
			<label>CPF:</label>
			<input type="text" name="cpf" >
		</div>
		<div style="display: block;" ref="cnpj" class="form-group">
			<label>CNPJ:</label>
			<input type="text" name="cnpj" value="<?php echo $cliente['cpf_cnpj']; ?>">
		</div>

		<?php } ?>

		<div class="form-group">
			<label>Imagem:</label>
			<input type="file" name="imagem">
		</div>
		<div class="form-group">
			<input type="hidden" name="imagem_original" value="<?php echo $cliente['imagem']; ?>">
		</div>
		<div class="form-group">
			<input type="hidden" name="tipo_acao" value="atualizar_cliente">
		</div>
		<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
		</div>

	</form>

	<br />
	<br />

	<h2 class="titulo-topo"><i class="fa-solid fa-table-list"></i> Adicionar Pagamentos</h2>

	<form method="post">
		<?php  
			if(isset($_POST['acao'])){
				$cliente_id = $id;
				$nome = $_POST['nome_pagto'];
				//$valor = str_replace('.','',$_POST['valor']);
				//$valor = str_replace(',','.',$valor);
				$valor = $_POST['valor'];
				$intervalo = $_POST['intervalo'];
				$numero_parcelas = $_POST['parcelas'];
				$status = 0;
				$vencimentoOriginal = $_POST['vencimento'];

				if(strtotime($vencimentoOriginal) < strtotime(date('Y-m-d'))){
					Painel::alert('erro','Não é permitido data menor que hoje');
				}else{


				for ($i = 0; $i < $numero_parcelas; $i++) { 
					$vencimento = strtotime($vencimentoOriginal) + (($i * $intervalo) *(60*60*24));
					$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.financeiro` VALUES(null,?,?,?,?,?)");
					$sql->execute(array($cliente_id,$nome,$valor,date('Y-m-d',$vencimento),0));
				}
				Painel::alert('sucesso','O(s) pagamento(s) foi inserido com sucesso');
				}

			}

			
		?>
		<div class="form-group">
			<label>Nome do pagamento:</label>
			<input type="text" name="nome_pagto" >
		</div>
		<div class="form-group">
			<label>Valor:</label>
			<input type="text" name="valor" >
		</div>
		<div class="form-group">
			<label>Número de parcelas:</label>
			<input type="text" name="parcelas" >
		</div>
		<div class="form-group">
			<label>Intervalo:</label>
			<input type="text" name="intervalo" />
		</div>
		<div class="form-group">
			<label>Vencimento:</label>
			<input type="text" name="vencimento" />
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Inserir">
		</div>
	</form>

	<?php  

		if(isset($_GET['pago'])){
				$sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
				$sql->execute(array($_GET['pago']));
				Painel::alert('sucesso','O pagamento foi realizado');
			}

	?>

	<h2 class="titulo-topo"><i class="fa-regular fa-calendar-plus"></i> Pagamentos Pendentes</h2>

	<div class="wraper-table">
	<table>
		<tr>
			<td>Nome do pagamento</td>
			<td>Cliente</td>
			<td>Valor</td>
			<td>Vencimento</td>
			<td>Enviar e-mail</td>
			<td>Pago</td>
		</tr>

		<?php  

			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 AND cliente_id = $id ORDER BY vencimento ASC");
			$sql-> execute();
			$pendentes = $sql->fetchAll();

			foreach($pendentes as $jey => $value){
			$clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
			$clienteNome->execute();
			$clienteNome = $clienteNome->fetch()['nome'];
			$style = "";
			if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
				$style = 'style="background-color:#a94442"';
			}
		?>

			<tr <?php echo $style; ?>>
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $clienteNome; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
				<td><a style="background: #FDB45C;" class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa-solid fa-envelope"></i> E-mail</a></td>
				<td><a style="background: #1fb5ac;" class="btn" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $id; ?>&pago=<?php echo $value['id'] ?>"><i class="fa-solid fa-square-check"></i> Pago</a></td>
			</tr>

		<?php } ?>
		

	</table>
	</div>

	<h2 class="titulo-topo"><i class="fa-regular fa-calendar-check"></i> Pagamentos Concluídos</h2>

	<div class="wraper-table">
	<table>
		<tr>
			<td>Nome do pagamento</td>
			<td>Cliente</td>
			<td>Valor</td>
			<td>Vencimento</td>
		</tr>

		<?php  

			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 AND cliente_id = $id ORDER BY vencimento ASC");
			$sql-> execute();
			$pendentes = $sql->fetchAll();

			foreach($pendentes as $jey => $value){
			$clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
			$clienteNome->execute();
			$clienteNome = $clienteNome->fetch()['nome'];
		?>

			<tr>
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $clienteNome; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
				
			</tr>

		<?php } ?>
		

	</table>
	</div>

</div>