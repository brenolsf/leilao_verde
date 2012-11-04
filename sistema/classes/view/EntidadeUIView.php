<?php
		require_once("../classes/view/includeView.php");
				
				
		/**
	 	* Faz interface com o HTML - Tabela entidade
	 	* Trata posts, gets e prepara informaÃ§Ã£o para ser enviada para a interface / Camada VIEW
	 	* @package view
	 	* @author Wagner Gomes GonÃ§alves <wagner@atmainterativa.com.br>
	 	*/	
		class EntidadeView{

			/**
   			 * Guarda mensagens de erro
   			 * @var string
 			 */
 			public $mensagem;
 			 
			/**
   			 * Guarda instancia de conexÃ£o com banco de dados
   			 * @var ADODB_mysqlt
   			 * @access private
 			 */				
			private $objDb; 	

			/**
   			 * Guarda menu do sistema (no caso do usuÃ¡rio estar logado)
   			 * @var string
 			 */			
			public $menu;				
			
		
			public $arrEntidadeVO;
			public $objEntidadeVO;
			public $objUsuarioBiz;
			public $bufferListagem;
			public $arrFiltro = array();
			public $arrFiltroAlias = array();	
			public $objEntidadeBiz;
			public $oidEntidade;

			public $objUsuarioVO;

			public $objUsuarioperfilVO;
			public $objUsuarioperfilBiz;
			
			public $flgFecha = false;

	
			/**
		 	 * Construtor padrÃ£o
			 */			
			public function EntidadeView(){
				$this->objUsuarioBiz = new UsuarioBiz();
				$this->objDb = $this->objUsuarioBiz->getDb();
			
				$this->objEntidadeBiz = new EntidadeBiz($this->objDb);
				$this->listagem = "bemvindo.php";
				
			}

			/**
		 	 * Processa requisiÃ§Ãµes provindas do formulÃ¡rio que trata informaÃ§Ãµes desta tabela/objeto
			 * @access public
			 */
			public function iniciar(){
				try{			
					$this->objUsuarioperfilBiz = new UsuarioperfilBiz($this->objDb);
					$this->objEntidadeVO = new EntidadeVO;
					$this->objUsuarioVO = new UsuarioVO;
					$this->listagem = "bemvindo.php";
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$this->objEntidadeVO->readForm();
						$this->objUsuarioVO->readForm();
						if(isset($_POST["salvar"]) && !$this->validar()){
							$this->objDb->StartTrans();
							$this->objUsuarioVO->login = $this->objEntidadeVO->cnpj; //Login será através do CNPJ
							$this->objUsuarioVO->senha = md5($this->objUsuarioVO->senha); // MD5 da senha
							$this->objUsuarioVO->flgAtivo = "1"; // Ativo por default
							//$this->objUsuarioVO->flgAdministrador = "0"; // Remover depois...
							$this->objEntidadeVO->oidUsuario = $this->objUsuarioBiz->insertVO($this->objUsuarioVO, false);
							$this->objEntidadeVO->oidEntidade = $this->objEntidadeBiz->insertVO($this->objEntidadeVO);
							// Perfil - Fixo em constantes
							$this->objUsuarioperfilBiz->deleteWhere("oidUsuario = '" . $this->objEntidadeVO->oidUsuario . "'");	
							$objUsuarioperfilVO = new UsuarioperfilVO();
							$objUsuarioperfilVO->oidUsuario = $this->objEntidadeVO->oidUsuario;
							$objUsuarioperfilVO->oidPerfil = Constantes::OID_PERFIL_ENTIDADE;
							$objUsuarioperfilVO->flgVer = "1";
							$objUsuarioperfilVO->flgExcluir = "1";
							$objUsuarioperfilVO->flgIncluir = "1";
							$objUsuarioperfilVO->flgAlterar = "1";
							$this->objUsuarioperfilBiz->insertVO($objUsuarioperfilVO);												
							$this->fechaTransacao(Constantes::ERRO01_NAO_SALVA);
							$this->redirect();	
						}
					}else{
						$this->objEntidadeVO = new EntidadeVO;
						$this->objUsuarioVO = new UsuarioVO;
						$this->objEntidadeVO->readForm();
						$this->objUsuarioVO->readForm();					
						$_SESSION["token"] = md5(uniqid(rand(), true)); //Evita CSRF
					}
				}catch(Exception $e){
					$this->objDb->CompleteTrans();		
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->mensagem = $e->getMessage();
				}	
			}



			/**
		 	 * Fecha transaÃ§Ãµes abertadas neste objeto
			 * @access public
			 * @param string $msg Mensagem, caso ocorra algum errode SQL
			 */
			private function fechaTransacao($msg){
				$transacaoFalhou = $this->objDb->HasFailedTrans();
				$this->objDb->CompleteTrans();						
				if($transacaoFalhou) throw new Exception($msg);
			}

			/**
		 	 * Método de validação dos campos postados
			 * @access private
			 */
	
			private function validar(){
				if($_SESSION["token"] != $_POST["token"]) throw new Exception(Constantes::ERRO05_CSRF);
				if($_POST["senha"] != $_POST["confere"]) throw new Exception(Constantes::ERRO05_CSRF);
				$objFormulario = new Formulario();
				// Entidade
				$objFormulario->addItem(new Text("oidEntidade",array(new Obrigatorio(),new Inteiro(11, true)), "ID"));
				$objFormulario->addItem(new Text("razaoSocial",array(new Obrigatorio(),new TamanhoMaximo(255)), "Razão Social"));
				$objFormulario->addItem(new Text("endereco",array(new Obrigatorio(),new TamanhoMaximo(255)), "Endereço"));
				$objFormulario->addItem(new Text("cnpj",array(new Obrigatorio(),new TamanhoMaximo(18),new Cnpj()), "CNPJ"));
				$objFormulario->addItem(new Text("saldoRce",array(new Obrigatorio(),new Inteiro(11, false)), "Créditos de Carbono"));
				// Usuário
				$objFormulario->addItem(new Text("nome",array(new Obrigatorio(),new TamanhoMaximo(100)), "Nome"));
				$objFormulario->addItem(new Text("senha",array(new Obrigatorio(),new TamanhoMaximo(200)), "Senha"));
				$objFormulario->addItem(new Text("cpf",array(new TamanhoMaximo(14),new Cpf()), "CPF"));
				$objFormulario->addItem(new Text("telefone",array(new TamanhoMaximo(15),new Telefone()), "Telefone"));

				$objFormulario->validarItens();
			}
	
			/**
		 	 * Redireciona para pÃ¡gina de listagem
			 * @access private
			 */
			private function redirect(){
				
				if(!isset($_REQUEST["popup"])) header("Location: " . $this->listagem);
				else $this->flgFecha = true;
			}



		}
	?>
	