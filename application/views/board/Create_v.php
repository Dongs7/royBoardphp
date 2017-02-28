<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2 class="lead text_center"> royBoard/Create Post</h2>
<div class="create_wrapper">
  <div class="container">
    <form class="form-horizon" method="post">
      <input type="text" class="form-control" name="title" placeholder="Title">
      <input type="text" class="form-control" name="author" placeholder="Author">
      <textarea class="form-control" rows="6" name="content"></textarea>

    <div class="tool">
      <button class="btn btn-info" type="submit">POST</button>
      </form>
      <button class="btn btn-danger" type="button" name="button" onclick="history.go(-1);">CANCEL</button>
    </div>
  </div>
</div>
