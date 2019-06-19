<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ruang extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getDataRuang($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM ruang WHERE id = ? ";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM ruang ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get active brand infromation */
	public function getRuangAktif()
	{
		$sql = "SELECT * FROM ruang WHERE active = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}	

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('ruang', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('ruang', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ruang');
			return ($delete == true) ? true : false;
		}
	}

	public function hitungTotalRuang()
	{
		$sql = "SELECT * FROM ruang";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}