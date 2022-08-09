<?php 
	$site = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
	$site->execute();
	$site = $site->fetch();
?>

<div class="box-content">
	<h2 class="titulo-topo"><i class="fa fa-pencil"></i> Editar Configurações do Site</h2>

	<form method="post" enctype="multipart/form-data">

		<?php
			if(isset($_POST['acao'])){
				if(Painel::update($_POST,true)){
					Painel::alert('sucesso','O site foi editado com sucesso!');
					$site = Painel::select('tb_site.config',false);
				}else{
					Painel::alert('erro','Campos vázios não são permitidos.');
				}
			}
		?>

		<div class="form-group">
			<label>Título do site:</label>
			<input type="text" name="titulo" value="<?php echo $site['titulo']; ?>" />
		</div>

		<div class="form-group">
			<label>Nome da empresa:</label>
			<input type="text" name="nome_autor" value="<?php echo $site['nome_autor']; ?>" />
		</div>

		<div class="form-group">
			<label>Descrição da empresa no site P1:</label>
			<textarea name="descricaop1"><?php echo $site['descricaop1']; ?></textarea>
		</div>

		<div class="form-group">
			<label>Descrição da empresa no site P2:</label>
			<textarea name="descricaop2"><?php echo $site['descricaop2']; ?></textarea>
		</div>

		<?php
			for($i = 1; $i <= 3; $i++){
		?>

		<div class="form-group">
			<label>Ícone <?php echo $i; ?>:</label>
			<input type="text" name="icone<?php echo $i; ?>" value="<?php echo $site['icone'.$i]; ?>" />
		</div>

		<div class="form-group">
			<label>Descrição do ícone <?php echo $i; ?>:</label>
			<textarea name="descricao<?php echo $i; ?>"><?php echo $site['descricao'.$i]; ?></textarea>
		</div>

		<?php } ?>

		
		<div class="form-group">
			<input type="hidden" name="nome_tabela" value="tb_site.config" />
			<input type="submit" name="acao" value="Atualizar">
		</div>
	</form>
</div>