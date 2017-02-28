<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('America/Vancouver');
    $this->load->model('Board_m');
  }


	public function index()
	{
    $this->main();
	}

  //Function to include header and footer on load
  public function _remap($method)
  {
    //include Header
		$this->load->view('header_v');
		$this->load->view('navbar');

		//If method exists, then include method in the middle
		if(method_exists($this,$method))
		{
			$this->{"{$method}"}();
		}

		//include Footer
		$this->load->view('footer_v');
  }// <-- _remap ends


  //View Post
  public function view()
	{

		$data['views'] = $this->Board_m->get_view($this->uri->segment(3));

		//If returned data from Model is 404, then load 404 page
		if($data['views'] =="404")
		{
			$this->load->view('errors/custom404');
		}
		else
		{
			$this->load->view('board/View_v', $data);
		}
	}// <-- View function ends

  //Create New Post
	public function create()
	{
		// $this->load->helper('url');
		// echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

		if($_POST)
		{

			$create_post = array(
				'author' => $this->input->post('author', TRUE),
				'title' => $this->input->post('title', TRUE),
				'contents' => $this->input->post('content', TRUE),
				'count' => '0',
				'createdAt' => date('Y-m-d H:i:s'),
			);

			// $result = $this->Board_m->new_post($create_post);
			redirect('board/main/', $this->Board_m->new_post($create_post));

		}else
		{
			$this->load->view('board/Create_v');
		}
	}// <-- Create function ends


  //Edit Post
	public function edit()
	{
		$current_id = $this->uri->segment(3);

		if($_POST)
		{

			$edit_post = array(
				'title' => $this->input->post('title_e', TRUE),
				'contents' => $this->input->post('content_e', TRUE),
				'editedAt' => date('Y-m-d H:i:s'),
			);

			//Modified title is an array and contains two values.
			//Bool and New Title data as a string
			$modified_title = $this->board_m->modify_post($edit_post, $current_post_title);
			// var_dump($modified_title);
			//run changeTitle function to convert any white spaces to dashes
			$new_title = $this->changeTitle($modified_title['title']);

			//Redirect to the post showing modified title in the URL.
			redirect('board/view/'.$new_title);

		}else
		{
			$data['e_view'] = $this->Board_m->get_view($this->uri->segment(3));
			$this->load->view('board/Edit_v', $data);
		}
	}// <-- Edit function ends


  //Delete Post
	public function delete()
	{
		$current_id = $this->uri->segment(3);
		$this->Board_m->delete_post($current_id);

		redirect('board/main/');
	}// <-- Delete function ends



  public function main()
  {
    $search_word  = $page_uri = '';
		$uri_segment = 3;

		//break down current uri address and put them into an array
		$uri_array = $this->check_uri($this->uri->uri_string());
    // var_dump($uri_array);

		//If 'search' exists in the uri_array
		if(in_array('search',$uri_array))
		{
			$search_word = $uri_array[sizeof($uri_array)-1];
			$page_uri = '/search/'.$search_word;
			$uri_segment = 5;
		}

		$this->load->library('pagination');

		$config['base_url'] = '/board/main'.$page_uri;
		$config['total_rows'] = $this->Board_m->get_list('count','','',$search_word);
		$config['per_page'] = 10;
		// $config['cur_tag_open'] = '<b>';

		$this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();

		//If there is a value at 4th segment, allocate the value to the $page variable.
		//Otherwise, allocate 1 to the variable.
		$page = $this->uri->segment($uri_segment,1);
		if($page > 1)
		{
			$start = (($page/$config['per_page'])) * $config['per_page'];
		}
		else
		{
			$start = ($page - 1) * $config['per_page'];
		}

		$limit = $config['per_page'];

		$data['list'] = $this->Board_m->get_list('',$start, $limit,$search_word);
		$data['search_term'] = $search_word;
		$this->load->view('board/List_v', $data);
  }

	// $delimiter ='/'
	// function to break down the URL by delimiter
  public function check_uri($addr)
	{
		$ready = str_replace('/', '/', $addr);
    $launch = explode('/', $ready);
    return  $launch;
	}

	//function to convert white spaces to dashes
	public function changeTitle($title)
  {
		$change_1 = preg_replace("/[^A-Za-z0-9\-\s_]/", "",$title);
    $change = preg_replace("/[\s_]/", "-", $change_1);
    return $change;
  }
}
