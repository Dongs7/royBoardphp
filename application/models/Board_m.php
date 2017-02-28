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

    //If type parameter value is count, then return total num of rows.
    if($type == 'count'){
      $result = $query->num_rows();
    }else{
      $result = $query->result();
    }

    return $result;
  }

  function get_view($title)
  {
    //Revert changed title data to the original value
    //Convert dashes to white spaces
    $revert = preg_replace("/[-]/"," ",$title);

    //Find id where its title value is the same as parameter
    $id_query = "SELECT id FROM ci_board WHERE title='".$revert."'";
    $query0 = $this->db->query($id_query);

    //Check the number of rows returned
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

  function modify_post($arrays)
  {
    $where = array(
      'id' => $arrays['id']
    );

    $edit_sql = array(
      'title'=> $arrays['title'],
      'contents'=> $arrays['contents'],
      'editedAt'=> $arrays['editedAt'],
    );

    $result = $this->db->update('ci_board', $edit_sql, $where);

    return $result;
  }

  function delete_post($id)
  {
    $sql = "DELETE FROM ci_board WHERE id='".$id."'";
    $this->db->query($sql);

  }
}
