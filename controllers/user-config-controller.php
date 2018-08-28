<?php
/**
 * Classe UserConfigController
 * Controller do bsckoffice de utilizador
 * 
 * @package SocialArte
 * @version 1.0
 */
class UserConfigController extends MainController {


	public function produtos() {
		// Title da página
		$this->title = 'Configuração da Conta - Produtos';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';
		
		// /views/_includes/loader.php
		require ABSPATH . '/views/_includes/loader.php';
		
		// /views/user-register/index.php
		require ABSPATH . '/views/user-config/user-config-view.php';
		
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';
		
		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
		echo '<script> tabs("#produtos",0); </script>';
	}
	
	public function compras() {
		// Title da página
		$this->title = 'Configuração da Conta - Compras';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/user-register/index.php
		require ABSPATH . '/views/user-config/user-config-view.php';
		
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';

		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
		if($modelo->user_data[0]['Seller'] == 'N'){
			echo '<script> tabs("#compras",0); </script>';
		}else{
			echo '<script> tabs("#compras",2); </script>';
		}
		
	}

	public function vendas() {
		// Title da página
		$this->title = 'Configuração da Conta - Vendas';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/user-register/index.php
		require ABSPATH . '/views/user-config/user-config-view.php';
		
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';

		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
		echo '<script> tabs("#vendas",1); </script>';
	}

	public function mensagens() {
		// Title da página
		$this->title = 'Configuração da Conta - Mensagens';


		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/user-register/index.php
		require ABSPATH . '/views/user-config/user-config-view.php';
		
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';

		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
		// selecionar a aba das mensagens
		if($modelo->user_data[0]['Seller'] == 'N'){
			echo '<script> tabs("#mensagens",1); </script>';
			switch($parametros[0]){
				case "recebidas":
					echo '<script> subMenus("mensagens",0); </script>';
					break;
				case "arquivadas":
					echo '<script> subMenus("mensagens",26); </script>';
					echo '<script>	
							$("#mensagens div").removeClass("ativaTabs");
							$("#marq").addClass("ativaTabs");
						  </script>';
					break;
				default:
					break;
			}
		}else{
			echo '<script> tabs("#mensagens",3); </script>';
			switch($parametros[0]){
				case "recebidas":
					echo '<script> subMenus("mensagens",0); </script>';
					break;
				case "arquivadas":
					echo '<script> subMenus("mensagens",26); </script>';
					echo '<script>	
							$("#mensagens div").removeClass("ativaTabs");
							$("#marq").addClass("ativaTabs");
						  </script>';
					break;
				default:
					break;
			}
		}		
	}

	public function informacoes_pessoais() {
		// Title da página
		$this->title = 'Configuração da Conta - Informações';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/user-register/index.php
		require ABSPATH . '/views/user-config/user-config-view.php';
		
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';

		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
		
		if($modelo->user_data[0]['Seller'] == 'N'){
			echo '<script> tabs("#ipessoais",2); </script>';
			switch($parametros[0]){
				case "dados-pessoais":
					echo '<script> subMenus("ipessoais",0); </script>';
					break;
				case "dados-faturacao":
					echo '<script> subMenus("ipessoais",1); </script>';
					break;
				case "as-minhas-moradas":
					echo '<script> subMenus("ipessoais",2); </script>';
					break;
				case "mudar-password":
					echo '<script> subMenus("ipessoais",3); </script>';
					echo '<script> $("#ipessoais div").removeClass("ativaTabs"); </script>';
					echo '<script> $("#passwd").addClass("ativaTabs"); </script>';
					break;
				default:
					break;
			}			
		}else{
			echo '<script> tabs("#ipessoais",4); </script>';
			switch($parametros[0]){
				case "dados-pessoais":
					echo '<script> subMenus("ipessoais",0); </script>';
					break;
				case "dados-faturacao":
					echo '<script> subMenus("ipessoais",1); </script>';
					break;
				case "as-minhas-moradas":
					echo '<script> subMenus("ipessoais",2); </script>';
					break;
				case "mudar-password":
					echo '<script> subMenus("ipessoais",3); </script>';
					echo '<script> $("#ipessoais div").removeClass("ativaTabs"); </script>';
					echo '<script> $("#passwd").addClass("ativaTabs"); </script>';
					break;
				default:
					break;
			}
		}
	}

	public function notificacoes() {
		// Title da página
		$this->title = 'Configuração da Conta - Notificações';

		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg( 0 ) : array();

		// Carrega o modelo para este view
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		/** Carrega os arquivos das views **/
		
		//Jquery 3.2.1
		echo '<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>';

		//<!-- Funções em javascript -->
		echo '<script src="'.HOME_URI.'/views/_js/funcoes.js?v='.time().'"></script>';
		
		// /views/_includes/header.php
		require ABSPATH . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require ABSPATH . '/views/_includes/menu.php';

		// /views/user-register/index.php
		require ABSPATH . '/views/user-config/user-config-view.php';
		
		echo '<script src="'.HOME_URI.'/views/_js/addCart.js?v='.time().'"></script>';

		// /views/_includes/footer.php
		require ABSPATH . '/views/_includes/footer.php';
		if($modelo->user_data[0]['Seller'] == 'N'){
			echo '<script> tabs("#notificacoes",3); </script>';
		}else{
			echo '<script> tabs("#notificacoes",5); </script>';
		}		
	}
	
	public function delProd(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->delProd();		
	}
	
	public function delAdd(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->delAdd();
	}
	
	public function chAdd(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->chAdd();
	}
	
	public function chPwd(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->chPwd();
	}
	
	public function chInv(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->chInv();
	}
	
	public function chFullname(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->chFullname();
	}
	
	public function chUserdata(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->chUserdata();
	}
	
	public function markAsReaded(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->markAsReaded();		
	}
	
	public function deleteAlert(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->deleteAlert();
	}
	
	public function markMSGAsReaded(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->markMSGAsReaded();		
	}
	
	public function deleteMSG(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->deleteMSG();
	}
	
	public function markMSGAsFiled(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->markMSGAsFiled();		
	}
	
	public function removeMSGAsFiled(){
		// Instanciamento do model
		$modelo = $this->load_model( 'user-config/user-config-model' );
		
		$modelo->removeMSGAsFiled();		
	}

	public function login(){
		$lg = new UserLogin();
		$lg->login();
	}

}