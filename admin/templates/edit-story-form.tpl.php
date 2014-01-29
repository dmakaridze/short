<div id="node-input-form">
	<form action="/admin/put" method="post">
		<input type="hidden" name="id" value="<?php print $ops['id']; ?>"> <input
			type="hidden" name="type" value="<?php print $ops['type']; ?>">
		<div>
			<label class="form-label">Title:</label><input class="input-text"
				type="text" name="title" value="<?php print $ops['title']; ?>" />
		</div>
		<div>
			<label class="form-label">Lead:</label>
			<textarea name="lead" class="input-text"><?php print $ops['lead']; ?></textarea>
		</div>
		<div>
			<label class="form-label">Body:</label>
			<textarea name="body" class="input-text"><?php print $ops['body']; ?></textarea>
		</div>
		<div>
			<input type="submit" name="save" /> <input type="reset"
				name="cancel" />
		</div>
	</form>
</div>