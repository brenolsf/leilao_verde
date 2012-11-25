<?php
	require_once("../classes/view/includeView.php");
	
	class IndexView{
	
		public $objUsuarioVO;
		public $objUsuarioBiz;
		public $listagem;
		public $arrNovidade = array();
		public $mensagem = "";
	
		public function IndexView(){
			try{	
				$this->objVO = null;
				$this->objUsuarioBiz = new UsuarioBiz();
				$this->listagem = "principal.php";
				$this->objConstantes = new Constantes();
			}catch(Exception $e){
				$this->mensagem = $e->getMessage();
			}
		}
		
		public function iniciar(){
			try{		
				if($_SERVER["REQUEST_METHOD"] == "POST"){	
					$this->objUsuarioVO = new UsuarioVO();
					$this->objUsuarioVO->readForm();
					if(!$this->validar()){ 
						ControlaLog::fazLog("Login de usuário", Constantes::LOGINFO);
						$this->objUsuarioBiz->logaUsuario($this->objUsuarioBiz->verificaLoginSenha($this->objUsuarioVO->login, $this->objUsuarioVO->senha));
						ControlaLog::fazLog("Usuário logado", Constantes::LOGINFO);
						$this->redirect();
					}
				}else if($this->objUsuarioBiz->isUsuarioLogado()){
					$this->redirect();
				}
			}catch(Exception $e){
				ControlaLog::fazLog("Usuário não encontrado", Constantes::LOGINFO);
				ControlaLog::fazLog($e, Constantes::LOGINFO);
				$this->objUsuarioBiz->deslogaUsuario(false);
				$this->mensagem = $e->getMessage();
			}
		}
		public function iniciarLogado(){
			try{		
				$this->menu = $this->objUsuarioBiz->validaAcesso();
			}catch(Exception $e){
				ControlaLog::fazLog("Usuário não encontrado", Constantes::LOGINFO);
				ControlaLog::fazLog($e, Constantes::LOGINFO);
				$this->objUsuarioBiz->deslogaUsuario(false);
				$this->mensagem = $e->getMessage();
			}
		}
		private function validar(){
			$objFormulario = new Formulario();
			$objFormulario->addItem(new Text("login",array(new Obrigatorio(), new TamanhoMinimo(6)), "Login"));
			$objFormulario->addItem(new Text("senha",array(new Obrigatorio()), "Senha"));
			$objFormulario->validarItens();			
		}
		
		private function redirect(){
			header("Location: " . $this->listagem);
		}
		
	}
?>