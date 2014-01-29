<?php
class AdminMenu {
	private $items = array ();
	private function &finditem(&$array, $key) {
		$return = NULL;
		if (isset ( $array [$key] )) {
			$return = &$array [$key];
		} else {
			foreach ( $array as $item ) {
				if (is_array ( $item )) {
					$return = &finditem ( $array, $key );
				}
			}
		}
		return $return;
	}
	private function printmenu($menu, $menuid = NULL) {
		$htmlmenu = "<ul" . ($menuid ? " id=\"$menuid\"" : "") . ">\r\n";
		foreach ( $menu as $item ) {
			$title = $item ['title'];
			$command = $item ['command'];
			$htmlmenu .= "<li><a href=\"$command\">$title</a>";
			
			if (isset ( $item ['children'] )) {
				if (is_array ( $item ['children'] )) {
					$htmlmenu .= $this->printmenu ( $item ['children'] );
				}
			}
			$htmlmenu .= "</li>\r\n";
		}
		$htmlmenu .= "</ul>\r\n";
		return $htmlmenu;
	}
	public function Display() {
		$htmlmenu = "<div id=\"admin-menu\">";
		$htmlmenu .= $this->printmenu ( $this->items, 'menu' );
		$htmlmenu .= "</div>";
		return $htmlmenu;
	}
	public function Load() {
		$dbConf = new DBConfig ();
		$db = new mysqli ( $dbConf->host(), $dbConf->user(), $dbConf->password(), $dbConf->name() );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		
		if (isset ( $_SESSION ['gid'] )) {
			$gid = $_SESSION ['gid'];
			$result = $db->query ( "SELECT * FROM adminmenu LEFT JOIN permissions
					ON adminmenu.pid=permissions.pid WHERE gid='$gid'" );
			if ($result) {
				while ( $adminmenuitem = $result->fetch_array ( MYSQLI_ASSOC ) ) {
					$this->items [$adminmenuitem ['mid']] = $adminmenuitem;
				}
				$result->close ();
				uasort ( $this->items, function ($a, $b) {
					return ($a ['weight'] > $b ['weight']);
				} );
				while ( list ( $mid, $adminmenuitem ) = each ( $this->items ) ) {
					if ($adminmenuitem ['parent'] > 0) {
						$currentitem = $adminmenuitem;
						unset ( $this->items [$mid] );
						if ($item = &$this->finditem ( $this->items, $currentitem ['parent'] )) {
							$item ['children'] [$mid] = $currentitem;
						}
					}
				}
			}
		}
		$db->close ();
	}
	public function Edit() {
		$htmlcontent = '<div id="content">';
		$dbConf = new DBConfig ();
		$db = new mysqli ( $dbConf->host(), $dbConf->user(), $dbConf->password(), $dbConf->name() );
		
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$command = '/' . $_GET ['page'] . '/' . $_GET ['com'];
		$gid = $_SESSION ['gid'];
		$result = $db->query ( "SELECT * FROM adminmenu LEFT JOIN permissions ON adminmenu.pid=permissions.pid WHERE gid=$gid AND command='$command'" );
		if ($result) {
			$permission = $result->fetch_array ( MYSQLI_ASSOC );
			if (! is_array ( $permission )) {
				$htmlcontent .= '<div id="message">You don\'t have permission to access this page!</div>';
			} else {
				$result = $db->query ( "SELECT * FROM adminmenu" );
				if ($result) {
					while ( $adminmenuitem = $result->fetch_array ( MYSQLI_ASSOC ) ) {
						$adminmenu [$adminmenuitem ['mid']] = $adminmenuitem;
					}
					$result->close ();
					uasort ( $adminmenu, function ($a, $b) {
						return ($a ['weight'] > $b ['weight']);
					} );
					$htmlcontent .= '<table border=0 id="adminmenuitems">';
					$odd = TRUE;
					foreach ( $adminmenu as $mid => $adminmenuitem ) {
						$format = "<tr class=\"%s\"><td>%d</td><td>%d</td><td>%d</td><td>%d</td><td>%s</td><td>%s</td></tr>";
						$htmlcontent .= sprintf ( $format, ($odd ? 'odd' : 'even'), $adminmenuitem ['mid'], $adminmenuitem ['pid'], $adminmenuitem ['parent'], $adminmenuitem ['weight'], $adminmenuitem ['title'], $adminmenuitem ['command'] );
						$odd = ! $odd;
					}
					$htmlcontent .= '</table>';
				}
			}
		}
		$htmlcontent .= '</div>';
		$db->close ();
		return $htmlcontent;
	}
}
