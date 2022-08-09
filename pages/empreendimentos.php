<?php  
	$parametros = \views\mainView::$par;
?>

<section class="lista-imoveis">

	<div class="container">
		<h2 class="title-busca">Listando <b><?php echo count($parametros['imoveis']); ?> imóveis</b> de <?php echo $parametros['nome_empreendimento']; ?></h2>
			<?php 
				foreach($parametros['imoveis'] as $key=>$value){
					$imagem = \MySql::conectar()->prepare("SELECT imagem FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $value[id]");
					$imagem->execute();
					$imagem = $imagem->fetch()['imagem'];
				
			 ?>
		<div class="row-imoveis">
			<div class="r1">
				<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagem; ?>">
			</div>
			<div class="r2">
				<p><i class="fa fa-pencil"></i> <b>Nome do imóvel:</b> <?php echo $value['nome']; ?></p>
				<p><i class="fa-solid fa-down-left-and-up-right-to-center"></i> <b>Área:</b> <?php echo $value['area']; ?> m²</p>
				<p><i class="fa-solid fa-dollar-sign"></i> <b>Preço:</b> R$ <?php echo \Painel::convertMoney($value['preco']); ?></p>
			</div>
		</div>
			<?php 
				}
			 ?>
	</div>

</section>