<?php 

	namespace controlle;
	use \views\mainView;

	class homeController
	{
		public function index(){
			mainView::render('login.php')
		}
	}

 ?>