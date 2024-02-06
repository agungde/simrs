<?php 
/**
 * Data_tindakan Page Controller
 * @category  Controller
 */
class Data_tindakanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_tindakan";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"id_daftar", 
			"tanggal", 
			"pasien", 
			"tindakan", 
			"nama_tindakan", 
			"no_rekam_medis", 
			"dokter_pemeriksa");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_tindakan.id LIKE ? OR 
				data_tindakan.id_daftar LIKE ? OR 
				data_tindakan.tanggal LIKE ? OR 
				data_tindakan.pasien LIKE ? OR 
				data_tindakan.tindakan LIKE ? OR 
				data_tindakan.nama_tindakan LIKE ? OR 
				data_tindakan.harga LIKE ? OR 
				data_tindakan.operator LIKE ? OR 
				data_tindakan.date_created LIKE ? OR 
				data_tindakan.date_updated LIKE ? OR 
				data_tindakan.no_rekam_medis LIKE ? OR 
				data_tindakan.dokter_pemeriksa LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_tindakan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_tindakan.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Data Tindakan";
		$this->render_view("data_tindakan/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"nama_tindakan", 
			"harga", 
			"id_daftar", 
			"pasien", 
			"tindakan", 
			"tanggal", 
			"no_rekam_medis", 
			"dokter_pemeriksa");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_tindakan.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Tindakan";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_tindakan/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","no_rekam_medis","pasien","tindakan","id_daftar","dokter_pemeriksa");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'pasien' => 'required',
				'tindakan' => 'required',
				'dokter_pemeriksa' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute before adding record
		$linksite="".SITE_ADDR;
