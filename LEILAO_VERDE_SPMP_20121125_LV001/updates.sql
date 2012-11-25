TRUNCATE TABLE `leilao`.`log4miga`;
INSERT INTO `leilao`.`perfil`(`oidPerfil`,`nome`) VALUES ( '2','Entidade');
INSERT INTO `leilao`.`perfiltela`(`oidTela`,`oidPerfil`) VALUES ( '26','2');

INSERT INTO `leilao`.`tela`(`oidTela`,`nome`,`descricao`,`link`,`flgApareceMenu`,`ajuda`,`parametro`,`ordem`) VALUES ( 31,'Solicitar Leilão',NULL,'solicitaLeilaoLista.php','1',NULL,NULL,'0');
INSERT INTO `leilao`.`tela`(`oidTela`,`nome`,`descricao`,`link`,`flgApareceMenu`,`ajuda`,`parametro`,`ordem`) VALUES ( 32,'Solicitar Leilão',NULL,'solicitaLeilao.php','1',NULL,NULL,'0');
INSERT INTO `leilao`.`perfiltela`(`oidTela`,`oidPerfil`) VALUES ( '31','2');
INSERT INTO `leilao`.`perfiltela`(`oidTela`,`oidPerfil`) VALUES ( '32','2');
INSERT INTO `leilao`.`telagrupo`(`oidGrupo`,`oidTela`) VALUES ( '1','31');
INSERT INTO `leilao`.`telagrupo`(`oidGrupo`,`oidTela`) VALUES ( '1','32');

INSERT INTO `leilao`.`tela`(`oidTela`,`nome`,`descricao`,`link`,`flgApareceMenu`,`ajuda`,`parametro`,`ordem`) VALUES ( 33,'Agendar Leilão',NULL,'agendaLeilaoLista.php','1',NULL,NULL,'0');
INSERT INTO `leilao`.`tela`(`oidTela`,`nome`,`descricao`,`link`,`flgApareceMenu`,`ajuda`,`parametro`,`ordem`) VALUES ( 34,'Agendar Leilão',NULL,'agendaLeilao.php','1',NULL,NULL,'0');
INSERT INTO `leilao`.`perfiltela`(`oidTela`,`oidPerfil`) VALUES ( '33','1');
INSERT INTO `leilao`.`perfiltela`(`oidTela`,`oidPerfil`) VALUES ( '34','1');
INSERT INTO `leilao`.`telagrupo`(`oidGrupo`,`oidTela`) VALUES ( '1','33');
INSERT INTO `leilao`.`telagrupo`(`oidGrupo`,`oidTela`) VALUES ( '1','34');