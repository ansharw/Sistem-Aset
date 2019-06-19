<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_barang extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function listing()
	{
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	/* get the brand data */
	public function getDataBarang($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM barang where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM barang ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDataBarangAktif()
	{
		$sql = "SELECT * FROM barang WHERE availability = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('barang', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('barang', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('barang');
			return ($delete == true) ? true : false;
		}
	}

	public function hitungTotalBarang()
	{
		$sql = "SELECT * FROM barang";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getDataSheet()
	{
		
		// //setWidthSheet
		// $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5.43);
		// //setMergeCells
		// $spreadsheet->getActiveSheet()->mergeCells('A1:S2');
		// //setRowHeight
		// $spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(100);
		// //setNewRow
		// $spreadsheet->getActiveSheet()->insertNewRowBefore(7, 2);
		// //Setting the default column width
		// $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
		// //Setting the default row height
		// $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

		// //Add a drawing to a worksheet
		// $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		// $drawing->setName('Logo');
		// $drawing->setDescription('Logo');
		// $drawing->setPath('./images/officelogo.jpg');
		// $drawing->setHeight(36);
		// $drawing->setName('Paid');
		// $drawing->setCoordinates('B15');
		// $drawing->setOffsetX(110);
		// $drawing->setRotation(25);
		// $drawing->getShadow()->setVisible(true);
		// $drawing->getShadow()->setDirection(45);
		// //To add the above drawing to the worksheet, use the following snippet of code. PhpSpreadsheet creates the link between the drawing and the worksheet:
		// $drawing->setWorksheet($spreadsheet->getActiveSheet());

		// // You can also add images created using GD functions without needing to save them to disk first as In-Memory drawings.
		// //  Use GD to create an in-memory image
		// $gdImage = @imagecreatetruecolor(120, 20) or die('Cannot Initialize new GD image stream');
		// $textColor = imagecolorallocate($gdImage, 255, 255, 255);
		// imagestring($gdImage, 1, 5, 5,  'Created with PhpSpreadsheet', $textColor);

		// //  Add the In-Memory image to a worksheet
		// $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
		// $drawing->setName('In-Memory image 1');
		// $drawing->setDescription('In-Memory image 1');
		// $drawing->setCoordinates('A1');
		// $drawing->setImageResource($gdImage);
		// $drawing->setRenderingFunction(
		// 	\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG
		// );
		// $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
		// $drawing->setHeight(36);
		// $drawing->setWorksheet($spreadsheet->getActiveSheet());

		// // DEFINE A NAMED RANGE
		// // Add some data
		// $spreadsheet->setActiveSheetIndex(0);
		// $spreadsheet->getActiveSheet()->setCellValue('A1', 'Firstname:');
		// $spreadsheet->getActiveSheet()->setCellValue('A2', 'Lastname:');
		// $spreadsheet->getActiveSheet()->setCellValue('B1', 'Maarten');
		// $spreadsheet->getActiveSheet()->setCellValue('B2', 'Balliauw');

		// // Define named ranges
		// $spreadsheet->addNamedRange( new \PhpOffice\PhpSpreadsheet\NamedRange('PersonFN', $spreadsheet->getActiveSheet(), 'B1') );
		// $spreadsheet->addNamedRange( new \PhpOffice\PhpSpreadsheet\NamedRange('PersonLN', $spreadsheet->getActiveSheet(), 'B2') );

		// Redirect output to a client's web browser
		//Sometimes, one really wants to output a file to a client''s browser, especially when creating spreadsheets on-the-fly. There are some easy steps that can be followed to do this:

		//1.Create your PhpSpreadsheet spreadsheet
		//2.Output HTTP headers for the type of document you wish to output
		//3.Use the \PhpOffice\PhpSpreadsheet\Writer\* of your choice, and save to 'php://output'

		//\PhpOffice\PhpSpreadsheet\Writer\Xlsx uses temporary storage when writing to php://output. By default, temporary files are stored in the script's working directory. When there is no access, it falls back to the operating system's temporary files location.

		//This may not be safe for unauthorized viewing! Depending on the configuration of your operating system, temporary storage can be read by anyone using the same temporary storage folder. When confidentiality of your document is needed, it is recommended not to use php://output.
		
		
	}

}