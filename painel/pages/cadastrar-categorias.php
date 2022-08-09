<div class="box-content w100">
	<h2 class="titulo-topo"><i class="fa-solid fa-table-list"></i> Cadastrar Categoria</h2>

	<form method="post" enctype="multipart/form-data">

		<?php
			if(isset($_POST['acao'])){
				$nome = $_POST['nome'];

				if($nome == ''){
					Painel::alert('erro','O campo nome não pode ficar vazio!');
				}else{
					$slug = Painel::generateSlug($nome);
					$arr = ['nome'=>$nome,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.categorias'];
					Painel::insert($arr);
					Painel::alert('sucesso','A categoria foi adicionada com sucesso!');
					
				}
			}
		?>

		<div class="form-group">
			<label>Nome da categoria:</label>
			<input type="text" name="nome">
		</div>

		<div class="form-group">
			<input type="submit" name="acao" value="Adicionar">
		</div>
		
	</form>
</div>
