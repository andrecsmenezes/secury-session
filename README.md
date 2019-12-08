## Sessões e Cookies seguros e criptografados
Classe PHP para Cookie e Sessions seguros e criptografados.
O funcionamento dele é bem simples.
Vamos importar o arquivo:

	include("./secury-session.class.php");

Iniciamos a classe:

     $session = new session();

## Variáveis da classe

Valores default:

    $session = new session($type="session",$secury=true, $id_session);

|Type|Significado  |
|--|--|
| $type|  Tipo de armazenamento: "*session*" ou "*cookie*" |
| $secury |  Define se criptografa ou não os dados:   **true/false**  | 
| $id_session | É o ID da Sessão ou nome do Cookie |


## Insere ou altera o valor de um ítem
	$session->set("nome_usuario", 'João da Silva');


## Resgata o valor de uma variável
	$nome_usuario = $session->get("nome_usuario");


## Finaliza sessão e exclui o cookie
	$session->finish();

## Criptografia
	
Os dados são criptografados de maneira diferente entre a sessão e o cookie.
O Cookie é convertido para JSON em uma string inteira  e criptografado em um bloco apenas, enquanto a sessão, é item por item.

Isso se deve pelo fato de que o **setcookie** no PHP não nos oferece a inserção do **SameSite=Strict**.
Isso eu consegui fazer inserindo pelo `header("Set-Cookie:")` 
Porém essa "*gambiarra*", não permite inserir múltiplos cookies, então, utilizo apenas um, transformando ele em JSON. 

E, quando pesquiso algum item no cookie, ele dá um `json_decode` e retorna o item que preciso. Ficou simples e funciona como uma luva.

### Exemplo de criptografia:
Nosso código fica assim:

	$session = new session("cookie");
	$session->set("nome_usuario", 'João da Silva');
	$session->set("login", 'admin');

Nosso ***$_COOKIE*** fica assim:

	Array([Vh8CRlYqCh8GRAIhUwYMGQUAV1lUEFVC] => {
		"ViYCcFZiCj0GbAJ0UzoMAwUMV2RUPlVgBTAEXwR5DnsFcARlByRXbwFt":"VhwCbVbECvgGagIsUzEMPQVzV1lUOFVhBSMEYQ",
		"ViYCcFZiCj0GbAJ0UzoMAwUMV2ZUPlVqBTwEbg":"VjcCZlZqCjIGaw"
	})

Já a nossa ***$_SESSION*** fica assim:

	Array(
		[VjgCbVZqCj4GWgJ5UyYMKQUyV3hUOFVi] => VhwCbVbECvgGagIsUzEMPQVzV1lUOFVhBSMEYQ
		[VjoCbVZgCjIGaw] => VjcCZlZqCjIGaw
	)


###  APROVEITEM =)