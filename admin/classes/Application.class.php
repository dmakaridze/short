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
		session_start ();
		if (! isset ( $_SESSION ['name'] ) && ($this->com != 'login') && ($this->com != 'verify')) {
			header ( "Location:/admin/login" );
			return TRUE;
		}
		if (($this->com != 'login') && ($this->com != 'verify')) {
			$mainmenu = new AdminMenu ();
			$mainmenu->Load ();
			$this->regions ['leftcol'] = $mainmenu->Display ();
		}
		switch ($this->com) {
			case 'login' :
				$this->regions ['content'] = template_out ( 'Login', array (
						'msg' => $this->msg 
				) );
				break;
			case 'logout' :
				$_SESSION = array ();
				setcookie ( session_name (), "", time () - 3600 );
				session_destroy ();
				header ( "Location: /admin/login/You are successfully logged out" );
				return TRUE;
			case 'verify' :
				$user = new User ( $_POST ['user'], $_POST ['pass'] );
				if ($user->CheckUser ()) {
					header ( "Location:/admin" );
				} else {
					header ( "Location:/admin/login/Incorrect username or password" );
				}
				return TRUE;
			case 'adminmenu' :
				$this->regions ['content'] = $mainmenu->Edit ();
				break;
			case 'index' :
				$Nodes = new NodeList ($this->msg);
				$this->regions ['content'] = $Nodes->display ();
				break;
			case 'add' :
				require_once APPREALPATH . '/admin/inc/nodeSchema.php';
				$Node = new Node ( $this->msg, nodeSchema($this->msg) );
				$this->regions ['content'] = $Node->EditForm ();
				break;
			case 'putnode' :
				$Node = new Node ( $this->msg, $_POST );
				if ($Node->PutNode ( ) === TRUE) {
					header ( "Location:/admin" );
				}
				break;
			case 'editnode' :				
				$Node = new Node ( $this->msg, array (
						'nid' => $this->id 
				) );
				$Node->GetNode ();
				$this->regions ['content'] = $Node->EditForm ();
				break;
			default :
		}
		print template_out ( 'Admin', array (
				'title' => 'Administration Panel',
				'content' => $this->regions ['content'],
				'leftcol' => $this->regions ['leftcol'] 
		) );
	}
}