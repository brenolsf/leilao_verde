<?php
		require_once("../classes/view/includeView.php");
				
				
		/**
	 	* Faz interface com o HTML - Tabela leilao
	 	* Trata posts, gets e prepara informaÃ§Ã£o para ser enviada para a interface / Camada VIEW
	 	* @package view
	 	* @author Wagner Gomes GonÃ§alves <wagner@atmainterativa.com.br>
	 	*/	
		class LeilaoView{

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
		

			public $flgPermissaoVer = true;
			public $flgPermissaoExcluir = true;
			public $flgPermissaoIncluir = true;
			public $flgPermissaoAlterar = true;		
			
		
			public $arrLeilaoVO;
			public $objLeilaoVO;
			public $objUsuarioBiz;
			public $bufferListagem;
			public $arrFiltro = array();
			public $arrFiltroAlias = array();	
			public $objLeilaoBiz;
			public $oidLeilao;
			
			public $arrPropostaVO = array();
			public $bufferListagemProposta = "";
			public $objPropostaVO;
			public $objPropostaBiz;
			public $flgFecha = false;
			public $arrEntidadeVO = array();
			public $objEntidadeVO;
			public $objEntidadeBiz;

	
			/**
		 	 * Construtor padrÃ£o
			 */			
			public function LeilaoView(){
				$this->objUsuarioBiz = new UsuarioBiz();
				$this->objDb = $this->objUsuarioBiz->getDb();
				$this->menu = $this->objUsuarioBiz->validaAcesso();
			
				$this->objLeilaoBiz = new LeilaoBiz($this->objDb);
				$this->listagem = "leilaoLista.php";
				
			}

			/**
		 	 * Processa requisiÃ§Ãµes provindas do formulÃ¡rio que trata informaÃ§Ãµes desta tabela/objeto
			 * @access public
			 */
			public function iniciar(){
				try{			
					$this->objPropostaBiz = new PropostaBiz($this->objDb);
					$this->objEntidadeBiz = new EntidadeBiz($this->objDb);
					$this->arrEntidadeVO = $this->objEntidadeBiz->findWhere(isset($_GET["oidEntidade"]) ? "oidEntidade = " . (!is_numeric($_GET["oidEntidade"]) ? Criptografia::decodificar($_GET["oidEntidade"]) : $_GET["oidEntidade"]) : "", "razaoSocial" , "", "", false);
					$this->objEntidadeVO = new EntidadeVO();

	
					$this->objLeilaoVO = new LeilaoVO;
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$this->objLeilaoVO->readForm();
						
												
						if((isset($_POST["salvar"]) || isset($_POST["salvarContinuar"])) && !$this->validar()){
							$this->objDb->StartTrans();
							
							$oidLeilao = Criptografia::decodificar($this->objLeilaoVO->oidLeilao);
							if(is_numeric($oidLeilao) && intval($oidLeilao) > 0 && $this->objUsuarioBiz->podeAlterar($this->flgPermissaoAlterar)){
								
								$this->objLeilaoBiz->updateVO($this->objLeilaoVO);
							}else if($this->objUsuarioBiz->podeIncluir($this->flgPermissaoIncluir)){
								$this->objLeilaoVO->oidLeilao = $this->objLeilaoBiz->insertVO($this->objLeilaoVO);
								$oidLeilao = $this->objLeilaoVO->oidLeilao;
								
							}						
						
							$this->fechaTransacao(Constantes::ERRO01_NAO_SALVA);	
							if(isset($_POST["salvarContinuar"])){
								header("Location: leilao.php?sucesso=ok&id=" . Criptografia::codificar($oidLeilao));
							}else{
								$this->redirect();
							}
						}else if(isset($_POST["excluir"]) && $this->objUsuarioBiz->podeExcluir($this->flgPermissaoExcluir)){
							
							$this->objDb->StartTrans();
							$this->objLeilaoBiz->deleteVO($this->objLeilaoVO);
							$this->fechaTransacao(Constantes::ERRO01_NAO_EXCLUI);
							$this->redirect();
						}

						$this->excluirListaProposta();

					}else{
						$this->oidLeilao = (isset($_REQUEST["id"])) ? $_REQUEST["id"] : "";
						if($this->oidLeilao != "" && $this->objUsuarioBiz->podeVer($this->flgPermissaoVer)){
							$this->objLeilaoVO = $this->objLeilaoBiz->findByPK($this->oidLeilao);
							if(isset($_REQUEST["excluirImagem"]) && $this->objUsuarioBiz->podeExcluir($this->flgPermissaoExcluir)){
								$objArquivoPrincipal = new Arquivo($_REQUEST["excluirImagem"], $this->objLeilaoVO->$_REQUEST["excluirImagem"]);
								$objArquivoPrincipal->apaga($this->caminhoAbsArquivo, $this->objLeilaoVO->$_REQUEST["excluirImagem"]); 
								$this->objLeilaoVO->$_REQUEST["excluirImagem"] = "";
								$this->objLeilaoBiz->updateVO($this->objLeilaoVO);
							}
							if(!is_object($this->objLeilaoVO)) throw new Exception(Constantes::ERRO03_OPERACAO_INVALIDA);
							$this->bufferListagem();
						}else{
							$this->objLeilaoVO = new LeilaoVO;
							$this->objLeilaoVO->readForm();
							
						}
						$_SESSION["token"] = md5(uniqid(rand(), true)); //Evita CSRF
					}
				}catch(Exception $e){
					$this->objDb->CompleteTrans();
					$this->bufferListagem();			
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->mensagem = $e->getMessage();
				}	
			}
			

			/**
		 	 * Processa solicitações de Leilao provindas da entidade
			 * @access public
			 */
			public function solicitaLeilao(){
				try{			
					$this->objEntidadeBiz = new EntidadeBiz($this->objDb);
					$this->objEntidadeVO = new EntidadeVO;
					$this->objEntidadeVO = $this->objEntidadeBiz->findByFK(Criptografia::decodificar(Usuario::getOidUsuario()));
					$this->objLeilaoVO = new LeilaoVO;
					$this->listagem = "solicitaLeilaoLista.php";
					
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$this->objLeilaoVO->readForm();
						$this->objLeilaoVO->oidEntidade = (isset($this->objEntidadeVO->oidEntidade) ? $this->objEntidadeVO->oidEntidade : NULL);
						$this->objLeilaoVO->flgAprovado = "0"; //Somente aprovado após deliberação do administrador
						if(isset($_POST["salvar"]) && !$this->validarSolicitacao()){
							$this->objDb->StartTrans();
							$oidLeilao = Criptografia::decodificar($this->objLeilaoVO->oidLeilao);
							if(is_numeric($oidLeilao) && intval($oidLeilao) > 0){
								$this->objLeilaoBiz->updateVO($this->objLeilaoVO);
							}else{
								$this->objLeilaoVO->oidLeilao = $this->objLeilaoBiz->insertVO($this->objLeilaoVO);
								$oidLeilao = $this->objLeilaoVO->oidLeilao;
							}						
							$this->fechaTransacao(Constantes::ERRO01_NAO_SALVA);	
							$this->redirect();
						}
					}else{
						$this->oidLeilao = (isset($_REQUEST["id"])) ? $_REQUEST["id"] : "";
						if($this->oidLeilao != ""){
							$this->objLeilaoVO = $this->objLeilaoBiz->findByPK($this->oidLeilao);
							if(!is_object($this->objLeilaoVO)) throw new Exception(Constantes::ERRO03_OPERACAO_INVALIDA);
						}else{
							$this->objLeilaoVO = new LeilaoVO;
							$this->objLeilaoVO->readForm();
						}						
						$_SESSION["token"] = md5(uniqid(rand(), true)); //Evita CSRF
					}
				}catch(Exception $e){
					$this->objDb->CompleteTrans();
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->mensagem = $e->getMessage();
				}	
			}
			

			/**
		 	 * Processa agendamento de Leilao provindas da entidade
			 * @access public
			 */
			public function agendaLeilao(){
				try{			
					$this->objEntidadeBiz = new EntidadeBiz($this->objDb);
					$this->objEntidadeVO = new EntidadeVO;
					$this->objLeilaoVO = new LeilaoVO;
					$this->listagem = "agendaLeilaoLista.php";
					
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$this->objLeilaoVO->readForm();
						$this->objLeilaoVO->flgAprovado = "1"; // Aprovado após deliberação do administrador
						if(isset($_POST["salvar"]) && !$this->validar()){
							$this->objDb->StartTrans();
							$oidLeilao = Criptografia::decodificar($this->objLeilaoVO->oidLeilao);
							if(is_numeric($oidLeilao) && intval($oidLeilao) > 0){
								$this->objLeilaoBiz->updateVO($this->objLeilaoVO);
							}else{
								$this->objLeilaoVO->oidLeilao = $this->objLeilaoBiz->insertVO($this->objLeilaoVO);
								$oidLeilao = $this->objLeilaoVO->oidLeilao;
							}						
							$this->fechaTransacao(Constantes::ERRO01_NAO_SALVA);
							$this->redirect();
						}
					}else{
						$this->oidLeilao = (isset($_REQUEST["id"])) ? $_REQUEST["id"] : "";
						if($this->oidLeilao != ""){
							$this->objLeilaoVO = $this->objLeilaoBiz->findByPK($this->oidLeilao);
							if(!is_object($this->objLeilaoVO)) throw new Exception(Constantes::ERRO03_OPERACAO_INVALIDA);
							$this->objEntidadeVO = $this->objEntidadeBiz->findByPK($this->objLeilaoVO->oidEntidade,false);
						}else{
							$this->objLeilaoVO = new LeilaoVO;
							$this->objLeilaoVO->readForm();
						}						
						$_SESSION["token"] = md5(uniqid(rand(), true)); //Evita CSRF
					}
				}catch(Exception $e){
					$this->objDb->CompleteTrans();
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->mensagem = $e->getMessage();
				}	
			}			
			

			private function bufferListagem(){
				try{
								$this->bufferListagemProposta = $this->objPropostaBiz->listar("oidProposta", "proposta.php?popup=1","id", array("oidLeilao" => Criptografia::decodificar($this->objLeilaoVO->oidLeilao)), false, true, true);

				}catch(Exception $e){
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
		 	 * Monta grid de paginaÃ§Ã£o
			 * @access public
			 * @see LeilaoBiz
			 */
			public function listar(){
				try{		
				
					try{
						//DeleÃ§Ã£o em massa
						if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["excluirListaLeilao"]) && is_array($_POST["excluirListaLeilao"]) && $this->objUsuarioBiz->podeExcluir()){
							$this->objDb->StartTrans();
							foreach($_POST["excluirListaLeilao"] as $id) $this->objLeilaoBiz->deleteWhere("oidLeilao = '" . Criptografia::decodificar($id) . "'");
							$this->fechaTransacao(Constantes::ERRO01_NAO_EXCLUI);	
							header("Location: " . $this->listagem . "?sucesso=1");
						}		
					}catch(Exception $e){
						ControlaLog::fazLog($e, Constantes::LOGWARN);
						$this->objDb->CompleteTrans();					
						$this->mensagem = $e->getMessage();
					}	
				
				
					$this->arrFiltro["nome"] = "";
					$this->arrFiltroAlias["nome"] = "Nome";
					$this->arrFiltro["rce"] = "";
					$this->arrFiltroAlias["rce"] = "Crédito";
					$this->arrFiltro["numeroMaximoParticipantes"] = "";
					$this->arrFiltroAlias["numeroMaximoParticipantes"] = "Max. de Participantes";
					$this->arrFiltro["valorInicial"] = "";
					$this->arrFiltroAlias["valorInicial"] = "Valor Inicial";

					if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["filtrar"]) || isset($_GET["relatorio"])){ 
						if(isset($_GET["nome"]) && trim($_GET["nome"]) != "") $this->arrFiltro["nome"] = $_GET["nome"];
						if(isset($_GET["rce"]) && trim($_GET["rce"]) != "") $this->arrFiltro["rce"] = $_GET["rce"];
						if(isset($_GET["numeroMaximoParticipantes"]) && trim($_GET["numeroMaximoParticipantes"]) != "") $this->arrFiltro["numeroMaximoParticipantes"] = $_GET["numeroMaximoParticipantes"];
						if(isset($_GET["valorInicial"]) && trim($_GET["valorInicial"]) != "") $this->arrFiltro["valorInicial"] = $_GET["valorInicial"];

					}
					$this->bufferListagem = $this->objLeilaoBiz->listar("oidLeilao", "leilao.php","id", $this->arrFiltro, (isset($_GET["relatorio"]) && $_GET["relatorio"] == "1"), false, isset($_GET["popup"]) ? false : $this->flgPermissaoExcluir);
					if((isset($_GET["relatorio"]) && $_GET["relatorio"] == "1")){ 
						echo $this->bufferListagem;
						exit();
					}					
				}catch(Exception $e){
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->objDb->CompleteTrans();						
					$this->mensagem = $e->getMessage();
				}			
			}
	
			/**
		 	 * Monta grid de leilão abertos e pendentes de aprovação (agendamento)
			 * @access public
			 * @see LeilaoBiz
			 */
			public function listarPendente(){
				try{
					$this->objEntidadeBiz = new EntidadeBiz($this->objDb);
					$this->objEntidadeVO = new EntidadeVO();
					$this->objEntidadeVO = $this->objEntidadeBiz->findByFK(Criptografia::decodificar(Usuario::getOidUsuario()));
					$_REQUEST["filtro_oidEntidade_e"] = (isset($this->objEntidadeVO->oidEntidade) ? $this->objEntidadeVO->oidEntidade : NULL);
					$this->bufferListagem = $this->objLeilaoBiz->listarPendente("oidLeilao", "solicitaLeilao.php","id", $this->arrFiltro, (isset($_GET["relatorio"]) && $_GET["relatorio"] == "1"), false, isset($_GET["popup"]) ? false : $this->flgPermissaoExcluir);
				}catch(Exception $e){
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->objDb->CompleteTrans();						
					$this->mensagem = $e->getMessage();
				}			
			}
			
			
			/**
		 	 * Monta grid de leilão agendados e pendentes de aprovação (agendamento)
			 * @access public
			 * @see LeilaoBiz
			 */
			public function listarAgendar(){
				try{
					$this->bufferListagem = $this->objLeilaoBiz->listarAgendar("oidLeilao", "agendaLeilao.php","id", $this->arrFiltro, (isset($_GET["relatorio"]) && $_GET["relatorio"] == "1"), false, isset($_GET["popup"]) ? false : $this->flgPermissaoExcluir);
				}catch(Exception $e){
					ControlaLog::fazLog($e, Constantes::LOGWARN);
					$this->objDb->CompleteTrans();						
					$this->mensagem = $e->getMessage();
				}			
			}			
				
			private function validar(){
				if($_SESSION["token"] != $_POST["token"]) throw new Exception(Constantes::ERRO05_CSRF);
				$objFormulario = new Formulario();
				
				$objFormulario->addItem(new Text("oidLeilao",array(new Obrigatorio(),new Inteiro(11, true)), "ID"));
				$objFormulario->addItem(new Text("oidEntidade",array(new Obrigatorio(),new Inteiro(11, false)), "Entidade"));
				$objFormulario->addItem(new Text("rce",array(new Obrigatorio(),new Inteiro(11, false)), "Crédito"));
				$objFormulario->addItem(new Text("numeroMaximoParticipantes",array(new Obrigatorio(),new Inteiro(11, false)), "Max. de Participantes"));
				$objFormulario->addItem(new Text("dataLimiteProposta",array(new Obrigatorio(),new Data()), "Data Limite da Proposta"));
				$objFormulario->addItem(new Text("dataTermino",array(new Obrigatorio(),new Data()), "Data Término"));
				$objFormulario->addItem(new Text("valorInicial",array(new Obrigatorio(),new Float(10,2)), "Valor Inicial"));

				$objFormulario->validarItens();
			}
			
				
			private function validarSolicitacao(){
				if($_SESSION["token"] != $_POST["token"]) throw new Exception(Constantes::ERRO05_CSRF);
				if(intval($_POST["rce"]) > intval($this->objEntidadeVO->saldoRce)) throw new Exception(Constantes::ERRO12_CREDITO_INSUFICIENTE);
				$objFormulario = new Formulario();
				
				$objFormulario->addItem(new Text("oidLeilao",array(new Obrigatorio(),new Inteiro(11, true)), "ID"));
				$objFormulario->addItem(new Text("rce",array(new Obrigatorio(),new Inteiro(11, false)), "Créditos Ofertados"));
				$objFormulario->addItem(new Text("valorInicial",array(new Float(10,2)), "Valor Mínimo"));

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


			private function excluirListaProposta(){
				if(isset($_POST["excluirListaProposta"]) && is_array($_POST["excluirListaProposta"])){
					$this->objDb->StartTrans();
					$objPropostaVO = null;
					if(count($_POST["excluirListaProposta"]) > 0) $objPropostaVO = $this->objPropostaBiz->findByPK($_POST["excluirListaProposta"][0]);
					foreach($_POST["excluirListaProposta"] as $id) $this->objPropostaBiz->deleteWhere("oidProposta = '" . Criptografia::decodificar($id) . "'");
					$this->fechaTransacao(Constantes::ERRO01_NAO_EXCLUI);	
					header("Location: leilao.php?id=" . Criptografia::codificar($objPropostaVO->oidLeilao) . "&sucesso=1&ab=proposta");
				}	
			}


		}
	?>
	