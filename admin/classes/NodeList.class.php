<?php
class NodeList {
	private $Nodes;
	private $Type;
	public function display() {
		$render = '<table>';
		if (is_array ( $this->Nodes )) {
			foreach ( $this->Nodes as $Node ) {
				$render .= sprintf ( "<tr><td>%s</td><td><a href=\"/admin/edit/%s/%d\">Edit</a></td><td></td></tr>", $Node ['title'], $this->Type, $Node ['id'] );
			}
		}
		$render .= '</table>';
		return $render;
	}
	function __construct($type) {
		$dbConf = new DBConfig ();
		$db = new mysqli ( $dbConf->host(), $dbConf->user(), $dbConf->password(), $dbConf->name() );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$this->Type = $type;
		$result = $db->query ( "SELECT * FROM $this->Type" );
		if ($result) {
			while ( $Node = $result->fetch_array ( MYSQLI_ASSOC ) ) {
				$this->Nodes [] = $Node;
			}
			$result->close ();
		}
	}
}