<?php
	session_start();
	ob_start();
	require_once("../classes/view/IndexView.php");
	$objIndexView = new IndexView;
	$objIndexView->iniciar();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=Constantes::SITE_TITULO?> :: Login</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<link rel="stylesheet" type="text/css" href="css/leilao.css">
<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="../css/leilaoIE8.css"><![endif]-->
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/tipTip.css">
<script src="js/jquery.js"></script>
<script src="js/jquery.meio.mask.js"></script>
<script type="text/javascript"> (function($){ $(function(){ $('input:text').setMask(); }  ); })(jQuery);</script>
<script src="js/jquery.tipTip.minified.js"></script>
</head>
<body>
<!-- Página Início -->
<div class="page">
  <!-- Conteúdo Início -->
  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
        <td width="580" nowrap="nowrap">
          <div id="content-header">
        	<span id="sistema">Leil&atilde;o Verde</span><br />
            <span id="orgao">PUC MG</span>          </div>
        <div id="content-corpo">
            <div id="content-titulo">Login</div>
            <?php if($objIndexView->mensagem != ""){ ?>
            <div id="content-mensagem">
              <div class="mensagem erro" id="erro"><?php echo str_replace("\n", "<br>", $objIndexView->mensagem); ?></div>
            </div>
            <?php } ?>
            <div id="content-wrap">
            <form action="index.php" method="post" autocomplete="off">
            <div align="center">
              <div class="rotuloWrap"><span class="rotuloTexto" id="login">Informe seu CNPJ</span>
                <input type="text" name="login" class="campo login" id="username" alt="cnpj" title="Informe somente os números do CNPJ utilizados em seu cadastro!" />
              </div>
              <br />
              <br />
              <div class="rotuloWrap"><span class="rotuloTexto" id="senha">Informe sua Senha</span>
                <input type="password" name="senha" class="campo login" id="password" />
                <br />
              </div>
              <br />
              <br />
            </div>
            <a href="entidade.php" id="esqueceuSenha">N&atilde;o sou cadastrado!</a>
            <input type="submit" class="botao login" id="Entrar" value="Entrar" name="salvar" />
            </form>
          </div>
        </div></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <!-- Conteúdo Fim -->
</div>
<!-- Página Fim -->
<script src="js/login.js"></script>
<script src="js/padrao.js"></script>
</body>
</html>
