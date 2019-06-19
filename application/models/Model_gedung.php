<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_gedung extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getGedungAktif()
	{
		$sql = "SELECT * FROM gedung WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getDataGedung($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM gedung where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM gedung";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('gedung', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('gedung', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('gedung');
			return ($delete == true) ? true : false;
		}
	}

	public function hitungTotalGedung()
	{
		$sql = "SELECT * FROM gedung WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

}