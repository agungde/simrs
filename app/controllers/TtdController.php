<?php 
/**
 * Ttd Page Controller
 * @category  Controller
 */
class TtdController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ttd";
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
			"ttd", 
			"untuk", 
			"no_rekam_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				ttd.id LIKE ? OR 
				ttd.id_daftar LIKE ? OR 
				ttd.ttd LIKE ? OR 
				ttd.untuk LIKE ? OR 
				ttd.no_rekam_medis LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "ttd/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("ttd.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Ttd";
		$this->render_view("ttd/list.php", $data); //render the full page
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
			$fields = $this->fields = array("id_daftar","ttd","untuk","no_rekam_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'ttd' => 'required',
				'untuk' => 'required',
				'no_rekam_medis' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'ttd' => 'sanitize_string',
				'untuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$siteaddr = "".SITE_ADDR;
if(isset($_POST['signaturesubmit'])){ 
$fttd = "uploads/ttd/";
if(is_dir($fttd)) {
    //echo ("$file is a directory");
} else {
    mkdir("$fttd", 0770, true); 
}
    $signature         = $_POST['signature'];
    $signatureFileName = uniqid().'.png';
    $signature         = str_replace('data:image/png;base64,', '', $signature);
    $signature         = str_replace(' ', '+', $signature);
    $data              = base64_decode($signature);
    $file              = 'uploads/ttd/'.$signatureFileName;
    file_put_contents($file, $data);
    // $msg = "<div class='alert alert-success'>Signature Uploaded</div>";
} 
$db->rawQuery("UPDATE ttd SET ttd='$file' WHERE id='$rec_id'");
$posiddaftar = $_POST['id_daftar'];
$datdari     = $_POST['datdari'];
$darecord    = $_POST['darecord'];
$precord     = $_POST['precord'];
$pasien      = $_POST['pasien'];
$datfrom = $_POST['datfrom'];
$datprecord= $_POST['datprecord'];
if($datfrom==""){
$posiddaftar = $posiddaftar;
}else{
    $posiddaftar = $datfrom;
}
$this->set_flash_msg("TTD Berhasil Di Buat", "success");
if($darecord=="pendaftaran_poli"){
return  $this->redirect("$datdari/pulang?precord=$precord&datprecord=$datprecord&darecord=$darecord&ttdok=OK&pasien=$pasien");
}else{
    if($datdari=="assesment_triase" or $datdari=="assesment_medis" or $datdari=="perintah_opname"){
return  $this->redirect("$datdari/add?precord=$precord&datprecord=$datprecord&darecord=$darecord&ttdok=OK&pasien=$pasien");
}else{
if($darecord=="igd"){
return  $this->redirect("$datdari/pulang?precord=$precord&datprecord=$datprecord&darecord=$darecord&ttdok=OK&pasien=$pasien");
}else{
    return  $this->redirect("$datdari/add?precord=$precord&datprecord=$datprecord&darecord=$darecord&ttdok=OK&pasien=$pasien");
}
}
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("ttd");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Ttd";
		$this->render_view("ttd/add.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function approval($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_daftar","ttd","untuk","no_rekam_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required|numeric',
				'ttd' => 'required',
				'untuk' => 'required',
				'no_rekam_medis' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'ttd' => 'sanitize_string',
				'untuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
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
$siteaddr = "".SITE_ADDR;
if(isset($_POST['signaturesubmit'])){ 
$fttd = "uploads/ttd/";
if(is_dir($fttd)) {
    //echo ("$file is a directory");
} else {
    mkdir("$fttd", 0770, true); 
}
    $signature         = $_POST['signature'];
    $signatureFileName = uniqid().'.png';
    $signature         = str_replace('data:image/png;base64,', '', $signature);
    $signature         = str_replace(' ', '+', $signature);
    $data              = base64_decode($signature);
    $file              = 'uploads/ttd/'.$signatureFileName;
    file_put_contents($file, $data);
    // $msg = "<div class='alert alert-success'>Signature Uploaded</div>";
} 
$untuk = $_POST['untuk'];
$token = $_POST['token'];
$db->rawQuery("UPDATE ttd SET ttd='$file' WHERE id='$rec_id'");
//no_request
mysqli_query($koneksi,"UPDATE permintaan_barang SET approval='$file', setatus='Approv', date_updated='".date("Y-m-d H:i:s")."' WHERE no_request='$untuk'");
$this->set_flash_msg("Approval Berhasil Di Proses!!", "success");
return  $this->redirect("permintaan_barang");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("ttd");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Ttd";
		$this->render_view("ttd/approval.php");
	}
}
