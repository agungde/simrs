<?php 
/**
 * Pemeriksaan_fisik Page Controller
 * @category  Controller
 */
class Pemeriksaan_fisikController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pemeriksaan_fisik";
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
		$fields = array("id_fisik", 
			"id_daftar", 
			"tanggal", 
			"no_rekam_medis", 
			"pasien", 
			"TD", 
			"ND", 
			"TB", 
			"BB", 
			"RR", 
			"SH", 
			"TFU", 
			"LILA", 
			"HPHT", 
			"riwayat_batuk", 
			"riwayat_alergi", 
			"riwayat_SCOP", 
			"riwayat_penyakit", 
			"keluhan", 
			"EKG", 
			"CTG", 
			"SPO");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->precord)){
$rekam = $request->precord;
    $db->where("no_rekam_medis='$rekam'");
}else{
    if(!empty($request->limit_start)){
        }else{
               $this->set_flash_msg("URL Tidak Valid!! ", "danger");
               return  $this->redirect("");
        }
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pemeriksaan_fisik.id_fisik LIKE ? OR 
				pemeriksaan_fisik.id_daftar LIKE ? OR 
				pemeriksaan_fisik.tanggal LIKE ? OR 
				pemeriksaan_fisik.no_rekam_medis LIKE ? OR 
				pemeriksaan_fisik.nama_pasien LIKE ? OR 
				pemeriksaan_fisik.jenis_kelamin LIKE ? OR 
				pemeriksaan_fisik.tanggal_lahir LIKE ? OR 
				pemeriksaan_fisik.alamat LIKE ? OR 
				pemeriksaan_fisik.pasien LIKE ? OR 
				pemeriksaan_fisik.TD LIKE ? OR 
				pemeriksaan_fisik.ND LIKE ? OR 
				pemeriksaan_fisik.TB LIKE ? OR 
				pemeriksaan_fisik.BB LIKE ? OR 
				pemeriksaan_fisik.RR LIKE ? OR 
				pemeriksaan_fisik.SH LIKE ? OR 
				pemeriksaan_fisik.TFU LIKE ? OR 
				pemeriksaan_fisik.LILA LIKE ? OR 
				pemeriksaan_fisik.HPHT LIKE ? OR 
				pemeriksaan_fisik.riwayat_batuk LIKE ? OR 
				pemeriksaan_fisik.riwayat_alergi LIKE ? OR 
				pemeriksaan_fisik.riwayat_SCOP LIKE ? OR 
				pemeriksaan_fisik.riwayat_penyakit LIKE ? OR 
				pemeriksaan_fisik.keluhan LIKE ? OR 
				pemeriksaan_fisik.EKG LIKE ? OR 
				pemeriksaan_fisik.CTG LIKE ? OR 
				pemeriksaan_fisik.SPO LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pemeriksaan_fisik/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pemeriksaan_fisik.id_fisik", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pemeriksaan Fisik";
		$this->render_view("pemeriksaan_fisik/list.php", $data); //render the full page
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
		$fields = array("id_fisik", 
			"id_daftar", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"alamat", 
			"pasien", 
			"TD", 
			"TB", 
			"BB", 
			"RR", 
			"SH", 
			"TFU", 
			"LILA", 
			"HPHT", 
			"riwayat_batuk", 
			"riwayat_alergi", 
			"riwayat_SCOP", 
			"riwayat_penyakit", 
			"keluhan", 
			"EKG", 
			"CTG", 
			"ND", 
			"SPO");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pemeriksaan_fisik.id_fisik", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pemeriksaan Fisik";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pemeriksaan_fisik/view.php", $record);
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
			$fields = $this->fields = array("tanggal","keluhan","TD","ND","SH","TB","BB","RR","TFU","LILA","HPHT","SPO","riwayat_batuk","riwayat_alergi","riwayat_SCOP","riwayat_penyakit","EKG","CTG","nama_pasien","no_rekam_medis","jenis_kelamin","alamat","tanggal_lahir","id_daftar","pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'keluhan' => 'required',
				'TD' => 'required',
				'ND' => 'required',
				'SH' => 'required',
				'riwayat_penyakit' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'id_daftar' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'TD' => 'sanitize_string',
				'ND' => 'sanitize_string',
				'SH' => 'sanitize_string',
				'TB' => 'sanitize_string',
				'BB' => 'sanitize_string',
				'RR' => 'sanitize_string',
				'TFU' => 'sanitize_string',
				'LILA' => 'sanitize_string',
				'HPHT' => 'sanitize_string',
				'SPO' => 'sanitize_string',
				'riwayat_batuk' => 'sanitize_string',
				'riwayat_alergi' => 'sanitize_string',
				'riwayat_SCOP' => 'sanitize_string',
				'riwayat_penyakit' => 'sanitize_string',
				'EKG' => 'sanitize_string',
				'CTG' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$this->set_flash_msg("Pemeriksaan Fisik Berhasil Di Simpan!! ", "success");
return  $this->redirect("igd");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pemeriksaan_fisik");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pemeriksaan Fisik";
		$this->render_view("pemeriksaan_fisik/add.php");
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
		$fields = $this->fields = array("id_fisik","tanggal","keluhan","TD","ND","SH","TB","BB","RR","TFU","LILA","HPHT","SPO","riwayat_batuk","riwayat_alergi","riwayat_SCOP","riwayat_penyakit","EKG","CTG","nama_pasien","no_rekam_medis","jenis_kelamin","alamat","tanggal_lahir","id_daftar","pasien");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'keluhan' => 'required',
				'TD' => 'required',
				'ND' => 'required',
				'SH' => 'required',
				'riwayat_penyakit' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'id_daftar' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'TD' => 'sanitize_string',
				'ND' => 'sanitize_string',
				'SH' => 'sanitize_string',
				'TB' => 'sanitize_string',
				'BB' => 'sanitize_string',
				'RR' => 'sanitize_string',
				'TFU' => 'sanitize_string',
				'LILA' => 'sanitize_string',
				'HPHT' => 'sanitize_string',
				'SPO' => 'sanitize_string',
				'riwayat_batuk' => 'sanitize_string',
				'riwayat_alergi' => 'sanitize_string',
				'riwayat_SCOP' => 'sanitize_string',
				'riwayat_penyakit' => 'sanitize_string',
				'EKG' => 'sanitize_string',
				'CTG' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				//get files link to be deleted before updating records
				$file_fields = array('EKG','CTG'); //list of file fields
				$db->where("pemeriksaan_fisik.id_fisik", $rec_id);;
				$fields_file_paths = $db->getOne($tablename, $file_fields);
				$db->where("pemeriksaan_fisik.id_fisik", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					if(!empty($fields_file_paths)){
						foreach($file_fields as $field){
							$files = explode(',', $fields_file_paths[$field]); // for list of files separated by comma
							foreach($files as $file){
								//delete files which are not among the submited post data
								if(stripos($modeldata[$field], $file) === false ){
									$file_dir_path = str_ireplace( SITE_ADDR , "" , $file ) ;
									@unlink($file_dir_path);
								}
							}
						}
					}
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pemeriksaan_fisik");
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
						return	$this->redirect("pemeriksaan_fisik");
					}
				}
			}
		}
		$db->where("pemeriksaan_fisik.id_fisik", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pemeriksaan Fisik";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pemeriksaan_fisik/edit.php", $data);
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
		//list of file fields
		$file_fields = array('EKG','CTG'); 
		foreach( $arr_id as $rec_id ){
			$db->where("pemeriksaan_fisik.id_fisik", $arr_rec_id, "in");;
		}
		//get files link to be deleted before deleting records
		$files = $db->get($tablename, null , $file_fields); 
		$db->where("pemeriksaan_fisik.id_fisik", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			//delete files after record has been deleted
			foreach($file_fields as $field){
				$this->delete_record_files($files, $field);
			}
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pemeriksaan_fisik");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function poli($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","TD","ND","TB","SH","BB","RR","TFU","LILA","HPHT","SPO","riwayat_batuk","riwayat_alergi","riwayat_SCOP","riwayat_penyakit","keluhan","nama_pasien","no_rekam_medis","jenis_kelamin","alamat","tanggal_lahir","id_daftar","pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'TD' => 'required',
				'ND' => 'required',
				'SH' => 'required',
				'keluhan' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'id_daftar' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'TD' => 'sanitize_string',
				'ND' => 'sanitize_string',
				'TB' => 'sanitize_string',
				'SH' => 'sanitize_string',
				'BB' => 'sanitize_string',
				'RR' => 'sanitize_string',
				'TFU' => 'sanitize_string',
				'LILA' => 'sanitize_string',
				'HPHT' => 'sanitize_string',
				'SPO' => 'sanitize_string',
				'riwayat_batuk' => 'sanitize_string',
				'riwayat_alergi' => 'sanitize_string',
				'riwayat_SCOP' => 'sanitize_string',
				'riwayat_penyakit' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
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
 $tanggal = $_POST['tanggal'];
 $pasien  = $_POST['pasien'];
 $keluhan = $_POST['keluhan'];
 $TD      = $_POST['TD'];
if($TD==""){
 $TD = $TD;
 }else{
$TD = "TD : $TD</br>";
 }
 $ND      = $_POST['ND'];
if($ND==""){
 $ND = $ND;
 }else{
$ND = "ND : $ND</br>";
 }  
 $TB      = $_POST['TB'];
 if($TB==""){
 $TB= $TB;
 }else{
$TB = "TB : $TB</br>";
 }
 $BB      = $_POST['BB'];
  if($BB==""){
  $BB = $BB;
 }else{
$BB = "BB : $BB</br>";
 }
 $RR      = $_POST['RR'];
if($RR==""){
  $RR = $RR;
 }else{
$RR = "RR : $RR</br>";
 }
 $SH      = $_POST['SH'];
 if($SH==""){
 $SH = $SH;
 }else{
$SH = "SH : $SH</br>";
 }
$ribat = $_POST['riwayat_batuk'];
 if($ribat==""){
 $ribat = $ribat;
 }else{
     $ribat = "Riwayat Batuk : $ribat</br>";
 }
$rial  = $_POST['riwayat_alergi'];
 if($rial==""){
 $rial = $rial;
 }else{
     $rial = "Riwayat Alergi : $rial</br>";
 }
$ripe  = $_POST['riwayat_penyakit'];
 if($ripe==""){
$ripe= $ripe;
 }else{
     $ripe = "Riwayat Penyakit : $ripe</br>";
 }
 $pemfisik = "$TD $ND $TB $BB $RR $SH $ribat $rial $ripe";
     $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row   = mysqli_fetch_assoc($queryb); 
 $no_rekam_medis = $row['no_rekam_medis'];
 $nama_pasien    = $row['nama_pasien'];
 $alamat         = $row['alamat'];
 $no_hp          = $row['no_hp'];
 $tanggal_lahir  = $row['tanggal_lahir'];
 $jenis_kelamin  = $row['jenis_kelamin'];
 $email          = $row['email'];
 $umur           = $row['umur'];
$no_ktp=$row['no_ktp'];
 $nama_poli      = $row['nama_poli'];
  $dokter = $row['dokter'];
  }
