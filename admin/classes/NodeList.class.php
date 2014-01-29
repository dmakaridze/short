<?php
class NodeList {
	private $Nodes;
	public function display() {
		$render = '<table>';
		if (is_array ( $this->Nodes )) {
			foreach ( $this->Nodes as $Node ) {
				$render .= sprintf ( "<tr><td>%s</td><td><a href=\"/admin/edit/%s/%d\">Edit</a></td><td></td></tr>", $Node ['title'], $Node ['type'], $Node ['id'] );
			}
		}
		$render .= '</table>';
		return $render;
	}
	function __construct($type) {
		if ($type == '') {
			$tables = node_types ();
		} elseif (in_array ( $type, node_types () )) {
			$tables = array (
					$type 
			);
		} else {
			die ( "$type is invalid node type!" );
		}
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		foreach ( $tables as $tb ) {
			$result = $db->query ( "SELECT * FROM $tb" );
			if ($result) {
				while ( $Node = $result->fetch_array ( MYSQLI_ASSOC ) ) {
					$this->Nodes [] = $Node;
				}
				$result->close ();
			}
		}
	}
}