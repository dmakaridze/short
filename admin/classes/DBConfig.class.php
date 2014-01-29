<?php
require_once APPREALPATH . '/admin/config/dbconfig.php';
class DBConfig {
	private $host;
	private $user;
	private $password;
	private $name;
	public function __construct() {
		$this->host = SHORTDBHOST;
		$this->user = SHORTDBUSER;
		$this->password = SHORTDBPASSWORD;
		$this->name = SHORTDBNAME;
	}
	public function host() {
		return $this->host;
	}
	public function user() {
		return $this->user;
	}
	public function password() {
		return $this->password;
	}
	public function name() {
		return $this->name;
	}
}