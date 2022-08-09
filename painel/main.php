<?php 
	if(isset($_GET['loggout'])){
		Painel::loggout();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>fonts-6/css/all.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/jquery-ui.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/default/zebra_datepicker.min.css">
	<link href="<?php echo INCLUDE_PATH_PAINEL; ?>css/stylepainell.css" rel="stylesheet">
	<link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="image/x-icon" />
	<title>Painel de Controle</title>
</head>
<body>


<base base="<?php echo INCLUDE_PATH_PAINEL; ?>">
<div class="menu">
	<div class="menu-wraper">
	<div class="box-usuario">
		<?php  
			if($_SESSION['img'] == ''){
		?>
		<div class="avatar-usuario">
			<i class="fa fa-user"></i>
		</div>
		<?php }else{ ?>
		<div class="imagem-usuario">
			<img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $_SESSION['img']; ?>" alt="perfil">
		</div>
		<?php } ?>
		<div class="nome-usuario">
			<h2><?php echo $_SESSION['nome']; ?></h2>
			<p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
		</div>
	</div>

	<div class="itens-menu">
		<h2>Cadastro</h2>
		<a <?php selecionadoMenu('cadastrar-depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-depoimentos">Cadatrar Depoimentos</a>
		<a <?php selecionadoMenu('cadastrar-servico'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-servico">Cadastrar Serviços</a>
		<a <?php selecionadoMenu('cadastrar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-slides">Cadastrar Slides</a>
		<h2>Gestão</h2>
		<a <?php selecionadoMenu('listar-depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos">Listar Depoimentos</a>
		<a <?php selecionadoMenu('listar-servicos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos">Listar Serviços</a>
		<a <?php selecionadoMenu('listar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides">Listar Slides</a>
		<h2>Administração do Painel</h2>
		<a <?php selecionadoMenu('editar-usuario'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuario">Editar Usuários</a>
		<a <?php selecionadoMenu('adicionar-usuario'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuario">Adicionar Usuarios</a>
		<h2>Configuração Geral</h2>
		<a <?php selecionadoMenu('editar-site'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-site">Editar Site</a>
		<h2>Gestão de Notícias</h2>
		<a <?php selecionadoMenu('cadastrar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-categorias">Cadastrar Categorias</a>
		<a <?php selecionadoMenu('gerenciar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias">Gerenciar Categorias</a>
		<a <?php selecionadoMenu('cadastrar-noticia'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-noticia">Cadastrar Notícias</a>
		<a <?php selecionadoMenu('gerenciar-noticias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticias">Gerenciar Notícias</a>
		<h2>Gestão de Clientes</h2>
		<a <?php selecionadoMenu('cadastrar-clientes'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-clientes">Cadastrar Clientes</a>
		<a <?php selecionadoMenu('gerenciar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-clientes">Gerenciar Clientes</a>
		<h2>Controle Financeiro</h2>
		<a <?php selecionadoMenu('visualizar-pagamentos'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos">Visualizar Pagamentos</a>
		<h2>Controle de Estoque</h2>
		<a <?php selecionadoMenu('cadastrar-produtos'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-produtos">Cadastrar Produto</a>
		<a <?php selecionadoMenu('visualizar-produtos'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Visualizar Produto</a>
		<h2>Gestão de Imóveis</h2>
		<a <?php selecionadoMenu('cadastrar-empreendimento'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-empreendimento">Cadastrar Empreendimento</a>
		<a <?php selecionadoMenu('listar-empreendimentos'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-empreendimentos">Listar Empreendimentos</a>
	</div>
	</div>
</div>

<header>
	<div class="center">
		<div class ="menu-btn">
			<i class="fa fa-bars"></i>
		</div>
		<div class ="loggout">
			<a href="<?php echo INCLUDE_PATH_PAINEL ?>calendario?"><i class="fa-solid fa-calendar-days"></i> Calendário</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL ?>chat?"><i class="fa-solid fa-comments"></i> Chat</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL ?>?"><i class="fa fa-home"></i> Home</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"><i class="fa-solid fa-lock"></i> Sair</a>
		</div>
	<div class="clear"></div>	
	</div>		
</header>

<div class="content">
	
	<?php Painel::carregarPagina(); ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php Painel::loadJS(array('jquery-ui.min.js'),'listar-empreendimentos'); ?>
<script src="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/zebra_datepicker.min.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/jquery.maskMoney.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/jquery.mask.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/jquery.ajaxform.js"></script>
<script src="<?php echo INCLUDE_PATH; ?>js/constants.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/main.js"></script><script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
 <script>
  tinymce.init({ 
  	selector:'.tinymce',
  	plugins: "image",
  	height:300,
   });
 </script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/helperMask.js"></script>
<?php Painel::loadJS(array('ajax.js'),'gerenciar-clientes'); ?>
<?php Painel::loadJS(array('ajax.js'),'cadastrar-clientes'); ?>
<?php Painel::loadJS(array('ajax.js'),'editar-cliente'); ?>
<?php Painel::loadJS(array('controleFinanceiro.js'),'editar-cliente'); ?>
<?php Painel::loadJS(array('empreendimentos.js'),'listar-empreendimentos'); ?>
<?php Painel::loadJS(array('chat.js'),'chat'); ?>
<?php Painel::loadJS(array('calendario.js'),'calendario'); ?>
</body>
</html>