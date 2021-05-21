<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>

<!-- DISPLAY NOTIFICATION THAT SUCCESSFULLY ADD! -->
<?php if ($this->session->flashdata('post_added')) : ?>
	<?= '<p class="alert alert-success">' .$this->session->flashdata('post_added').'</p>';  ?>
<?php endif; ?>


<!-- DISPLAY NOTIFICATION THAT SUCCESSFULLY DELETE! -->
<?php if ($this->session->flashdata('post_deleted')) : ?>
	<?= '<p class="alert alert-success">' .$this->session->flashdata('post_deleted').'</p>';  ?>
<?php endif; ?>


<?php if ($this->session->flashdata('success_login')) : ?>
  <?= '<p class="alert alert-success">' . $this->session->flashdata('success_login').'</p>';  ?>
<?php endif; ?>


	<!-- TODAY DATE -->
	<div class="today-date">
		<?php
		echo "<b>TODAY DATE:            </b>";
		echo date("F j, Y, g:i a");
		?>
	</div>


	<h1><?= $title; ?></h1>
		<ul  class="list-group">
			<?php foreach($post as $row) { ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<a href="<?=base_url();?><?=$row['slug'];?>">
						<?=$row['title']; ?>
					</a>
					<span class="badge bg-primary rounded-pill"><?php echo rand(2,23); ?> comments</span>
				</li>
			<?php } ?>
		</ul>
</body>
</html>


 

