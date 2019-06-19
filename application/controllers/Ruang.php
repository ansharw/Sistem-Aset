<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Ruang - Sistem Manajemen Aset';

		$this->load->model('Model_ruang');
		$this->load->model('Model_gedung');

	}

	/* 
	* It only redirects to the manage category page
	*/
	public function index()
	{

		if(!in_array('viewRuang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('ruang/index', $this->data);	
	}	

	/*
	* It checks if it gets the category id and retreives
	* the category information from the category model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	// public function ambilDataRuangDariId($id) 
	// {
	// 	if($id) {
	// 		$data = $this->Model_ruang->getDataRuang($id);
	// 		echo json_encode($data);
	// 	}

	// 	return false;
	// }

	/*
	* Fetches the category value from the category table 
	* this function is called from the datatable ajax function
	*/
	public function ambilDataRuang()
	{
		$result = array('data' => array());

		$data = $this->Model_ruang->getDataRuang();

		foreach ($data as $key => $value) {

			$gedung_data = $this->Model_gedung->getDataGedung($value['gedung_id']);

			// button
			$buttons = '';
			
			if(in_array('updateRuang', $this->permission)) {
    			$buttons .= '<a href="'.base_url('ruang/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteRuang', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['no_ruangan'],
				$value['name'],	
				$gedung_data['name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* Its checks the category form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
		if(!in_array('createRuang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('ruang_nomer', 'Nomer Ruang', 'trim|required');
		$this->form_validation->set_rules('ruang_nama', 'Nama Ruang', 'trim|required');
		$this->form_validation->set_rules('gedung', 'Nama Gedung', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		$response = array();
        if ($this->form_validation->run() == TRUE) {
        	$data = array(
				'no_ruangan' => $this->input->post('ruang_nomer'),
				'name' => $this->input->post('ruang_nama'),
				'gedung_id' => $this->input->post('gedung'),
        		'active' => $this->input->post('active'),	
			);

        	$create = $this->Model_ruang->create($data);
        	if($create == true) {
				$this->session->set_flashdata('success', 'Ruang Baru Telah  Berhasil Dibuat');
				redirect('ruang/', 'refresh');
        	}
        	else {
				$this->session->set_flashdata('errors', 'Terjadi Kesalahan');
                redirect('ruang/create', 'refresh');	
        	}
        }
        else {
			$this->data['gedung'] = $this->Model_gedung->getGedungAktif();
			$this->render_template('ruang/create', $this->data);
		}
	}

	/*
	* Its checks the category form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($ruang_id)
	{
		if(!in_array('updateRuang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if(!$ruang_id) {
            redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('ruang_nomer', 'Nomer Ruang', 'trim|required');
		$this->form_validation->set_rules('ruang_nama', 'Nama ruang', 'trim|required');
		$this->form_validation->set_rules('gedung', 'Nama Gedung', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		$response = array();
	    if ($this->form_validation->run() == TRUE) {
	    	$data = array(
				'no_ruangan' => $this->input->post('ruang_nomer'),
				'name' => $this->input->post('ruang_nama'),
				'gedung_id' => $this->input->post('gedung'),
	    		'active' => $this->input->post('active'),	
			);

	        	$update = $this->Model_ruang->update($data, $ruang_id);
	        	if($update == true) {
					$this->session->set_flashdata('success', 'Ruang Telah Berhasil Diperbaharui');
                	redirect('ruang/', 'refresh');
	        	}
	        	else {
					$this->session->set_flashdata('errors', 'Terjadi Kesalahan');
                	redirect('ruang/update/'.$ruang_id, 'refresh');
	        	}
	        }
	        else {
            	$this->data['gedung'] = $this->Model_gedung->getGedungAktif();          
            	$ruang_data = $this->Model_ruang->getDataRuang($ruang_id);
            	$this->data['ruang_data'] = $ruang_data;
				$this->render_template('ruang/edit', $this->data); 
			}
		}

	/*
	* It removes the category information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteRuang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$ruang_id = $this->input->post('ruang_id');

		$response = array();
		if($ruang_id) {
			$delete = $this->Model_ruang->remove($ruang_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Ruang Berhasil Dihapus";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Terjadi Kesalahan";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Muat Ulang Halaman!!";
		}

		echo json_encode($response);
	}

}