

<a href="<?=base_url();?>"><button class="btn btn-info">BACK</button></a><br><br><br><br>



 <!-- <p>ID: <?= $id; ?></p>  -->
 <p><b> <?= $title; ?></p> </b>
 <p><i><?= $date_published; ?> </i></p> 
 <p><?= $body; ?></p> 


<?php if ($this->session->logged_in) {  ?>

 <a href="edit/<?= $id; ?>" class="btn btn-warning">Edit</a>
 <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  Delete
</button>


<?php } ?>

 <!-- <a href="delete/<?= $id; ?>" class="btn btn-danger">Delete</a> -->



