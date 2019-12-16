
<?php

/* @var $this yii\web\View */

$this->title = 'Applications';
?>

<form id="edit_app_form" class="hidden">
    <div class="form-group">
        <label for="app_id">App ID</label>
        <input class="form-control" id="app_id" readonly="readonly" />
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="3" readonly="readonly"></textarea>
    </div>
    <div class="form-group <?php if(Yii::$app->session["user"]["user_role_id"] == 1){ print 'hidden';} ?>">
        <label for="hr_comment">Hr Comment</label>
        <textarea class="form-control" id="hr_comment" rows="3"></textarea>
    </div>
    <div class="form-group <?php if(Yii::$app->session["user"]["user_role_id"] == 2){ print 'hidden';} ?>">
        <label for="manager_comment">Manager Comment</label>
        <textarea class="form-control" id="manager_comment" rows="3"></textarea>
    </div>
    <button type="button" id="btn_edit_application_form" class="btn btn-primary">Submit</button>
</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Application ID</th>
      <th scope="col">Account ID</th>
      <th scope="col">Start Date</th>
      <th scope="col">Last Update</th>
      <th scope="col">Status</th>
      <th scope="col">Description</th>
      <th scope="col">Hr Comment</th>
      <th scope="col">Manager Comment</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($applications as $applications): ?>
    <tr>
      <td><?php print $applications['application_id'] ; ?></td>
      <td><?php print $applications['account_id'] ; ?></td>
      <td><?php print $applications['start_date'] ; ?></td>
      <td><?php print $applications['last_update'] ; ?></td>
      <td><?php print $applications['status'] ; ?></td>
      <td><?php print $applications['description'] ; ?></td>
      <td><?php print $applications['hr_comment'] ; ?></td>
      <td><?php print $applications['manager_comment'] ; ?></td>
      <td><button type="button" id="btn_edit_application" class="btn btn-warning">Edit</button></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>