<?php
class Application {
	private $com;
	private $msg;
	private $id;
	private $regions;
	public function __construct($com, $msg, $id) {
		if ($com == '') {
			$this->com = 'index';
		} else {
			$this->com = $com;
		}
		$this->msg = $msg;
		$this->id = $id;
		$this->regions = array ();
		$this->regions ['leftcol'] = '';
		$this->regions ['content'] = '';
	}
	public function run() {
		echo "\r\n</br>\r\n";
		session_start ();
		if (! isset ( $_SESSION ['name'] ) && ($this->com != 'login') && ($this->com != 'verify')) {
			header ( "Location:/admin/login" );
			return '';
		}
		if (($this->com != 'login') && ($this->com != 'verify')) {
			$mainmenu = new AdminMenu ();
			$mainmenu->Load ();
			$this->regions ['leftcol'] = $mainmenu->Display ();
		}
		switch ($this->com) {
			case 'login' :
				$this->regions ['content'] = template_out ( 'login', array (
						'msg' => $this->msg 
				) );
				break;
			case 'logout' :
				$_SESSION = array ();
				setcookie ( session_name (), "", time () - 3600 );
				session_destroy ();
				header ( "Location: /admin/login/You are successfully logged out" );
				return '';
			case 'verify' :
				$user = new User ( $_POST ['user'], $_POST ['pass'] );
				if ($user->CheckUser ()) {
					header ( "Location:/admin" );
				} else {
					header ( "Location:/admin/login/Incorrect username or password" );
				}
				return '';
			case 'adminmenu' :
				$this->regions ['content'] = $mainmenu->Edit ();
				break;
			case 'index' :
				$Nodes = new NodeList ($this->msg);
				$this->regions ['content'] = $Nodes->display ();
				break;
			case 'add' :
				$Node = new Node ( $this->msg, node_schema($this->msg) );
				$this->regions ['content'] = $Node->EditForm ();
				break;
			case 'put' :
				$Node = new Node ( $this->msg, $_POST );
				if ($Node->PutNode ( ) === TRUE) {
					header ( "Location:/admin" );
					return '';
				} else {
					return 'Error create new node';
				}
				
			case 'edit' :				
				$Node = new Node ( $this->msg, array (
						'id' => $this->id 
				) );
				$Node->GetNode ();
				$this->regions ['content'] = $Node->EditForm ();
				break;
			default :
		}
		return template_out ( 'admin', array (
				'title' => 'Administration Panel',
				'content' => $this->regions ['content'],
				'leftcol' => $this->regions ['leftcol'] 
		) );
	}
}