<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="body-content">
        <div class="row">
            <div class="container">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h3>Login Form</h3>
                    <form>
                        <div class="form-group">
                            <label for="email">User email</label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="emailHelp" placeholder="Enter pasword">
                        </div>
                        <button type="button" id="btn_user_login" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
