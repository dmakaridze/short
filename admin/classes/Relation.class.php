<?php
class Relation {
	private $FirsNodeClass;
	private $SecondNodeClass;
	private $RelationName;
	public function __construct($fn, $sn, $name) {
		$this->FirsNodeClass = $fn;
		$this->SecondNodeClass = $sn;
		$this->RelationName = $name;
	}
	public function initialise () {
		
	}
	public function put_relation ($fnId, $snId, $startDate, $endDate) {
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$result = $db->query ( "INSERT INTO {$this->RelationName} ({$this->FirsNodeClass} {$this->SecondNodeClass} startdate enddate) VALUES ($fnId $snId $startDate $endDate)" );
		if ($result) {
			$result->close ();
			$db->close ();
			return TRUE;
		}
	}
	public function update_relation($rId, $fnId, $snId, $startDate, $endDate) {
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$result = $db->query ( "UPDATE {$this->RelationName} SET ({$this->FirsNodeClass}=$fnId {$this->SecondNodeClass}=$snId startdate=$startDate enddate=$endDate) WHERE id=$rId" );
		if ($result) {
			$result->close ();
			$db->close ();
			return TRUE;
		}
	}
	public function all_in_relation_with($fnId) {
		$db = new mysqli ( SHORTDBHOST, SHORTDBUSER, SHORTDBPASSWORD, SHORTDBNAME );
		if ($db->connect_error) {
			die ( "Database connection error: " . $db->connect_error );
		}
		$result = $db->query ( "SELECT {$this->RelationName} WHERE {$this->FirsNodeClass}=$fnId" );
		if ($result) {
			while ( $Rel = $result->fetch_array ( MYSQLI_ASSOC ) ) {
				$Relations [] = $Rel;
			}
			$result->close ();
			$db->close ();
			return $Relations;
		}
	}
}