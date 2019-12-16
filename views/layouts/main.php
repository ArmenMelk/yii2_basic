<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            (Yii::$app->session["user"] && Yii::$app->session["user"]["user_role_id"] <= 2)  ?
            ['label' => 'Applications', 'url' => ['/site/applications']] : '',
            !Yii::$app->session["user"] ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' .  Yii::$app->session["user"]['email'] . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
                . '<li>'
                . Html::beginForm(['/site/dashboard'], 'post')
                . Html::submitButton(
                    'Dashboard',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
<script type="text/javascript">
$(document).ready(function(){
    $("#btn_user_search").on("click", function(){
                clearOutput();
                var user_recid = $("#exampleFormControlSelect1").val();
                var requestUrl = "<?php echo Yii::$app->request->baseUrl.'/site/search'; ?>";
                if(user_recid < 1){
                    return;
                }
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: requestUrl,
                    data: {user_recid: user_recid,
                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'},
                    success: function (result) {
                        var result = JSON.parse(result);
                        console.log(result);
                        $(".card-title").text(result['user'][0].first_name + ' ' + result['user'][0].last_name);
                        $(".card-subtitle").text('Mentor:  ' + result['user'][0].mentor_first_name + ' ' + result['user'][0].mentor_last_name);
                        $(".card-text-email").text('Email:  ' + result['user'][0].email);
                        $(".card-text-phone").text('Phone number:  ' + result['user'][0].phone_number);
                        $(".card-text-department").text('Department :  ' + result['user'][0].short_name);
                        $(".card-text-position").text('Position :  ' + result['user'][0].position);
                        $(".card-text-salary").text('Salary :  ' + result['user'][0].salary);
                        $(".card-text-start_date").text('Start Date :  ' + result['user'][0].start_date);

                        $.each(result['team'], function() {
                            $('#colleagues').append(
                                '<li class="list-group-item">'
                                + this.first_name + ' ' +  this.first_name
                                + '</li>'
                            );
                        });

                        $(".teammates").removeClass('hidden');
                    },
                    error: function (exception) {
                        console.log(exception);
                    }
                });

            });

            $("#btn_user_login").on("click", function(){
                var email = $("#email").val();
                var password = $("#password").val();
                var requestUrl = "<?php echo Yii::$app->request->baseUrl.'/site/getuser'; ?>";
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: requestUrl,
                    data: {email: email,
                        password: password,
                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'},
                    success: function (result) {
                        var result = JSON.parse(result);
                        console.log(result.user_recid);
                        if(result.user_recid && result.user_recid > 0){
                            location.reload();
                        }else{
                            alert('invalid username or password');
                        }
                    },
                    error: function (exception) {
                        console.log(exception);
                    }
                });
            });

            $("#btn_submit_application").on("click", function(){
                var user_recid = $("#user_recid").val();
                var appstatus = $("#appstatus").val();
                var description = $("#description").val();
                var requestUrl = "<?php echo Yii::$app->request->baseUrl.'/site/submitapplication'; ?>";
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: requestUrl,
                    data: {user_recid: user_recid,
                        appstatus: appstatus,
                        description: description,
                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'},
                    success: function (result) {
                        var result = JSON.parse(result);
                        if(result.status){
                            alert('Application has been submited successfully');
                        }else{
                            alert('Application submit failed');
                        }
                        
                    },
                    error: function (exception) {
                        console.log(exception);
                    }
                });
            });

            $("#btn_edit_application").on("click", function(){
                $("#edit_app_form").trigger('reset');
                var row = $(this).closest("tr");
                var tds = row.find("td");             // Finds all children <td> elements
                var app_id = tds[0].innerHTML;
                var description = tds[5].innerHTML;
                var hr_comment = tds[6].innerHTML;
                var manager_comment = tds[7].innerHTML;
                $("#edit_app_form").removeClass("hidden");
                $("#app_id").val(app_id);
                $("#description").text(description);
                $("#hr_comment").text(hr_comment);
                $("#manager_comment").text(manager_comment);
            });

            $("#btn_edit_application_form").on("click", function(){
                var app_id = $("#app_id").val();
                var description = $("#description").text();
                var hr_comment = $("#hr_comment").text();
                var manager_comment = $("#manager_comment").text();
                var requestUrl = "<?php echo Yii::$app->request->baseUrl.'/site/editapplication'; ?>";
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: requestUrl,
                    data: {app_id: app_id,
                        description: description,
                        hr_comment: hr_comment,
                        manager_comment: manager_comment,
                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'},
                    success: function (result) {
                        var result = JSON.parse(result);
                        if(result.status){
                            $("#edit_app_form").trigger('reset');
                            $("#edit_app_form").addClass('hidden');
                            alert('Application has been updated successfully');
                            location.reload();
                        }else{
                            alert('Application update failed');
                        }
                        
                    },
                    error: function (exception) {
                        console.log(exception);
                    }
                });

            });

        });
        
        function clearOutput(){
            $(".card-title").text('');
            $(".card-subtitle").text('');
            $(".card-text-email").text('');
            $(".card-text-phone").text('');
            $(".card-text-department").text('');
            $(".card-text-position").text('');
            $(".card-text-salary").text('');
            $(".card-text-start_date").text('');
            $(".teammates").addClass('hidden');
            $('#colleagues').empty();
        }

</script>
</html>
<?php $this->endPage() ?>

