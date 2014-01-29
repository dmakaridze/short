<?php
spl_autoload_register ( function ($class) {
	require_once APPREALPATH . '/admin/classes/' . $class . '.class.php';
} );