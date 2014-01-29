<?php
function node_schema($type) {
	switch ($type) {
		case 'story' :
			return array (
					'id' => 0,
					'title' => '',
					'lead' => '',
					'body' => '',
					'type' => '' 
			);
		default :
			return NULL;
	}
}
function node_types() {
	return array (
			'story' 
	);
}
function template_out($name, $ops) {
	ob_start ();
	require_once APPREALPATH . '/admin/templates/' . $name . '.tpl.php';
	$html = ob_get_contents ();
	ob_end_clean ();
	return $html;
}