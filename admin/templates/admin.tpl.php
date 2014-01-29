<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print $ops['title']; ?></title>
<link href="/css/admin-style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"
	href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
	$(function() {
		$("#menu").menu();
	});
</script>
<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector : "textarea"
	});
</script>
<style>
.ui-menu {
	width: 150px;
}
</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<div align="center">
				<h1><?php print $ops['title']; ?></h1>
			</div>
		</div>
		<div id="content-wrapper">
				<?php print $ops['leftcol']; ?>
			<div id="">
				<?php print $ops['content']; ?>
			</div>
		</div>
		<div id="license-block">
			Designed &amp; Developed by David Makaridze. This work is licensed
			under a <a href="https://gnu.org/licenses/gpl-3.0.txt">GNU GENERAL
				PUBLIC LICENSE</a>
		</div>
	</div>
</body>
</html>