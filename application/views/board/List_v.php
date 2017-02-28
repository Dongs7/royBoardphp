<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2 class="lead text_center"><i>roysBoard in PHP, MySQL, CodeIgniter and Bootstrap</i></h2>
<?php if(($search_term) != '') {?>
  <h3 class="text_center">Search Result: <i><?php echo $search_term;?></i></h3>
 <?php } ?>
<div class="main_wrapper">
  <div class="container">
    <div class="tool">
      <a href="/board/create"><button class="btn btn-danger" type="button" name="button">NEW</button></a>
    </div>
      <table id="main_list" class="col-xs-12">
        <thead>
          <tr>
            <th>TITLE</th>
            <th>Author</th>
            <th>Views</th>
          </tr>
        </thead>
<?php
foreach ($list as $lt)
{
?>
<!-- <tbody> -->
  <tr>

    <td class="post_list" id="post_title">
      <!--
       Get title data from controller, then if title contains
       white spaces, replace them to dashes.
      -->
      <?php
        $title_sting = $lt->title;
        $changed = preg_replace("/[\s_]/", "-", $title_sting);
      ?>
       <a href="/board/view/<?php echo $changed?>"><?php echo $lt->title;?></a>
    </td>
    <td class="post_list"><?php echo $lt->author;?></td>
    <td class="post_list"><?php echo $lt->count;?></td>
  </tr>
<!-- </tbody> -->
<?php
}
?>
  <tfoot>
    <tr id="pagination">
      <th colspan="5" class="text_center page_num" >
        <?php echo $pagination;?>
      </th>
    </tr>
  </tfoot>
  </table>

  <!-- Button will be displayed only if search_term field is submitted -->
  <?php if(($search_term) != '') {?>
   <a href="/board/main"><button id="backbtn" type="button" name="button">BACK</button></a>
   <?php } ?>

  <div class="tool">
    <form id="post_search" method="post">
      <input id="search_key" type="text" name="" placeholder="search term">
      <button id="search_btn" type="button" name="button"><i class="fa fa-search"></i></button>
    </form>
  </div>

  </div>

</div>
