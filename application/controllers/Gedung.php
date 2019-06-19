<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gedung extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Gedung - Sistem Manajemen Aset';

		$this->load->model('Model_gedung');
	}

	/* 
    * It only redirects to the manage stores page
    */
	public function index()
	{
		if(!in_array('viewGedung', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('gedung/index', $this->data);	
	}

	/*
	* It retrieve the specific store information via a store id
	* and returns the data in json format.
	*/
	public function ambilDataGedungDariId($id) 
	{
		if($id) {
			$data = $this->Model_gedung->getDataGedung($id);
			echo json_encode($data);
		}
	}

	/*
	* It retrieves all the store data from the database 
	* This function is called from the datatable ajax function
	* The data is return based on the json format.
	*/
	public function ambilDataGedung()
	{
		$result = array('data' => []);

		$data = $this->Model_gedung->getDataGedung();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateGedung', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteGedung', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
    * If the validation is not valid, then it provides the validation error on the json format
    * If the validation for each input is valid then it inserts the data into the database and 
    returns the appropriate message in the json format.
    */
	public function create()
	{
		if(!in_array('createGedung', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('gedung_nama', 'Nama Gedung', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('gedung_nama'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->Model_gedung->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Gedung Baru Telah Berhasil Dibuat';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Terjadi Kesalahan';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}	

	/*
    * If the validation is not valid, then it provides the validation error on the json format
    * If the validation for each input is valid then it updates the data into the database and 
    returns a n appropriate message in the json format.
    */
	public function update($id)
	{
		if(!in_array('updateGedung', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_gedung_nama', 'Nama Gedung', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_gedung_nama'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->Model_gedung->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Gedung Telah Berhasil Diperbarui';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Terjadi Kesalahan';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Muat Ulang Halaman!!';
		}

		echo json_encode($response);
	}

	/*
	* If checks if the store id is provided on the function, if not then an appropriate message 
	is return on the json format
    * If the validation is valid then it removes the data into the database and returns an appropriate 
    message in the json format.
    */
	public function remove()
	{
		if(!in_array('deleteGedung', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$gedung_id = $this->input->post('gedung_id');

		$response = array();
		if($gedung_id) {
			$delete = $this->Model_gedung->remove($gedung_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Gedung Telah Berhasil Dihapus";	
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