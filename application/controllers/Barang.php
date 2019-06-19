<?php

require ('./vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

        $this->not_logged_in();
        $this->load->helper('download');
        $this->load->library('upload');

		$this->data['page_title'] = 'Barang - Sistem Manajemen Aset';

		$this->load->model('Model_barang');
		$this->load->model('Model_ruang');
		$this->load->model('Model_gedung');
	}

    /* 
    * ini hanya mengalihkan ke menu manage barang
    */
	public function index()
	{
        if(!in_array('viewBarang', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('barang/index', $this->data);	
	}

    /*
    * Ini mengambil sebagian data barang dari tabel barang
    * fungsi ini adalah untuk memanggil dari datatable ajax function
    */
	public function ambilDataBarang()
	{
        $result = array('data' => []);

        $a = 1;

		$data = $this->Model_barang->getDataBarang();

		foreach ($data as $key => $value) {

            $i = $a++;

            $gedung_data = $this->Model_gedung->getDataGedung($value['gedung_id']);

            $ruang_data = $this->Model_ruang->getDataRuang($value['ruang_id']);

			// button
            $buttons = '';
            if(in_array('updateBarang', $this->permission)) {
    			$buttons .= '<a href="'.base_url('barang/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deleteBarang', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
			

			$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';

            $availability = ($value['availability'] == 1) ? '<span class="label label-success">Baik</span>' : $availability = ($value['availability'] == 2) ? '<span class="label label-warning">Rusak</span>' : '<span class="label label-danger">Rusak Parah</span>';


			$result['data'][$key] = [
                $i++,
                $value['name'],
                $value['kode_barang'] . ' - ' . $value['NUP'],
                $value['tahun_perolehan'],
                $value['penanggung_jawab'],
                $value['merk'],
                $ruang_data['no_ruangan'] . '. ' . $ruang_data['name'],
                $gedung_data['name'],
				$availability,
				$buttons
            ];
		} // /foreach

		echo json_encode($result);
	}	

    /*
    * Jika validasi tidak valid, lalu akan diarahkan ke menu tambah barang.
    * Jika validasi untuk setiap kolom yang valid lalu data akan masuk ke dalam database
    */
	public function create()
	{
		if(!in_array('createBarang', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('barang_nama', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('kode_barang', 'Kode barang', 'trim|required');
        $this->form_validation->set_rules('NUP', 'NUP', 'trim|required');
        $this->form_validation->set_rules('tahun_perolehan', 'Tahun perolehan', 'trim|required');
        $this->form_validation->set_rules('penanggung_jawab', 'Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('merk', 'Nama Merk Barang', 'trim|required');
        $this->form_validation->set_rules('ruang', 'Ruang', 'trim|required');
        $this->form_validation->set_rules('gedung', 'Gedung', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');
        
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
        if ($this->form_validation->run() == TRUE) {
            // true case
        	$upload_image = $this->upload_image();
        	$data = [
        		'name' => $this->input->post('barang_nama'),
                'kode_barang' => $this->input->post('kode_barang'),
                'NUP' => $this->input->post('NUP'),
                'tahun_perolehan' => $this->input->post('tahun_perolehan'),
                'penanggung_jawab' => $this->input->post('penanggung_jawab'),
                'merk' => $this->input->post('merk'),
        		'image' => $upload_image,
        		'description' => $this->input->post('description'),
        		'ruang_id' => $this->input->post('ruang'),
                'gedung_id' => $this->input->post('gedung'),
        		'availability' => $this->input->post('availability'),
            ];

        	$create = $this->Model_barang->create($data);
        	if($create == true) {
                $this->session->set_flashdata('success', 'Barang Baru Telah Berhasil Dibuat');
                redirect('barang/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Terjadi Kesalahan');
                redirect('barang/create', 'refresh');
        	}
        }
        else {
            // false case

			$this->data['ruang'] = $this->Model_ruang->getRuangAktif();
			$this->data['gedung'] = $this->Model_gedung->getGedungAktif();
            $this->render_template('barang/create', $this->data);
        }	
	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/barang_image
        $config['upload_path'] = 'assets/images/barang_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('barang_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['barang_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit barang page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($barang_id)
	{      
        if(!in_array('updateBarang', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$barang_id) {
            $this->session->set_flashdata('errors', 'Terjadi Kesalahan');
            redirect('dashboard', 'refresh');
        }
        

        $this->form_validation->set_rules('barang_nama', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('kode_barang', 'Kode barang', 'trim|required');
        $this->form_validation->set_rules('NUP', 'NUP', 'trim|required');
        $this->form_validation->set_rules('tahun_perolehan', 'Tahun perolehan', 'trim|required');
        $this->form_validation->set_rules('penanggung_jawab', 'Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('merk', 'Nama Merk Barang', 'trim|required');        
        $this->form_validation->set_rules('ruang', 'Ruang', 'trim|required');
        $this->form_validation->set_rules('gedung', 'Gedung', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            // true case
            
            $data = array(
                'name' => $this->input->post('barang_nama'),
                'kode_barang' => $this->input->post('kode_barang'),
                'NUP' => $this->input->post('NUP'),
                'tahun_perolehan' => $this->input->post('tahun_perolehan'),
                'penanggung_jawab' => $this->input->post('penanggung_jawab'),
                'merk' => $this->input->post('merk'),
                'description' => $this->input->post('description'),
        		'ruang_id' => $this->input->post('ruang'),
                'gedung_id' => $this->input->post('gedung'),
                'availability' => $this->input->post('availability'),
            );

            
            if($_FILES['barang_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);
                
                $this->Model_barang->update($upload_image, $barang_id);
            }

            $update = $this->Model_barang->update($data, $barang_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Barang Telah Berhasil Diperbaharui');
                redirect('barang/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Terjadi Kesalahan');
                redirect('barang/update/'.$barang_id, 'refresh');		
            }
        }
        else {
            // false case    
            $this->data['ruang'] = $this->Model_ruang->getRuangAktif();           
            $this->data['gedung'] = $this->Model_gedung->getGedungAktif();          
            $barang_data = $this->Model_barang->getDataBarang($barang_id);
            $this->data['barang_data'] = $barang_data;
            $this->render_template('barang/edit', $this->data); 
        }   
	}

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteBarang', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $barang_id = $this->input->post('barang_id');

        $response = array();
        if($barang_id) {
            $delete = $this->Model_barang->remove($barang_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Barang Berhasil Dihapus"; 
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
    
    // public function import_excel()
    // {
    //     $reader = IOFactory::createReader('Xlsx','Xls');
    //     $reader->setReadDataOnly(TRUE);
    //     $config['upload_path'] = 'assets/import_excel';
    //     $config['file_name'] =  uniqid();
    //     $config['allowed_types'] = 'xlsx|xls';

    //     $this->load->library('upload', $config);
    //     if ( ! $this->upload->do_upload('excel_s'))
    //     {
    //         $error = $this->upload->display_errors();
    //         return $error;
    //     }
    //     else
    //     {
    //         $spreadsheet = $reader->load($_FILES['excel_s']['tmp_name']);
    //         $data = array('upload_data' => $this->upload->data());
    //         $type = explode('.', $_FILES['excel_s']['name']);
    //         $type = $type[count($type) - 1];
            
    //         $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
    //         $spreadData = $spreadsheet->getActiveSheet();
    //         $highestRow = $spreadData->getHighestRow();
    //         $highestColumn = $spreadData->getHighestColumn();
    //         $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    //         $import = $this->Model_barang->create();
    //         //foreach sheet cell
    //         $i=3; foreach($import as $xlsx) {
    //             $spreadData->setActiveSheetIndex(0) 
    //             ->setCellValue('A'.$i, $xlsx->kode_barang)
    //             ->setCellValue('B'.$i, $xlsx->name)
    //             ->setCellValue('C'.$i, $xlsx->merk)
    //             ->setCellValue('D'.$i, $xlsx->NUP)
    //             ->setCellValue('E'.$i, $xlsx->penanggung_jawab)
    //             ->setCellValue('F'.$i, $xlsx->availability);
    //             $i++;
    //         }

    //         return ($data == true) ? $path : false;            
    //     }
    // }

    // public function import_excel() 
    // {
    //     if(isset($_FILES["file"]["name"]))
	// 	{
	// 		$path = $_FILES["file"]["tmp_name"];
	// 		$object = IOFactory::load($path);
	// 		foreach($object->getWorksheetIterator() as $worksheet)
	// 		{
	// 			$highestRow = $worksheet->getHighestRow();
	// 			$highestColumn = $worksheet->getHighestColumn();
	// 			for($row=3; $row<=$highestRow; $row++)
	// 			{
	// 				$kode_barang = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
	// 				$name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	// 				$merk = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
	// 				$NUP = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$penanggung_jawab = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
	// 				$data[] = array(
	// 					'kode_barang'		=>	$kode_barang,
	// 					'name'			    =>	$name,
	// 					'merk'				=>	$merk,
	// 					'NUP'		        =>	$NUP,
	// 					'penanggung_jawab'	=>	$penanggung_jawab,
	// 				);
	// 			}
	// 		}
	// 		$this->Model_barang->create_excel($data);
    //         echo 'Data Imported successfully';
    //         redirect('barang', 'refresh');
	// 	}
    // }

    public function export_excel()
    {
        $excel = $this->Model_barang->listing();

        //create new spreadsheet object 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //add some data
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'DATA INVENTARIS BARANG')
        ->setCellValue('A2', 'NO.')
        ->setCellValue('B2', 'KD ASET')
        ->setCellValue('C2', 'NAMA ASET')
        ->setCellValue('D2', 'MEREK/TYPE')
        ->setCellValue('E2', 'NO ASET')
        ->setCellValue('F2', 'NO SPPA')
        ->setCellValue('G2', 'JUMLAH')
        ->setCellValue('H2', 'PIHAK KEDUA')
        ->setCellValue('I2', 'NIP')
        ->setCellValue('J2', 'JABATAN')
        ->setCellValue('K2', 'POSISI')
        ->setCellValue('L2', 'KONDISI');

        //format sheet border, width, height and many more
        //format excel document 
        $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
        $spreadsheet->getActiveSheet()->getStyle('A1:L1')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A1:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(33);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(21);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'horizontalStyle' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ],
        ];
        $sheet->getStyle('A1:L10')->applyFromArray($styleArray);

        //foreach sheet cell
        $i=3; foreach($excel as $xlsx) {
            $spreadsheet->setActiveSheetIndex(0) 
            ->setCellValue('A'.$i, $xlsx->id)
            ->setCellValue('B'.$i, $xlsx->kode_barang)
            ->setCellValue('C'.$i, $xlsx->name)
            ->setCellValue('D'.$i, $xlsx->merk)
            ->setCellValue('E'.$i, $xlsx->NUP)
            ->setCellValue('H'.$i, $xlsx->penanggung_jawab);
            $i++;
        }
        // Rename worksheet
        // $spreadsheet->getActiveSheet()->setTitle('Laporan Barang '.date('d-m-Y H')); 

        // define filename excel
        $filename = 'Inventaris-LPMP';            

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        // header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        // header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function view_excel()
    {       
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        
        $writer = new Xlsx($spreadsheet);

        $filename = 'format-inventaris.xlsx';

        $writer->save($filename); // will create and save the file in the root of the project

    }

    public function download_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        //add some data
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'DATA INVENTARIS BARANG')
        ->setCellValue('A2', 'NO.')
        ->setCellValue('B2', 'KD ASET')
        ->setCellValue('C2', 'NAMA ASET')
        ->setCellValue('D2', 'MEREK/TYPE')
        ->setCellValue('E2', 'NO ASET')
        ->setCellValue('F2', 'NO SPPA')
        ->setCellValue('G2', 'JUMLAH')
        ->setCellValue('H2', 'PIHAK KEDUA')
        ->setCellValue('I2', 'NIP')
        ->setCellValue('J2', 'JABATAN')
        ->setCellValue('K2', 'POSISI')
        ->setCellValue('L2', 'KONDISI');

        //format sheet border, width, height and many more
        //format excel document 
        $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
        $spreadsheet->getActiveSheet()->getStyle('A1:L1')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A1:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(33);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(21);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'leftStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    // 'horizontalStyle' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
        $sheet->getStyle('A1:L10')->applyFromArray($styleArray);

        // define filename excel
        $filename = 'Inventaris-LPMP';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); // download file 
    }

}