$querybp = mysqli_query($koneksi, "select * from data_poli WHERE id_poli='$nama_poli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rowsbp = mysqli_num_rows($querybp);
 if ($rowsbp <> 0) {
 $rowp   = mysqli_fetch_assoc($querybp); 
 $nampol = $rowp['nama_poli'];
}
$querybpd = mysqli_query($koneksi, "select * from data_dokter WHERE id_dokter='$dokter'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rowsbd = mysqli_num_rows($querybpd);
if ($rowsbd <> 0) {
$rowpd  = mysqli_fetch_assoc($querybpd); 
$namdok = $rowpd['nama_dokter'];
}
 $thn = substr($tanggal_lahir, 0, 4);
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
$qucekdat = mysqli_query($koneksi,"select * from data_rekam_medis WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis' and tanggal='$tanggal'");
  $rodat = mysqli_num_rows($qucekdat);
  if ($rodat <> 0) {
    }else{
        mysqli_query($koneksi, "INSERT INTO `data_rekam_medis`(`no_rekam_medis`, `nama_pasien`, `keluhan`, `nama_poli`, `dokter_pemeriksa`, `pasien`, `id_daftar`, `pemeriksaan_fisik`, `tanggal`, `alergi_obat`) VALUES ('$no_rekam_medis','$nama_pasien','$keluhan','$nampol','$namdok','POLI','$iddaftar','$pemfisik','$tanggal','$rial')"); 
    }
$this->set_flash_msg("Pemeriksaan Fisik Berhasil Di Simpan!! ", "success");
return  $this->redirect("pendaftaran_poli");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pemeriksaan_fisik");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pemeriksaan Fisik";
		$this->render_view("pemeriksaan_fisik/poli.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function inap($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","keluhan","TD","TB","BB","RR","SH","TFU","LILA","HPHT","ND","SPO","riwayat_batuk","riwayat_alergi","riwayat_SCOP","riwayat_penyakit","EKG","CTG","nama_pasien","no_rekam_medis","jenis_kelamin","alamat","tanggal_lahir","id_daftar","pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'keluhan' => 'required',
				'TD' => 'required',
				'riwayat_penyakit' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'id_daftar' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'TD' => 'sanitize_string',
				'TB' => 'sanitize_string',
				'BB' => 'sanitize_string',
				'RR' => 'sanitize_string',
				'SH' => 'sanitize_string',
				'TFU' => 'sanitize_string',
				'LILA' => 'sanitize_string',
				'HPHT' => 'sanitize_string',
				'ND' => 'sanitize_string',
				'SPO' => 'sanitize_string',
				'riwayat_batuk' => 'sanitize_string',
				'riwayat_alergi' => 'sanitize_string',
				'riwayat_SCOP' => 'sanitize_string',
				'riwayat_penyakit' => 'sanitize_string',
				'EKG' => 'sanitize_string',
				'CTG' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$this->set_flash_msg("Pemeriksaan Fisik Berhasil Di Simpan!! ", "success");
if($_POST['pasien']=="RANAP"){
return  $this->redirect("rawat_inap");
}else if($_POST['pasien']=="RANAP ANAK"){
return  $this->redirect("ranap_anak");
}else if($_POST['pasien']=="RANAP PERINA"){
return  $this->redirect("ranap_perina");
}else{
    return  $this->redirect("ranap_bersalin");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pemeriksaan_fisik");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pemeriksaan Fisik RAWAT INAP";
		$this->render_view("pemeriksaan_fisik/inap.php");
	}
}