$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$iddaftar = $_POST['id_daftar'];
 $tanggal   = $_POST['tanggal'];
 $pasien    = $_POST['pasien'];
 $posdokter = $_POST['dokter_pemeriksa'];
  if($pasien=="IGD") {
    $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  }else  if($pasien=="POLI") {
    $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 }else  if($pasien=="RAWAT INAP") {
     $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                                  }else  if($pasien=="RANAP ANAK") {
 $queryb = mysqli_query($koneksi, "select * from ranap_anak WHERE id='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                                  }else  if($pasien=="RANAP PERINA") {
                                  $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                                  }else  if($pasien=="RANAP BERSALIN") {
                                  $queryb = mysqli_query($koneksi, "select * from ranap_bersalin WHERE id='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
  }                                    
  // ambil jumlah baris data hasil query
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row   = mysqli_fetch_assoc($queryb); 
 $no_rekam_medis=$row['no_rekam_medis'];
 $nama_pasien=$row['nama_pasien'];
 $alamat=$row['alamat'];
 $no_hp=$row['no_hp'];
 $tanggal_lahir=$row['tanggal_lahir'];
 $jenis_kelamin=$row['jenis_kelamin'];
 $email=$row['email'];
 $umur=$row['umur'];
$no_ktp=$row['no_ktp'];
  }
            /////////////////////////////Tindakan//////////////////////////////////////////
$kettindakan = "";
if(isset($_POST['tindakan'])){
 $cektindakan = $_POST['tindakan'];
    if(!empty( $cektindakan)){
        for($a = 0; $a < count( $cektindakan); $a++){
            if(!empty( $cektindakan[$a])){
                $idtin =  $cektindakan[$a];
 $res = mysqli_query($koneksi, "SELECT * FROM list_biaya_tindakan WHERE id='$idtin'"); 
 while ($rowii=mysqli_fetch_array($res)){
     $biaya_tindakan = $rowii['harga'];
     $tindakan       = $rowii['nama_tindakan'];
 }
 mysqli_query($koneksi,"INSERT INTO `data_tindakan` (`no_rekam_medis`,`dokter_pemeriksa`,`tindakan`,`pasien`,`tanggal`,`nama_tindakan`,`id_daftar`, `harga`) VALUES ('$no_rekam_medis','$posdokter','Tindakan Dari $pasien','$pasien','$tanggal','$tindakan',' $iddaftar', '$biaya_tindakan')"); 
if($kettindakan==""){
$kettindakan = "$tindakan";
}else{
    $kettindakan = "$kettindakan $tindakan";
}
            }
        }
    }    
}
$queryc = mysqli_query($koneksi, "select * from data_rekam_medis WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis' ORDER BY id DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
 $rowsc = mysqli_num_rows($queryc);
  if ($rowsc <> 0) {
      $rowc  = mysqli_fetch_assoc($queryc); 
      $idapp = $rowc['id'];
      mysqli_query($koneksi, "UPDATE data_rekam_medis SET tindakan='$kettindakan' WHERE id='$idapp'");
  }
//////////////////////////////////////////////////////////////////////////
 $thn  = substr($tanggal_lahir, 0, 4);
    $taun = date("Y");
    $umur = $taun - $thn;
    $umur = substr($umur, 0, 2);
function hitung_umur($thn){
    $birthDate = new DateTime($thn);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y."Tahun ".$m."Bulan ".$d."Hari";
}
$umurnya=hitung_umur("$tanggal_lahir"); 
$qucekrekam = mysqli_query($koneksi,"select * from rekam_medis WHERE no_rekam_medis='$no_rekam_medis'");
  $rowsrek = mysqli_num_rows($qucekrekam);
if ($rowsrek <> 0) {
    }else{
mysqli_query($koneksi, "INSERT INTO `rekam_medis`(`no_rekam_medis`, `nama_pasien`, `alamat`, `no_hp`, `email`, `jenis_kelamin`, `tanggal_lahir`, `umur`) VALUES ('$no_rekam_medis','$nama_pasien','$alamat','$no_hp','$email','$jenis_kelamin','$tanggal_lahir','$umurnya')"); 
    }
if($kettindakan=="") {
}else{
    $qujumtin = mysqli_query($koneksi, "SELECT SUM(harga) AS tot from data_tindakan WHERE id_daftar='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $jumtin = mysqli_fetch_assoc($qujumtin);    
 $tottin = $jumtin['tot'];
  $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
        $dattrx      = mysqli_fetch_assoc($quetrx);
        $idtrx       = $dattrx['id'];  
        $tottagawal  = $dattrx['total_tagihan'];
        $tottagakhir = $tottagawal + $tottin;
        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
  } 
 mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES (' $idtrx','$iddaftar','Tindakan','".$_POST['tanggal']."','$no_rekam_medis','$tottin','Register','$pasien','$kettindakan')");
}
$this->set_flash_msg("Tindakan Berhasil Di Simpan!! ", "success");
if($pasien=="IGD"){
 return  $this->redirect("igd");
 }else if($pasien=="POLI"){
  return  $this->redirect("pendaftaran_poli");
  }else if($pasien=="RAWAT INAP"){
     return  $this->redirect("rawat_inap");
     }else if($pasien=="RANAP ANAK"){
     return  $this->redirect("ranap_anak");
     }else if($pasien=="RANAP BERSALIN"){
     return  $this->redirect("ranap_bersalin");
     }else if($pasien=="RANAP PERINA"){
     return  $this->redirect("ranap_perina");
}
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_tindakan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Tindakan";
		$this->render_view("data_tindakan/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","tanggal","no_rekam_medis","pasien","tindakan","id_daftar","dokter_pemeriksa");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'pasien' => 'required',
				'tindakan' => 'required',
				'dokter_pemeriksa' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_tindakan.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_tindakan");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("data_tindakan");
					}
				}
			}
		}
		$db->where("data_tindakan.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Tindakan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_tindakan/edit.php", $data);
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("data_tindakan.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_tindakan");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function tindakan($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal", 
			"no_rekam_medis", 
			"pasien", 
			"nama_tindakan", 
			"dokter_pemeriksa");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_tindakan.id LIKE ? OR 
				data_tindakan.tanggal LIKE ? OR 
				data_tindakan.no_rekam_medis LIKE ? OR 
				data_tindakan.pasien LIKE ? OR 
				data_tindakan.nama_tindakan LIKE ? OR 
				data_tindakan.tindakan LIKE ? OR 
				data_tindakan.harga LIKE ? OR 
				data_tindakan.operator LIKE ? OR 
				data_tindakan.date_created LIKE ? OR 
				data_tindakan.date_updated LIKE ? OR 
				data_tindakan.id_daftar LIKE ? OR 
				data_tindakan.dokter_pemeriksa LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_tindakan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_tindakan.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Data Tindakan";
		$this->render_view("data_tindakan/tindakan.php", $data); //render the full page
	}
}
