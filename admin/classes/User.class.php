<?php
class User {
	private $name;
	private $password;
	public function __construct($name, $password) {
		$this->name = $name;
		$this->password = md5 ( $password );
	}
	public function CheckUser() {
		$fp = fopen ( APPREALPATH . '/data.txt', 'a' );
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$username = $this->name;
		$result = $db->query ( "SELECT * FROM user WHERE name='$username'" );
		if ($result) {
			$user = $result->fetch_array ( MYSQLI_ASSOC );
			$result->close ();
			if ($username == $user ['name'] && $this->password == $user ['password']) {
				$_SESSION ['name'] = $username;
				$_SESSION ['gid'] = $user ['gid'];
				$_SESSION ['uid'] = $user ['uid'];
				$db->close ();
				return TRUE;
			} else {
				$db->close ();
				return FALSE;
			}
		}
	}
}