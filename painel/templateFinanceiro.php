<?php  
	include('../includeConstants.php');
?>

<style type="text/css">
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	h2{
		background: #000712;
		color: white;
		padding: 8px;
		text-align: center;
	}

	.box{
		width: 900px;
		margin: 0 auto;
	}

	table{
		width: 900px;
		margin-top: 15px;
		border-collapse: collapse;
	}

	table td{
		font-size: 16px;
		padding: 4px;
		border: 1px solid #ccc;
	}
</style>

<div class="box">
	<?php  
		$nome = (isset($_GET['pagamento']) && $_GET['pagamento'] == 'concluidos') ? 'Concluídos' : 'Pendentes';
	?>
<h2 class="titulo-topo"><i class="fa-regular fa-calendar-check"></i> Pagamentos <?php echo $nome; ?></h2>
	
	<div class="wraper-table">
	<table>
		<tr>
			<td style="font-weight: bold;">Nome do pagamento</td>
			<td style="font-weight: bold;">Cliente</td>
			<td style="font-weight: bold;">Valor</td>
			<td style="font-weight: bold;">Vencimento</td>
		</tr>

		<?php  

			if($nome == 'Pendentes')
				$nome = 0;
			else
				$nome = 1;
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = $nome ORDER BY vencimento ASC");
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