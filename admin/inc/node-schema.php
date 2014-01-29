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