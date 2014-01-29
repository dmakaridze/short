<?php
require_once APPREALPATH . '/admin/config/db_config.php';
echo '<div id="content">';
$dbConfig = DBConfigLoad ();
$db = new mysqli ( $dbConfig ['dbhost'], $dbConfig ['dbuser'], $dbConfig ['dbpassword'], $dbConfig ['dbname'] );

if ($db->connect_error) {
	die ( "Database connection error: " . $db->connect_error );
}
$command = '/' . $_GET ['page'] . '/' . $_GET ['com'];
$gid = $_SESSION ['gid'];
$result = $db->query ( "SELECT * FROM adminmenu LEFT JOIN permissions ON adminmenu.pid=permissions.pid WHERE gid=$gid AND command='$command'" );
if ($result) {
	$permission = $result->fetch_array ( MYSQLI_ASSOC );
	if (! is_array ( $permission )) {
		echo '<div id="message">You don\'t have permission to access this page!</div>';
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
			echo '<table border=0 id="adminmenuitems">';
			$odd = TRUE;
			foreach ( $adminmenu as $mid => $adminmenuitem ) {
				$format = "<tr class=\"%s\"><td>%d</td><td>%d</td><td>%d</td><td>%d</td><td>%s</td><td>%s</td></tr>";
				printf ( $format, ($odd ? 'odd' : 'even'), $adminmenuitem ['mid'], $adminmenuitem ['pid'], $adminmenuitem ['parent'], $adminmenuitem ['weight'], $adminmenuitem ['title'], $adminmenuitem ['command'] );
				$odd = ! $odd;
			}
			echo '</table>';
		}
	}
}
echo '</div>';
$db->close ();