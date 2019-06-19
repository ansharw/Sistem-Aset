<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard - Sistem Manajemen Aset';
		
		$this->load->model('Model_barang');
		$this->load->model('Model_ruang');
		$this->load->model('Model_users');
		$this->load->model('Model_gedung');
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total barang, total paid orders, total users, and total gedung information
	into the frontend.
	*/
	public function index()
	{
		$this->data['total_barang'] = $this->Model_barang->hitungTotalBarang();
		$this->data['total_ruang'] = $this->Model_ruang->hitungTotalRuang();
		$this->data['total_users'] = $this->Model_users->hitungTotalUser();
		$this->data['total_gedung'] = $this->Model_gedung->hitungTotalGedung();

		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
}