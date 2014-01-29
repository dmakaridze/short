<?php
class Node {
	private $properties = array ();
	private $type;
	public function __construct($type, $values) {
		$this->properties = $values;
		$this->type=$type;
	}
	public function __get($property) {
		return $property;
	}
	public function PutNode($tablename) {
		$dbConf = new DBConfig ();
		$db = new mysqli ( $dbConf->host (), $dbConf->user (), $dbConf->password (), $dbConf->name () );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
	$NodeType = new NodeType($this->properties ['type']);
		$columns = $NodeType->Fields();
		$allcolumns = '';
		foreach ( $columns as $column ) {
			$values [$column[0]] = $this->properties [$column[0]];
			if (is_string ( $values [$column[0]] )) {
				$values [$column[0]] = htmlspecialchars ( $values [$column[0]] );
			}
			$allcolumns []=$column[0];
		}
		if ($this->properties ['nid'] == 0) {
			$allcolumns = implode ( ",", $allcolumns );
			$values = "'" . implode ( "','", $values ) . "'";
			$result = $db->query ( "INSERT INTO $tablename ($allcolumns) VALUES ($values)" );
			if ($result) {
				$db->close ();
				return TRUE;
			}
		} else {
			$nid = $this->properties ['nid'];
			$settings = "";
			foreach ( $values as $key => $value ) {
				$settings .= "$key='$value',";
			}
			$settings = rtrim ( $settings, ',' );
			$result = $db->query ( "UPDATE $tablename SET $settings WHERE id= $nid" );
			if ($result) {
				$db->close ();
				return TRUE;
			}
		}
	}
	public function GetNode() {
		$dbConf = new DBConfig ();
		$db = new mysqli ( $dbConf->host (), $dbConf->user (), $dbConf->password (), $dbConf->name () );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$nid = $this->properties ['nid'];
		$result = $db->query ( "SELECT * FROM $this->type WHERE id = $nid" );
		if ($result) {
			while ( $Node = $result->fetch_array ( MYSQLI_ASSOC ) ) {
				$this->properties = $Node;
			}
			$result->close ();
		}
	}
	public function EditForm() {
		return template_out ( "edit-{$this->type}-form", array_merge($this->properties,array('type'=>$this->type)) );
	}
}