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
		// $this->load->view('welcom_2');
	}

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
  }



  public function main()
  {
    $search_word  = $page_uri = '';
		$uri_segment = 3;

		//break down current uri address and put them into an array
		$uri_array = $this->check_uri($this->uri->uri_string());

		//If 'search' exists in the uri_array
		if(in_array('search',$uri_array))
		{
			$search_word = $uri_array[sizeof($uri_array)-1];
			$page_uri = '/search/'.$search_word;
			$uri_segment = 5;
		}

		$this->load->library('pagination');

		$config['base_url'] = '/board/main'.$page_uri;
		$config['total_rows'] = $this->board_m->get_list('count','','',$search_word);
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

  public function check_uri($addr)
	{
		$ready = str_replace('/', '/', $addr);
    $launch = explode('/', $ready);
    return  $launch;
	}
}
