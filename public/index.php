<?php
ini_set ( 'display_errors', 1 );
error_reporting ( E_ALL );
define ( 'APPREALPATH', dirname ( __DIR__ ) );
require_once APPREALPATH . '/admin/config/dbconfig.php';
require_once APPREALPATH . '/admin/inc/autoload-register.php';
require_once APPREALPATH . '/admin/inc/functions.php';
if (isset ( $_GET ['page'] )) {
	switch ($_GET ['page']) {
		case 'admin' :
			$app = new Application ( isset ( $_GET ['com'] ) ? $_GET ['com'] : '', isset ( $_GET ['msg'] ) ? $_GET ['msg'] : '', isset ( $_GET ['id'] ) ? $_GET ['id'] : '' );
			print $app->run ();
			break;
		default :
			break;
	}
}