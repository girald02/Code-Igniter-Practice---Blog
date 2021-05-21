
<center><h1>
  <?=$title;?>

</h1></center>

<!-- ALWAYS MERON DAPAT -->
    <?= validation_errors();?>


<!-- FORM START -->
<?= form_open('add'); ?>


  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Title</label>
    <input type="text" placeholder="Enter post title"  class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= set_value('title');?>" >
  </div>
  <br>
  <div class="mb-3">
   <div class="form-group">
    <label for="exampleFormControlTextarea2">Description</label>
    <textarea class="form-control rounded-0" placeholder="Enter description" name="desc" id="exampleFormControlTextarea2" rows="3" value="<?= set_value('desc');?>"></textarea>
  </div>
</div>

<br>

<div style="text-align: right;">
  <button type="submit" name="submit" class="btn btn-primary">Add</button>
  <a href="<?=base_url(); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
</div>

