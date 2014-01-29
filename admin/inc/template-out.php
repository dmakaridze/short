<?php
function template_out($name, $ops) {
	ob_start ();
	require_once APPREALPATH . '/admin/templates/' . $name . '.tpl.php';
	$html = ob_get_contents ();
	ob_end_clean ();
	return $html;
}