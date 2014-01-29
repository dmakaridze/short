<h2 align="center">Login Form</h2>
<h3 align="center" class="message">
<?php print $ops['msg']; ?>
</h3>
<form id="login-form" name="login-form" method="post"
	action="/admin/verify">
	<div id="username">
		<label for="user">Login Name :</label> <input type="text" name="user"
			id="user" />
	</div>
	<div id="password">
		<label for="pass">Password :</label> <input type="password"
			name="pass" id="pass" />
	</div>
	<div id="buttons">
		<input type="submit" name="submit" id="submit" value="Submit" /> <input
			type="reset" name="reset" id="reset" value="Reset" />
	</div>
</form>