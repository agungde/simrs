<?php 
/**
 * Pendaftaran_lab Page Controller
 * @category  Controller
 */
class Pendaftaran_labController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pendaftaran_lab";
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
		$fields = array("pendaftaran_lab.id", 
			"pendaftaran_lab.tanggal", 
			"pendaftaran_lab.nama_pasien", 
			"pendaftaran_lab.no_rekam_medis", 
			"pendaftaran_lab.alamat", 
			"pendaftaran_lab.no_hp", 
			"pendaftaran_lab.nama_poli", 
			"pendaftaran_lab.dokter_pengirim", 
			"pendaftaran_lab.keluhan", 
			"pendaftaran_lab.jenis_pemeriksaan", 
			"pendaftaran_lab.nama_pemeriksaan", 
			"pendaftaran_lab.action", 
			"pendaftaran_lab.setatus", 
			"pendaftaran_lab.pasien", 
			"pendaftaran_lab.operator", 
			"user_login.nama AS user_login_nama", 
			"pendaftaran_lab.date_created", 
			"pendaftaran_lab.date_updated", 
			"pendaftaran_lab.id_daftar");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pendaftaran_lab.id LIKE ? OR 
				pendaftaran_lab.tanggal LIKE ? OR 
				pendaftaran_lab.nama_pasien LIKE ? OR 
				pendaftaran_lab.no_rekam_medis LIKE ? OR 
				pendaftaran_lab.alamat LIKE ? OR 
				pendaftaran_lab.no_hp LIKE ? OR 
				pendaftaran_lab.nama_poli LIKE ? OR 
				pendaftaran_lab.dokter_pengirim LIKE ? OR 
				pendaftaran_lab.keluhan LIKE ? OR 
				pendaftaran_lab.jenis_pemeriksaan LIKE ? OR 
				pendaftaran_lab.nama_pemeriksaan LIKE ? OR 
				pendaftaran_lab.action LIKE ? OR 
				pendaftaran_lab.setatus LIKE ? OR 
				pendaftaran_lab.pasien LIKE ? OR 
				pendaftaran_lab.operator LIKE ? OR 
				pendaftaran_lab.date_created LIKE ? OR 
				pendaftaran_lab.date_updated LIKE ? OR 
				pendaftaran_lab.id_daftar LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pendaftaran_lab/search.php";
		}
		$db->join("user_login", "pendaftaran_lab.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pendaftaran_lab.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pendaftaran Lab";
		$view_name = (is_ajax() ? "pendaftaran_lab/ajax-list.php" : "pendaftaran_lab/list.php");
		$this->render_view($view_name, $data);
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
		$fields = array("pendaftaran_lab.id", 
			"pendaftaran_lab.tanggal", 
			"pendaftaran_lab.nama_pasien", 
			"pendaftaran_lab.no_rekam_medis", 
			"pendaftaran_lab.alamat", 
			"pendaftaran_lab.no_hp", 
			"pendaftaran_lab.nama_poli", 
			"pendaftaran_lab.dokter_pengirim", 
			"pendaftaran_lab.keluhan", 
			"pendaftaran_lab.jenis_pemeriksaan", 
			"pendaftaran_lab.nama_pemeriksaan", 
			"pendaftaran_lab.pasien", 
			"pendaftaran_lab.operator", 
			"user_login.nama AS user_login_nama");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pendaftaran_lab.id", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "pendaftaran_lab.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pendaftaran Lab";
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
		return $this->render_view("pendaftaran_lab/view.php", $record);
	}
	/**
     * Insert multiple record into the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$request = $this->request;
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("jenis_pemeriksaan","nama_pemeriksaan"); 
			$allpostdata = $this->format_multi_request_data($formdata);
			$allmodeldata = array();
			foreach($allpostdata as &$postdata){
			$this->rules_array = array(
				'jenis_pemeriksaan' => 'required',
			);
			$this->sanitize_array = array(
				'jenis_pemeriksaan' => 'sanitize_string',
				'nama_pemeriksaan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
				$allmodeldata[] = $modeldata;
			}
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insertMulti($tablename, $allmodeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pendaftaran_lab");
				}
				else{
					$this->set_page_error(); //check if there's any db error and pass it to the view
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pendaftaran Lab";
		return $this->render_view("pendaftaran_lab/add.php");
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
		$fields = $this->fields = array("id","jenis_pemeriksaan","nama_pemeriksaan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'jenis_pemeriksaan' => 'required',
			);
			$this->sanitize_array = array(
				'jenis_pemeriksaan' => 'sanitize_string',
				'nama_pemeriksaan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pendaftaran_lab.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pendaftaran_lab");
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
						return	$this->redirect("pendaftaran_lab");
					}
				}
			}
		}
		$db->where("pendaftaran_lab.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pendaftaran Lab";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pendaftaran_lab/edit.php", $data);
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
		$db->where("pendaftaran_lab.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pendaftaran_lab");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function pasien($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","pasien","nama_pasien","no_rekam_medis","alamat","no_hp","keluhan","jenis_pemeriksaan","id_daftar","dokter_pengirim","nama_pemeriksaan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'pasien' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'keluhan' => 'required',
				'jenis_pemeriksaan' => 'required',
				'id_daftar' => 'required',
				'dokter_pengirim' => 'required',
				'nama_pemeriksaan' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'jenis_pemeriksaan' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'nama_pemeriksaan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE pendaftaran_lab SET setatus='Register',operator='".USER_ID."' WHERE id='$rec_id'"); 
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pendaftaran_lab");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pendaftaran Lab";
		$this->render_view("pendaftaran_lab/pasien.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function lab($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","nama_pasien","no_rekam_medis","alamat","no_hp","keluhan","pasien","nama_poli","id_daftar","dokter_pengirim");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'keluhan' => 'required',
				'pasien' => 'required',
				'nama_poli' => 'required',
				'id_daftar' => 'required',
				'dokter_pengirim' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		        $usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
//$jenisp     = $_POST['jenis_pemeriksaan'];
$namap      = $_POST['nama_pemeriksaan'];
$precord    = $_POST['precord'];
$pasien     = $_POST['pasien'];
$datprecord = $_POST['datprecord'];
$id_transaksi= $_POST['id_transaksi'];
$jenisall = "";
$namaall  = "";
$cekjen = "";
  for($b = 0; $b < count($namap); $b++){
      $namaps = trim($namap[$b]);
      //////////////////////////////////////////////
      $querypa = mysqli_query($koneksi, "SELECT * from nama_pemeriksaan_lab WHERE id='$namaps'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                  $rowspa = mysqli_num_rows($querypa);
                                  if ($rowspa <> 0) {
                                      $dathpa        = mysqli_fetch_assoc($querypa);
                                      $jenis         = $dathpa['jenis_pemeriksaan'];
                                      $nampem        = $dathpa['nama_pemeriksaan'];
                                      $nilai_rujukan = $dathpa['nilai_rujukan'];
                                      $harga         = $dathpa['harga'];
} 
$querypb = mysqli_query($koneksi, "SELECT * from jenis_pemeriksaan_lab WHERE id='$jenis'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                  $rowspb = mysqli_num_rows($querypb);
                                  if ($rowspb <> 0) {
                                      $dathpb = mysqli_fetch_assoc($querypb);
                                      $namjen = $dathpb['jenis_pemeriksaan'];
}    
                              if($namaall==""){
                              $namaall = "$nampem";
                              }else{
                                  $namaall = "$namaall, $nampem";
                              }                                 
//////////////////////////////////////
$querypa = mysqli_query($koneksi, "INSERT INTO `data_hasil_lab`( `id_daftar_lab`, `id_transaksi`, `jenis_pemeriksaan`, `nama_pemeriksaan`, `nilai_rujukan`, `harga`) VALUES ('$rec_id','$id_transaksi','$namjen','$nampem','$nilai_rujukan','$harga')"); 
/////////////////////////////////////////////
}
$qudtp = mysqli_query($koneksi, "SELECT DISTINCT jenis_pemeriksaan AS jen from data_hasil_lab WHERE id_transaksi='$id_transaksi'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rodtp = mysqli_num_rows($qudtp);
  if ($rodtp <> 0) {
  //  $cdt= mysqli_fetch_assoc($qudt);
  //  $spesial=$cdt['specialist'];
  while ($datp = MySQLi_fetch_array($qudtp)) {
      $namjen = $datp['jen'];
  if($jenisall==""){
$jenisall = $namjen;
}else{
    $jenisall = "$jenisall, $namjen";
}
}
}
mysqli_query($koneksi,"INSERT INTO `hasil_lab` (`id_transaksi`,`dokter_pengirim`,`nama_poli`,`id_daftar_lab`,`tanggal`,`nama_pasien`,`no_rekam_medis`,`alamat`,`no_hp`,`keluhan`,`pasien`,`jenis_pemeriksaan`,`nama_pemeriksaan`) VALUES ('$id_transaksi','".$_POST['dokter_pengirim']."','".$_POST['nama_poli']."','$rec_id','".$_POST['tanggal']."','".$_POST['nama_pasien']."','".$_POST['no_rekam_medis']."','".$_POST['alamat']."','".$_POST['no_hp']."','".$_POST['keluhan']."','".$_POST['pasien']."','$jenisall','$namaall')"); 
$querypc = mysqli_query($koneksi, "SELECT * from hasil_lab WHERE id_transaksi='$id_transaksi' and id_daftar_lab='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                  $rowspc = mysqli_num_rows($querypc);
                                  if ($rowspc <> 0) {
                                      $dathpc  = mysqli_fetch_assoc($querypc);
                                      $odhasil = $dathpc['id_hasil_lab'];
} 
                                  mysqli_query($koneksi, "UPDATE data_hasil_lab SET id_hasil_lab='$odhasil' WHERE id_transaksi='$id_transaksi' and id_daftar_lab='$rec_id'");
$db->rawQuery("UPDATE pendaftaran_lab SET jenis_pemeriksaan='$jenisall', nama_pemeriksaan='$namaall' WHERE id='$rec_id'");
/////////////////////////////////////////////////////////
$queryjum = mysqli_query($koneksi, "SELECT SUM(harga) AS tot from data_hasil_lab WHERE id_daftar_lab='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$sumjum = mysqli_fetch_assoc($queryjum); 
$tottag = $sumjum['tot'];
mysqli_query($koneksi, "UPDATE hasil_lab SET total_harga='$tottag' WHERE id_daftar_lab='$rec_id'"); 
$db->rawQuery("UPDATE pendaftaran_lab SET setatus='Register',operator='".USER_ID."' WHERE id='$rec_id'"); 
  $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE id='$id_transaksi'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrxb = mysqli_num_rows($quetrxb);
  if ($rotrxb <> 0) {
        $dattrxb    = mysqli_fetch_assoc($quetrxb);
        $idtrx      = $dattrxb['id'];  
        $tottagawal = $dattrxb['total_tagihan'];
        //  $no_invoice = "INVRJLN$idtrx";
        $tottagakhir = $tottagawal + $tottag;
        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
  }
 $quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_data='$odhasil'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotag = mysqli_num_rows($quetag);
  if ($rotag <> 0) {
  }else{
      mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES (' $idtrx','$odhasil','Laboratorium','".$_POST['tanggal']."','$no_rekam_medis','$tottag','Register','$pasien','Pemeriksaan Lab')");
  }
  ///////////////////////////////////////////////////////////////////////////////
  $key            = "dermawangroup";
$plaintext      = "".$_POST['id_daftar'];
$ivlen          = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv             = openssl_random_pseudo_bytes($ivlen);
$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$hmac           = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
$ciphertext     = base64_encode( $iv.$hmac.$ciphertext_raw );
$this->set_flash_msg("Data Lab Berhasil Di Simpan!! ", "success");
if($pasien=="POLI"){
return  $this->redirect("pendaftaran_poli/dokter?precord=$ciphertext&datrm=".$_POST['no_rekam_medis']);
}else if($pasien=="IGD"){
return  $this->redirect("igd");
}else if($pasien=="RANAP ANAK"){
return  $this->redirect("ranap_anak");
}else if($pasien=="RANAP BERSALIN"){
return  $this->redirect("ranap_bersalin");
}else if($pasien=="RANAP PERINA"){
return  $this->redirect("ranap_perina");
}else{
    return  $this->redirect("rawat_inap");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pendaftaran_lab");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pendaftaran Lab";
		$this->render_view("pendaftaran_lab/lab.php");
	}
}
