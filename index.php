<?

#########################################################################
#	INCLUIMOS O ARQUIVO 
#########################################################################
	include("./secury-session.class.php");

#########################################################################
#
#	INICIA A CLASSE 
# 	Valores default:new session($type,$secury, $id_session);
#
#	$id_session:  é o ID da Sessão ou nome do Cookie 
#	$type:  "session" ou "cookie" 
#	$secury:  Define se será criptografado ou não os dados:   true/false  
#
#########################################################################
	$session = new session();

#########################################################################
#  INSERE OU ALTERA O VALOR DE UM ITEM
#########################################################################
	$session->set("nome_usuario", 'João da Silva');
	$session->set("login", 'admin');

#########################################################################
#  RESGATA O VALOR DE UMA VARIÁVE
#########################################################################
	$nome_usuario = $session->get("nome_usuario");

#########################################################################
#  FINALIZA SESSÃO E EXCLUI O COOKIE
#########################################################################
	$session->finish();



