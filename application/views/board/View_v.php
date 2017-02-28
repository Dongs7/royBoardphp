<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2 class="lead text_center"> royBoard/View Post</h2>
<div class="view_wrapper">
  <div class="container">
    <div class="title_header col-xs-12">
      <h3><?php echo $views->title;?></h3>
      <span class="title_author"><i>posted by <?php echo $views->author; ?></i></span>
      <span class="title_created"><i>created at <?php echo $views->createdAt; ?></i></span><br/>
      <?php if(($views->editedAt) != ''){?>
      <span class="title_edited"><i>edited at <?php echo $views->editedAt; ?></i></span>
      <?php } ?>
    </div>

    <div class="view_post">
      <div class="post-header"><span><?php echo $views->createdAt; ?></span></div>
      <div class="post-main">
        <div class="col-xs-4 post-info"><h3><?php echo $views->author; ?></h3></div>
        <div class="col-xs-8 post-content">
          <h4><?php echo $views->title; ?></h4>
          <?php echo $views->contents; ?>
        </div>
      </div>
    </div>


    <a href="/board/main/"><button class="btn btn-warning" type="button" name="button">BACK</button></a>
    <div class="tool">
      <?php
        $title_sting = $views->title;
        $change_1 = preg_replace("/[^A-Za-z0-9\-\s_]/", "",$title_sting);
        $changed = preg_replace("/[\s_]/", "-", $change_1);
      ?>
      <a href="/board/edit/<?php echo $changed;?>-<?php echo $views->id; ?>" class="back_btn"><button class="btn btn-info" type="button" name="button">EDIT</button></a>
      <button class="btn btn-danger" type="button" name="button" data-toggle="modal" data-target="#deleteHelper">DELETE</button>
    </div>

  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="deleteHelper">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Post</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete this post?</p>
      </div>
      <div class="modal-footer">

        <a href="/board/delete/<?php echo $views->id?>"><button type="button" class="btn btn-primary">YES</button></a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
