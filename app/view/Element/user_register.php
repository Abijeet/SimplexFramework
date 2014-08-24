<?php $this->loadHelpers('Bootstrap'); ?>
<form method="POST"  action="<?php echo Router::getURL() ?>User/register" role="form">
    <?php $username = $this->Bootstrap->input('User.username') ?>
    <div class="<?php echo $username['div_class'] ?>">        
        <label for="txtRegUsername"><?php echo $username['label'] ?></label>
        <input type="<?php echo $username['type'] ?>" id="txtRegUsername" name="<?php echo $username['name'] ?>" class="form-control" value="<?php echo $username['value'] ?>">
        <?php echo $username['error_html'] ?>
    </div>

    <?php $email = $this->Bootstrap->input('User.email') ?>
    <div class="<?php echo $email['div_class'] ?>">        
        <label for="txtRegEmail"><?php echo $email['label'] ?></label>
        <input type="<?php echo $email['type'] ?>" id="txtRegEmail" name="<?php echo $email['name'] ?>" class="form-control" value="<?php echo $email['value'] ?>">
        <?php echo $email['error_html'] ?>
    </div>

    <?php $password = $this->Bootstrap->input('User.password', array('type' => 'password')) ?>
    <div class="<?php echo $password['div_class'] ?>">
        <label for="txtRegPassword"><?php echo $password['label'] ?></label>
        <input type="<?php echo $password['type'] ?>" id="txtRegPassword" name="<?php echo $password['name'] ?>" class="form-control" value="<?php echo $password['value'] ?>">
        <?php echo $password['error_html'] ?>
    </div>    
    <div class="form-group">
        <label for="txtRegConfirmPassword">Confirm Password</label>
        <input type="password" id="txtRegConfirmPassword" name="confirmPassword" class="form-control">        
    </div>
    <?php $timezone = $this->Bootstrap->input('User.timezone_id', array('type' => 'select', 'options' => $timezones, 'default' => 'Please select your timezone')) ?>
    <div class="<?php echo $timezone['div_class'] ?>">
        <label for="ddlTimezoneId">Timezone</label>
        <select id="ddlTimezoneId" name="<?php echo $timezone['name'] ?>" class="form-control">
            <?php echo $timezone['options_html'] ?>
        </select>
        <?php echo $timezone['error_html'] ?>
    </div>
    <button type="submit" class="btn btn-default">Register</button>
</form>