<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$userArrLength = count($user);
?>
<div class="site-index">
    <div class="jumbotron">
        <h2>Welcome to Armen Melkumyan demo presentation!</h2>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="container">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h3>User Details Search</h3>
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Select User</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="exampleFormControlSelect1">
                                <option value="-1">Please choose a user</option>
                                <?php for($i = 0; $i < $userArrLength; $i++): ?>
                                <option value="<?php print $user[$i]['user_recid'];?>"><?php print $user[$i]['first_name'].' '.$user[$i]['last_name'];?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <button type="button" id="btn_user_search" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card" style="width: 60rem;">
            <div class="card-body">
                <h5 class="card-title"></h5>
                <h6 class="card-subtitle mb-2 text-muted"></h6>
                <p class="card-text-email"></p>
                <p class="card-text-phone"></p>
                <p class="card-text-department"></p>
                <p class="card-text-position"></p>
                <p class="card-text-salary"></p>
                <p class="card-text-start_date"></p>
            </div>
        </div>
        
        <div class="teammates hidden" style="width: 60rem;">
            <h3>Team Mates</h3>
            <ul class="list-group" id="colleagues">
            </ul>
        </div>
    </div>
</div>