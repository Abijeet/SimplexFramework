<form method="POST" action="<?php echo Router::getURL()?>User/register" role="form">
	<?php echo $this->BootstrapForm->input('User.username', array()); 
		 echo $this->BootstrapForm->input('User.email', array()); 
		 echo $this->BootstrapForm->input('User.password', array('type' => 'password')); ?>
	<div class="form-group">
		<label for="txtConfirmPassword" class="control-label">Confirm Password</label>
		<input type="text" id="txtConfirmPassword" class="form-control">	
	</div>
	<?php echo $this->BootstrapForm->input('User.timezone_id', array('type' => 'text', 'label' => 'Timezone')); ?>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
<?php  
?>