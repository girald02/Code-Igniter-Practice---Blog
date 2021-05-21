<!DOCTYPE html>
<html lang="en">
<head>
  <title>Post App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">MyBlog</a>
      </div>
        <ul class="nav navbar-nav">
          <li ><a href="<?=base_url();?>">Home</a></li>
          <?php if ($this->session->logged_in) {  ?>
          <li><a href="<?=base_url('add'); ?>">Add New Post</a></li>
          <li><a href="<?=base_url();?>"><?php echo $this->session->fullname; ?></a> </li>
          <li><a href="<?=base_url('logout');?>">Logout</a></li>
          <?php }else{?>
          <li><a href="<?=base_url('login');?>">Login</a></li>
          <?php } ?>
        </ul>
      </div>
    </nav>


    <div class="container">