<?php ?>
<div class="modal fade" id="mdLogin" tabindex="-1" role="dialog" aria-labelledby="mdLoginTitle" aria-hidden="true">
    <div class="modal-dialog modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">
                    &times;
                </span>
 <span class="sr-only">
                    Close
                </span>

            </button>
             <h4 class="modal-title" id="mdLoginTitle">
                Login
            </h4>
        </div>
        <form class="form-horizontal" role="login" action="<?php echo Router::getURL('') ?>User/login" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="txtUsername" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtUsername" name="data[User][username]">
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtPassword" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtPassword" name="data[User][password]">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox">Remember me</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                
            </div>
        </form>
    </div>
</div>