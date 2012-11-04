<?php 
	session_start();
	ob_start();
	require_once("../classes/view/EntidadeUIView.php");
	$objEntidadeView = new EntidadeView();
	$objEntidadeView->iniciar();
	ob_end_flush();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=Constantes::SITE_TITULO?> :: Cadastro de Entidades</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css">
<link rel="stylesheet" type="text/css" href="css/leilao.css">
<link rel="stylesheet" type="text/css" href="css/dialogo.css">
<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="../css/leilaoIE8.css"><![endif]-->
<script src="js/jquery.js"></script>
<script src="js/jqueryUI/js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.meio.mask.js"></script>
<script type="text/javascript"> (function($){ $(function(){ $('input:text').setMask(); }  ); })(jQuery);</script>
</head>
<body>
<!-- Página Início -->
<div class="page">
<?php include "cabecalho.php"; ?>
<!-- Conteúdo Início -->
<div class="clear"></div>
<div class="content">
  <div id="content-titulo">Cadastro de Entidades</div>
  <div id="content-corpo">
<?php if($objEntidadeView->mensagem != "" || isset($_GET["sucesso"])){ ?>  
  <div id="content-mensagem">
    <?php if($objEntidadeView->mensagem != ""){ ?>
    <div class="mensagem erro" id="erro"><?=str_replace("\n", "<br>", $objEntidadeView->mensagem)?></div>
    <?php }else if(isset($_GET["sucesso"])){ ?>
    <div class="mensagem ok" id="ok"><?=$_GET["sucesso"]?></div>
    <?php } ?>
  </div>
<?php } ?>
  <!-- Miolo inicio -->
<form  enctype="multipart/form-data" action="entidade.php" method="post" name="frmEntidade" id="frmEntidade">
<input type="hidden" name="token" value="<?=$_SESSION["token"]?>" />
<input type="hidden" name="oidEntidade" value="<?php echo $objEntidadeView->objEntidadeVO->oidEntidade == "" ? "0" : $objEntidadeView->objEntidadeVO->oidEntidade ?>">  
  <div class="formulario">
  	<div id="linha">
        <div id="rotulo" class="rotulo">Raz&atilde;o Social:</div>
        <div id="campo" class="w60"><input name="razaoSocial" maxlength="255" type="text" class="campo input" id="razaoSocial" value="<?php echo $objEntidadeView->objEntidadeVO->razaoSocial ?>" /></div>
    </div>
  	<div id="linha">
        <div id="rotulo" class="rotulo">Endere&ccedil;o:</div>
        <div id="campo" class="w60"><input name="endereco" maxlength="255" type="text" class="campo input" id="endereco" value="<?php echo $objEntidadeView->objEntidadeVO->endereco ?>" /></div>
    </div>
  	<div id="linha">
        <div id="rotulo" class="rotulo">CNPJ:</div>
        <div id="campo" class="w20"><input name="cnpj" maxlength="18" type="text" class="campo input" id="cnpj" alt="cnpj" value="<?php echo $objEntidadeView->objEntidadeVO->cnpj ?>" /></div>
        <div id="rotulo" class="rotulo">Cr&eacute;ditos de Carbono:</div>
        <div id="campo" class="w20"><input name="saldoRce" maxlength="11" type="text" class="campo input" id="saldoRce" value="<?php echo $objEntidadeView->objEntidadeVO->saldoRce ?>" /></div>
    </div>
    <div id="separador">Respons&aacute;vel pela Empresa</div>
  	<div id="linha">
        <div id="rotulo" class="rotulo">Nome:</div>
        <div id="campo" class="w60"><input name="nome" maxlength="100" type="text" class="campo input" id="nome" value="<?php echo $objEntidadeView->objUsuarioVO->nome ?>" /></div>
    </div>
  	<div id="linha">
        <div id="rotulo" class="rotulo">CPF:</div>
        <div id="campo" class="w20"><input name="cpf" maxlength="14" type="text" class="campo input" id="cpf" alt="cpf" value="<?php echo $objEntidadeView->objUsuarioVO->cpf ?>" /></div>
        <div id="rotulo" class="rotulo">Telefone:</div>
        <div id="campo" class="w20"><input name="telefone" maxlength="15" type="text" class="campo input" id="telefone" alt="phone" value="<?php echo $objEntidadeView->objUsuarioVO->telefone ?>" /></div>
    </div>
  	<div id="linha">
        <div id="rotulo" class="rotulo">Senha:</div>
        <div id="campo" class="w20"><input name="senha" type="password" maxlength="20" class="campo input" id="senha" /></div>
        <div id="rotulo" class="rotulo">Confirmar:</div>
        <div id="campo" class="w20"><input name="confere" type="password" maxlength="20" class="campo input" id="confere" /></div>
    </div>
    <div id="botoes">
        <input type="submit" name="salvar" id="salvar" class="botao ok" value="Cadastrar" />
		<input type="button" name="cancelar" id="btCancelar" class="botao cancelar" value="Cancelar" onClick="javascript:history.back();" />    
        </div>
  </div>
  </form>  
  <!-- Miolo fim -->
  </div>
</div>
<!-- Conteúdo Fim -->
<?php include "rodape.php"; ?>
</div>
<!-- Página Fim -->
<script src="js/padrao.js"></script>
</body>
</html>
