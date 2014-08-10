<form method="POST" action="<?php echo Router::getURL()?>User/register" role="form">
	<div class="form-group">
		<label for="txtUsername">Username</label>
		<input type="text" name="data[User][username]" id="txtUsername" class="form-control">
		<span class="has-warning"></span>			
	</div>
	<div class="form-group">
		<label for="txtUsername">Email</label>
		<input type="text" name="data[User][email]" id="txtEmail" class="form-control">
		<span class="has-warning"></span>
	</div>
	<div class="form-group">
		<label for="txtUsername" class="control-label">Password</label>
		<input type="text" name="data[User][password]" id="txtPassword" class="form-control">
		<span class="has-warning"></span>
	</div>
	<div class="form-group has-error has-feedback">
		<label for="txtUsername" class="control-label">Confirm Password</label>
		<input type="text" id="txtConfirmPassword" class="form-control">
		<span class="glyphicon glyphicon-remove form-control-feedback"></span>
	</div>
	<div class="form-group">
		<label for="txtUsername">Timezone</label>
		<select name="data[User][timezone_id]" id="ddlTimezone" class="form-control">
		</select>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
<?php  
?>