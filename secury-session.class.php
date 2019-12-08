<?
class session {
	private $type;
	private $preStr;
	private $cookieMap = array();
	private $nameCookie;
	private $duratacookie;
	private $secret;
	public function __construct($type="session", $secury=1, $id_session="ID-DA-SESSAO") {
		$this->prefixCoockie = "prefixo__";
		$this->type = $type;
		$this->secury = $secury;
		$this->secret = "qfug0872g34yufbowiyu349f762g349oyfi34gf97364gf";
		$this->nameCookie = $this->crypta($id_session);
		$this->cookieMap = json_decode($this->getCookies() , true);
		ini_set("session.gc_maxlifetime", "432000");
		ini_set("url_rewriter.tags", "");
		ini_set("session.cookie_secure", 'on');
		ini_set("session.cookie_httponly", true);
		ini_set("session.use_trans_sid", false);
		ini_set("session.cookie_samesite", 'strict');
		ini_set('session.use_only_cookies', true);
		
		if ($this->type == "session") {
			if (empty($_COOKIE) || !array_key_exists('feats', $_COOKIE)) {
				setcookie('feats', $this->crypta($id_session) , time() + 3600, '/', $_SERVER['SERVER_NAME'], true, true);
			}
			else {
				$id_session = $_COOKIE['feats'];
			}
			session_id($this->nameCookie);
			session_name("feats-acess-session");
			session_start();
		}
	}

	public function getCookies() {
		$cookie = '{}';
		if (isset($_COOKIE) && array_key_exists($this->nameCookie, $_COOKIE)) {
			$cookie = $_COOKIE[$this->nameCookie];
		}
		else {
			foreach (headers_list() as $key => $value) {
				$itens = explode(";", $value);
				$cookie_string = $itens[0];
				$value = explode($this->nameCookie . "=", $cookie_string);
				if (trim($value[0]) == 'Set-Cookie:') {
					$cookie = $value[1];
					break;
				};
			}
		}
		return $cookie;
	}
	public function updateCookie($value,$time=null) {
		if($time==null){
			$time = (60 * 60);
		}else{
			$time = 0;
		}
		header("Set-Cookie: " . $this->nameCookie . "=" . $value . "; SameSite=Strict; HttpOnly;Max-Age=".$time."; path=/; expires=" . date("l dS of F Y h:i:s A", time() + 3600 * 24) . "; domain=" . $_SERVER['SERVER_NAME'] . ";");
	}
	public function set($var, $value) {
		if ($this->type == "cookie") {
			if ($this->secury == 1) {
				$this->cookieMap = json_decode($this->getCookies() , true);
				$this->cookieMap[$this->crypta($this->prefixCoockie . $var) ] = $this->crypta($value);
				$this->updateCookie(json_encode($this->cookieMap));
			}
			else {
				$this->cookieMap = json_decode($this->getCookies());
				$this->cookieMap[$this->prefixCoockie . $var] = $value;
				$this->updateCookie(json_encode($this->cookieMap));
			}
		}
		else {
			if ($this->secury == 1) {
				$_SESSION[$this->crypta($var) ] = $this->crypta($value);
			}
			else {
				$_SESSION[$var] = $value;
			}
		}
	}
	public function get($var) {
		if ($this->type == "cookie") {
			$this->cookieMap = json_decode($this->getCookies() , true);
			if ($this->secury == 1) {
				return $this->decrypta($this->cookieMap[$this->crypta($this->prefixCoockie . $var) ]);
			}
			else {
				return $this->cookieMap[$this->prefixCoockie . $var];
			}
		}
		else {
			if ($this->secury == 1) {
				return $this->decrypta($_SESSION[$this->crypta($var) ]);
			}
			else {
				return $_SESSION[$var];
			}
		}
	}
	public function finish() {
		if ($this->type == "cookie") {
			$this->updateCookie(null,true);
		}else{
			session_destroy();
			$_SESSION = array();
		}
	}
	private function crypta($t) {
		if ($t == "") return $t;
		$r = md5(10);
		$c = 0;
		$v = "";
		for ($i = 0;$i < strlen($t);$i++) {
			if ($c == strlen($r)) $c = 0;
			$v .= substr($r, $c, 1) . (substr($t, $i, 1) ^ substr($r, $c, 1));
			$c++;
		}
		return (str_replace("=", "", base64_encode($this->ed($v))));
	}
	private function decrypta($t) {
		if ($t == "") return $t;
		$t = $this->ed(base64_decode(($t)));
		$v = "";
		for ($i = 0;$i < strlen($t);$i++) {
			$md5 = substr($t, $i, 1);
			$i++;
			$v .= (substr($t, $i, 1) ^ $md5);
		}
		return $v;
	}
	private function ed($t) {
		$r = md5($this->secret);
		$c = 0;
		$v = "";
		for ($i = 0;$i < strlen($t);$i++) {
			if ($c == strlen($r)) $c = 0;
			$v .= substr($t, $i, 1) ^ substr($r, $c, 1);
			$c++;
		}
		return $v;
	}
}

