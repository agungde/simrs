<?php 
/**
 * kunjungan_dokter_ranap_anak Page Controller
 * @category  Controller
 */
class kunjungan_dokter_ranap_anakController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "kunjungan_dokter_ranap_anak";
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
		$fields = array("kunjungan_dokter_ranap_anak.id", 
			"kunjungan_dokter_ranap_anak.id_daftar", 
			"kunjungan_dokter_ranap_anak.tanggal", 
			"kunjungan_dokter_ranap_anak.no_rekam_medis", 
			"kunjungan_dokter_ranap_anak.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"kunjungan_dokter_ranap_anak.specialist", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"kunjungan_dokter_ranap_anak.ttd", 
			"kunjungan_dokter_ranap_anak.keterangan", 
			"kunjungan_dokter_ranap_anak.id_transaksi", 
			"kunjungan_dokter_ranap_anak.operator", 
			"user_login.nama AS user_login_nama");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->datprecord)){
$idpas = $request->datprecord;
    $db->where("id_daftar='$idpas'");
}else{
    if(!empty($request->limit_start)){
        }else{
               $this->set_flash_msg("URL Tidak Valid!! ", "danger");
               //return  $this->redirect("rekam_medis");
        }
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				kunjungan_dokter_ranap_anak.id LIKE ? OR 
				kunjungan_dokter_ranap_anak.id_daftar LIKE ? OR 
				kunjungan_dokter_ranap_anak.tanggal LIKE ? OR 
				kunjungan_dokter_ranap_anak.no_rekam_medis LIKE ? OR 
				kunjungan_dokter_ranap_anak.dokter LIKE ? OR 
				kunjungan_dokter_ranap_anak.specialist LIKE ? OR 
				kunjungan_dokter_ranap_anak.ttd LIKE ? OR 
				kunjungan_dokter_ranap_anak.keterangan LIKE ? OR 
				kunjungan_dokter_ranap_anak.id_transaksi LIKE ? OR 
				kunjungan_dokter_ranap_anak.operator LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "kunjungan_dokter_ranap_anak/search.php";
		}
		$db->join("data_dokter", "kunjungan_dokter_ranap_anak.dokter = data_dokter.id_dokter", "INNER");
		$db->join("data_poli", "kunjungan_dokter_ranap_anak.specialist = data_poli.id_poli", "INNER");
		$db->join("user_login", "kunjungan_dokter_ranap_anak.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("kunjungan_dokter_ranap_anak.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Kunjungan Dokter";
		$this->render_view("kunjungan_dokter_ranap_anak/list.php", $data); //render the full page
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
		$fields = array("kunjungan_dokter_ranap_anak.id", 
			"kunjungan_dokter_ranap_anak.id_daftar", 
			"kunjungan_dokter_ranap_anak.tanggal", 
			"kunjungan_dokter_ranap_anak.no_rekam_medis", 
			"kunjungan_dokter_ranap_anak.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"kunjungan_dokter_ranap_anak.specialist", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"kunjungan_dokter_ranap_anak.ttd", 
			"kunjungan_dokter_ranap_anak.keterangan", 
			"kunjungan_dokter_ranap_anak.id_transaksi", 
			"kunjungan_dokter_ranap_anak.operator", 
			"user_login.nama AS user_login_nama");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("kunjungan_dokter_ranap_anak.id", $rec_id);; //select record based on primary key
		}
		$db->join("data_dokter", "kunjungan_dokter_ranap_anak.dokter = data_dokter.id_dokter", "INNER");
		$db->join("data_poli", "kunjungan_dokter_ranap_anak.specialist = data_poli.id_poli", "INNER");
		$db->join("user_login", "kunjungan_dokter_ranap_anak.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Kunjungan Dokter";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("kunjungan_dokter_ranap_anak/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","tanggal","no_rekam_medis","dokter","keterangan","id_transaksi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'dokter' => 'required',
				'keterangan' => 'required',
				'id_transaksi' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
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
$id_daftar      = $_POST['id_daftar'];
$tanggal        = $_POST['tanggal'];
$no_rekam_medis = $_POST['no_rekam_medis'];
$dokter         = $_POST['dokter'];
$idback         = $_POST['idback'];
$qutrt = mysqli_query($koneksi, "SELECT * from kunjungan_dokter_ranap_anak WHERE dokter='$dokter' and tanggal='$tanggal' and id_daftar='$id_daftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rotrt = mysqli_num_rows($qutrt);
  if ($rotrt <> 0) {
      $this->set_flash_msg("Kunjungan Tanggal $tanggal Sudah Ada!!", "danger");
      return  $this->redirect("kunjungan_dokter_ranap_anak?precord=$idback&datprecord=$id_daftar");       
  }
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$qutrt = mysqli_query($koneksi, "SELECT * from data_dokter WHERE id_dokter='$dokter'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rotrt = mysqli_num_rows($qutrt);
  if ($rotrt <> 0) {
            $ctp= mysqli_fetch_assoc($qutrt);
$specialist=$ctp['specialist'];
  $jasa_kunjungan = $ctp['jasa_kunjungan'];    
  }
$db->rawQuery("UPDATE kunjungan_dokter_ranap_anak SET specialist='$specialist', operator='$id_user' WHERE id='$rec_id'");
$idtransaksi = $_POST['id_transaksi'];
 $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE id='$idtransaksi' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrxb = mysqli_num_rows($quetrxb);
  if ($rotrxb <> 0) {
        $dattrxb    = mysqli_fetch_assoc($quetrxb);
        $idtrx      = $dattrxb['id'];  
        $totaltagih=$dattrxb['total_tagihan'];
  }
    $jumlahatag = $jasa_kunjungan + $totaltagih;
mysqli_query($koneksi,"UPDATE transaksi SET total_tagihan='$jumlahatag'  WHERE id='$idtrx'");
mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','Kunjungan Dokter','".date("Y-m-d H:i:s")."','$no_rekam_medis','$jasa_kunjungan','Register','IRAWAT INAP','Jasa Kunjungan Dokter')");
     $this->set_flash_msg("Kunjungan Dokter Tanggal $tanggal Berhasil!!", "success");
     return  $this->redirect("rawat_inap");   
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("kunjungan_dokter_ranap_anak");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Kunjungan Dokter";
		$this->render_view("kunjungan_dokter_ranap_anak/add.php");
		$this->render_view("kunjungan_dokter_ranap_anak/ranap_anak.php");
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
		$fields = $this->fields = array("id","id_daftar","tanggal","no_rekam_medis","dokter","keterangan","id_transaksi");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'dokter' => 'required',
				'keterangan' => 'required',
				'id_transaksi' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("kunjungan_dokter_ranap_anak.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("kunjungan_dokter_ranap_anak");
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
						return	$this->redirect("kunjungan_dokter_ranap_anak");
					}
				}
			}
		}
		$db->where("kunjungan_dokter_ranap_anak.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Kunjungan Dokter";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("kunjungan_dokter_ranap_anak/edit.php", $data);
	}
}
