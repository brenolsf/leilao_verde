<?php
	session_start();
	ob_start();
	require_once("../classes/view/IndexView.php");
	$objIndexView = new IndexView;
	$objIndexView->iniciarLogado();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=Constantes::SITE_TITULO?> :: Principal</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css">
<link rel="stylesheet" type="text/css" href="css/leilao.css">
<link rel="stylesheet" type="text/css" href="css/dialogo.css">
<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="../css/leilaoIE8.css"><![endif]-->
<script src="js/jquery.js"></script>
<script src="js/jqueryUI/js/jquery-ui-1.8.16.custom.min.js"></script>
</head>
<body>
<!-- Página Início -->
<div class="page">
<?php include "cabecalho.php"; ?>
<!-- Conteúdo Início -->
<div class="clear"></div>
<div class="content">
  <div id="content-titulo">Principal</div>
  <div id="content-corpo">
  <!-- Miolo inicio -->
  <div class="bemVindo">
  <img src="img/principal.jpg" width="372" height="207" />
<p>Olá, seja bem vindo <?=Usuario::getNomeUsuario();?>!</p>
<br>
<br>
<p>Para começar o processo de oferta de créditos ou para realizar uma proposta em algum leilão em andamento, basta utilizar o menu &quot;Meus Recursos&quot; localizado no topo direito da página utilizando as suas ferramentas necessárias para o seu objetivo.</p>
<br>
<br>
<p>Bons negócios!</p><br />
<br />

</div>
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
