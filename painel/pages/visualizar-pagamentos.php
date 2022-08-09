<div class="box-content w100">

<?php  

		if(isset($_GET['pago'])){
				$sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
				$sql->execute(array($_GET['pago']));
				Painel::alert('sucesso','O pagamento foi realizado');
			}

	?>

	<h2 class="titulo-topo"><i class="fa-regular fa-calendar-plus"></i> Pagamentos Pendentes</h2>
	<div class="gerar-pdf">
		<a target="_blank" href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamento=pendentes"><i class="fa-regular fa-file-pdf"></i> Baixar PDF</a>
	</div>

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

			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 ORDER BY vencimento ASC");
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
				<td><a style="background: #1fb5ac;" class="btn" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos?pago=<?php echo $value['id'] ?>"><i class="fa-solid fa-square-check"></i> Pago</a></td>
			</tr>

		<?php } ?>
		

	</table>
	</div>

	

	<h2 class="titulo-topo"><i class="fa-regular fa-calendar-check"></i> Pagamentos Concluídos</h2>
	<div class="gerar-pdf">
		<a href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamento=concluidos" target="_blank"><i class="fa-regular fa-file-pdf"></i> Baixar PDF</a>
	</div>
	<div class="wraper-table">
	<table>
		<tr>
			<td>Nome do pagamento</td>
			<td>Cliente</td>
			<td>Valor</td>
			<td>Vencimento</td>
		</tr>

		<?php  

			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 ORDER BY vencimento ASC");
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