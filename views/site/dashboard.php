<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$userArrLength = count($user);
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>User Dashboard!</h2>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="container">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php if(Yii::$app->session["user"]['user_role_id'] <= 3 ): ?>
                    <h3>Create Application</h3>
                    <form>
                        <div class="form-group">
                            <label for="user_recid">Select User</label>
                            <select class="form-control" id="user_recid" name="user_recid">
                                <option value="-1">Please choose a user</option>
                                <?php for($i = 0; $i < $userArrLength; $i++): ?>
                                <option value="<?php print $user[$i]['user_recid'];?>"><?php print $user[$i]['first_name'].' '.$user[$i]['last_name'];?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appstatus">Application Status</label>
                            <select class="form-control" id="appstatus" require="required">
                                <option value="">--Select One--</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
                        </div>
                        <button type="button" id="btn_submit_application" class="btn btn-primary">Submit</button>
                    </form>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>