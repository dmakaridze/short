<?php
class Node {
	private $properties = array ();
	private $type;
	public function __construct($type, $values) {
		$this->properties = $values;
		$this->type = $type;
	}
	public function __get($property) {
		return $property;
	}
	public function PutNode() {
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$allcolumns = node_schema ( $this->properties ['type'] );
		$collumns = array();
		foreach ( $allcolumns as $column => $value ) {
			$values [$column] = $this->properties [$column];
			$collumns [] = $column;
			if (is_string ( $values [$column] )) {
				$values [$column] = htmlspecialchars ( $values [$column] );
			}
		}
		if ($this->properties ['id'] == 0) {
			$collumns = implode ( ",", $collumns );
			$values = "'" . implode ( "','", $values ) . "'";
			$result = $db->query ( "INSERT INTO {$this->properties ['type']} ($collumns) VALUES ($values)" );
			if ($result) {
				$db->close ();
				return TRUE;
			}
		} else {
			$nid = $this->properties ['id'];
			$settings = "";
			foreach ( $values as $key => $value ) {
				$settings .= "$key='$value',";
			}
			$settings = rtrim ( $settings, ',' );
			$result = $db->query ( "UPDATE {$this->properties ['type']} SET $settings WHERE id= $nid" );
			if ($result) {
				$db->close ();
				return TRUE;
			}
		}
	}
	public function GetNode() {
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$nid = $this->properties ['id'];
		$result = $db->query ( "SELECT * FROM $this->type WHERE id = $nid" );
		if ($result) {
			while ( $Node = $result->fetch_array ( MYSQLI_ASSOC ) ) {
				$this->properties = $Node;
			}
			$result->close ();
		}
	}
	public function EditForm() {
		return template_out ( "edit-{$this->type}-form", array_merge ( $this->properties, array (
				'type' => $this->type 
		) ) );
	}
}