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
    $this->load->view('welcom_2');
  }
}
