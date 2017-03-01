<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_m extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  function get_list($type='', $offset='', $limit='', $search_word='')
  {
    $limit_query = "";
    $search_query = "";

    //If $offset or $limit is not empty,
    if( $offset != '' OR $limit != '')
    {
      $limit_query = ' LIMIT '.$offset.', '.$limit;
    }

    if( $search_word != '')
    {
      $search_query = ' WHERE title like "%'.$search_word.'%"';
    }

    $sql = "SELECT * FROM ci_board".$search_query." ORDER BY id DESC".$limit_query;
    $query = $this->db->query($sql);

    //If type parameter value is a count, then return total num of rows.
    if($type == 'count'){
      $result = $query->num_rows();
    }else{
      $result = $query->result();
    }

    return $result;
  }

  function get_view($title)
  {
    //read string after the last dash
    $revert1 = substr($title, strrpos($title,'-') + 1);

    //Check if $revert1 field contains any string
    //If so, throw 404
    if(preg_match('/[a-z\.]/i', $revert1))
    {
      $result = "404";
    }
    else
    {
      //Replace dashes to %
      $revert2 = preg_replace("/[-]/","%",$title);

      //Replace numbers to %
      $revert3 = preg_replace("/[0-9]/","%",$revert2);

      // var_dump($revert);
      // var_dump($revert1);
      $like_query = " WHERE title like '%".$revert3."%'";
      $not_like_query = " AND title not like '%".$revert1."'";
      $id_query = 'SELECT * FROM ci_board'.$like_query .$not_like_query.' AND id='.$revert1;
      // var_dump($id_query);
      // $id_query = "SELECT * FROM ci_board WHERE title like '%".$revert."%' AND id='".$revert1."'";
      $query0 = $this->db->query($id_query);
      $num_result = $query0->num_rows();

      //if 0, no matching data found. Query returns null.
      //SEND 404 value to the controller
      if($num_result == 0)
      {
        $result = '404';
      }
      else
      {
        $id = $query0->row()->id;
        $counter_update = "UPDATE ci_board SET count = count + 1 WHERE id='".$id."'";
        $this->db->query($counter_update);

        $sql = "SELECT * FROM ci_board WHERE id='".$id."'";
        $query = $this->db->query($sql);

        $result = $query->row();
      }
    }
    // var_dump($result);
    return $result;
  }

  function new_post($arrays)
  {
    $create_sql = array(
      'author'=> $arrays['author'],
      'title'=> $arrays['title'],
      'contents'=> $arrays['contents'],
      'count' => $arrays['count'],
      'createdAt'=> $arrays['createdAt'],
    );

    $result = $this->db->insert('ci_board', $create_sql);

    return $result;
  }

  function modify_post($arrays, $title)
  {
    // $check = revertTitle($title);
    // $revert = preg_replace("/[-]/"," ",$title);
    $revert1 = substr($title, strrpos($title,'-') + 1);
    $id_query = 'SELECT * FROM ci_board WHERE id="'.$revert1.'"';
    // $id_query = 'SELECT id FROM ci_board WHERE title like "%'.$revert.'%"';
    $query0 = $this->db->query($id_query);
    $num_result = $query0->num_rows();

    if($num_result == 0){
      $result = '404';
    }
    else
    {
      $id = $query0->row()->id;
      // var_dump($where);

      $edit_sql = array(
        'title'=> $arrays['title'],
        'contents'=> $arrays['contents'],
        'editedAt'=> $arrays['editedAt'],
      );
      $this->db->where('id', $id);
      $result1 = $this->db->update('ci_board', $edit_sql);
      $query1 = "SELECT title FROM ci_board where id='".$id."'";

      $get_new_title = $this->db->query($query1);
      $result2 = $get_new_title->row()->title;

      $result = array(
        'result' => $result1,
        'title' => $result2.'-'.$id
      );
      // var_dump($result);
    }
    return $result;
  }

  function delete_post($id)
  {
    $sql = "DELETE FROM ci_board WHERE id='".$id."'";
    $this->db->query($sql);

  }
}
