<h2 class="lead text_center"> royBoard/Edit Post</h2>
<div class="edit_wrapper">
  <div class="container">
    <form class="form-horizontal" method="post">
      <div class="title_header col-xs-12">
        <h3><input autofocus id="edit_title" type="text" name="title_e" value="<?php echo $e_view->title;?>"></h3>
        <span class="title_author"><i>posted by <?php echo $e_view->author; ?></i></span>
        <span class="title_created"><i>created at <?php echo $e_view->createdAt; ?></i></span>
      </div>

    <div class="edit_post">
      <textarea class="col-xs-12" name="content_e" rows="8" cols="80"><?php echo $e_view->contents;?></textarea>
    </div>


    <div class="tool">
      <button class="btn btn-info" type="submit" name="button">SUBMIT</button>
      </form>
      <button class="btn btn-danger" type="button" name="button" onclick="history.go(-1);">CANCEL</button>
    </div>

  </div>
</div>
