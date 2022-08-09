<?php  
	$parametros = \views\mainView::$par;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Imobig</title>
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>fonts-6/css/all.css">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH ?>css3/style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="imoveis, alugar, estadia">
	<meta name="description" content="você pode estar em qualquer lugar agora, a temporada e o lugar é por sua escolha">
	<meta name="author" content="Raul Nascimento Cruz">
	<link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="image/x-icon" />
	

</head>
<body>
	<base base="<?php echo INCLUDE_PATH; ?>" />

<header>
	<div class="container">
		<div class="logo"><a href="<?php echo INCLUDE_PATH?>">Imobig</a></div>
		<nav class="desktop">
			<ul>
				<?php 
					$selectEmpreend = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` ORDER BY order_id ASC");
					$selectEmpreend->execute();
					$empreendimentos = $selectEmpreend->fetchAll();
					foreach ($empreendimentos as $key => $value) {
						

				?>
				<li><a href="<?php echo INCLUDE_PATH.$value['slug']; ?>"><?php echo $value['nome']; ?></a></li>
				
				<?php } ?>
			</ul>
		</nav>
	<div class="clear"></div>
	</div>


</header>

	<section class="search1">
		<div class="container">
			<input type="text" name="texto-busca" placeholder="O que você procura?">
		</div>
	</section>

	<section class="search2">
		<div class="container">
		<form method="post" action="<?php echo INCLUDE_PATH ?>ajax/formularios.php">
			<div class="form-group w50 left">
				<label>Área Minima: </label>
				<input placeholder="0" name="area_minima" type="number" min="0" max="100000" step="100">
			</div><!--form-group-->
			<div class="form-group w50 left">
				<label>Área Máxima: </label>
				<input placeholder="0" name="area_maxima" type="number" min="0" max="100000" step="100">
			</div><!--form-group-->
			<div class="form-group w50 left">
				<label>Preço Minimo: </label>
				<input placeholder="0" name="preco_min" type="text">
			</div><!--form-group-->
			<div class="form-group w50 left">
				<label>Preço Máximo: </label>
				<input placeholder="0" name="preco_max" type="text">
			</div><!--form-group-->
			<?php
				if(isset($parametros['slug_empreendimento'])){
					echo '<input type="hidden" name="slug_empreendimento" value="'.$parametros['slug_empreendimento'].'" />';
				}
			?>
			<div class="clear"></div>
		</div>
	</section>