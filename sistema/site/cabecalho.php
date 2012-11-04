<!-- Cabeçalho Início -->
<div class="header">
  <div id="header-logo"><a href="principal.php"><img src="img/px.png" width="150" height="90" border="0" /></a></div>
    <div id="header-titulo">
        <span id="sistema"><?=Constantes::SITE_TITULO?></span><br />
        <span id="orgao">PUC MG</span>    </div>
<?php if(Usuario::getOidUsuario() != ""){ ?>  
  <div id="header-status">Voc&ecirc; est&aacute; logado como: <span class="negrito"><?=Usuario::getNomeUsuario()?></span><!--<br />Entidade: <span class="negrito">NOME DA EMPRESA</span> --></div>
<?php } ?>    
  <br clear="right" />
<?php if(Usuario::getOidUsuario() != ""){ ?>
  <!-- Menu Início -->
  <div id="menu-wrapper">
  <?php if(Usuario::eAdministrador()){ ?>
    <ul id="menu">
      <li><a href="javascript:void(0);">Meus Recursos</a><ul><li><a href="agendaLeilaoLista.php">Agendar Leil&atilde;o</a></li></ul></li>
      <li class="menu-separador"><img src="img/menu-split.png" /></li>
      <li id="menu-sair"><a href="sair.php">Sair</a></li>
    </ul>
  <?php }else{ ?>
    <ul id="menu">
      <li><a href="javascript:void(0);">Meus Recursos</a><ul><li><a href="solicitaLeilaoLista.php">Solicitar Leil&atilde;o</a></li></ul></li>
      <li class="menu-separador"><img src="img/menu-split.png" /></li>
      <li id="menu-sair"><a href="sair.php">Sair</a></li>
    </ul>
  <?php } ?>
    <div class="clear"></div>
  <? //=$objEntidadeView->menu?>
    <!--<ul id="menu">
      <li><a href="#">Parent 01</a></li>
      <li><a href="#">Teste de tamanho de texto variando</a>
        <ul>
          <li><a href="#">Item 01</a></li>
          <li><a href="#">Item 02</a></li>
          <li><a href="#">Item 03</a></li>
        </ul>
        <div class="clear"></div>
      </li>
      <li><a href="#">Parent 03</a>
        <ul>
          <li><a href="#">Item 04</a></li>
          <li><a href="#">Item 05</a></li>
          <li><a href="#">Item 06</a></li>
          <li><a href="#">Item 07</a></li>
        </ul>
        <div class="clear"></div>
      </li>
      <li><a href="#">Parent 04</a></li>
      <li class="menu-separador"><img src="img/menu-split.png" /></li>
      <li id="menu-sair"><a>Sair</a></li>
    </ul>
    <div class="clear"></div>
  </div> -->
  <!-- Menu Fim -->
	</div>  
<?php } ?>    
</div>
<!-- Cabeçalho Fim -->