<h1>Login User</h1>

<?php if ($this->session->flashdata('invalid_creds')) : ?>
  <?= '<p class="alert alert-danger">' . $this->session->flashdata('invalid_creds').'</p>';  ?>
<?php endif; ?>






<!-- ALWAYS MERON DAPAT -->
 <?= validation_errors();?>


<?= form_open('login'); ?>

<div class="form-group">
	<input autofocus autocomplete="off" type="text" placeholder="Enter email as username" name="username" value="<?= set_value('username'); ?>" class='form-control'><br>
	<input type="password" name="password" placeholder="Enter password" value="<?= set_value('password'); ?>" class='form-control'>
	<br>
	<input type="submit" name="btnsubmit" class="btn btn-success" value="LOGIN">
	<a href="<?=base_url(); ?>" class='btn btn-danger'>CANCEL</a>

</div> 