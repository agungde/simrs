<?php 
/**
 * Catatan_medis Page Controller
 * @category  Controller
 */
class Catatan_medisController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "catatan_medis";
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
			"no_rekam_medis", 
			"pasien", 
			"nama_poli", 
			"dokter", 
			"catatan_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->detile_precord)){
$rekam = $request->detile_precord;
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
				catatan_medis.id LIKE ? OR 
				catatan_medis.id_daftar LIKE ? OR 
				catatan_medis.tanggal LIKE ? OR 
				catatan_medis.no_rekam_medis LIKE ? OR 
				catatan_medis.pasien LIKE ? OR 
				catatan_medis.nama_poli LIKE ? OR 
				catatan_medis.dokter LIKE ? OR 
				catatan_medis.catatan_medis LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "catatan_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("catatan_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Catatan Medis";
		$this->render_view("catatan_medis/list.php", $data); //render the full page
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
			"id_daftar", 
			"tanggal", 
			"no_rekam_medis", 
			"pasien", 
			"nama_poli", 
			"dokter", 
			"catatan_medis");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("catatan_medis.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Catatan Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("catatan_medis/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","tanggal","no_rekam_medis","pasien","nama_poli","dokter","catatan_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'pasien' => 'required',
				'dokter' => 'required',
				'catatan_medis' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
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
$pospasien      = $_POST['pasien'];
$no_rekam_medis = $_POST['no_rekam_medis'];
$catatan_medis  = $_POST['catatan_medis'];
$id_daftar      = $_POST['id_daftar'];
$queryc = mysqli_query($koneksi, "select * from data_rekam_medis WHERE id_daftar='$id_daftar' and no_rekam_medis='$no_rekam_medis' ORDER BY id DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
 $rowsc = mysqli_num_rows($queryc);
  if ($rowsc <> 0) {
      $rowc  = mysqli_fetch_assoc($queryc); 
      $idapp = $rowc['id'];
      mysqli_query($koneksi, "UPDATE data_rekam_medis SET catatan_medis='$catatan_medis' WHERE id='$idapp'");
  }
$this->set_flash_msg("Catatan Medis Berhasil Di input!!", "success");
if($pospasien=="POLI"){
return  $this->redirect("pendaftaran_poli");
}else if($pospasien=="IGD"){
return  $this->redirect("igd");
}else if($pospasien=="RAWAT INAP"){
return  $this->redirect("rawat_inap");
}else if($pospasien=="RANAP ANAK"){
return  $this->redirect("ranap_anak");
}else if($pospasien=="RANAP PERINA"){
return  $this->redirect("ranap_perina");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("catatan_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Catatan Medis";
		$this->render_view("catatan_medis/add.php");
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
		$fields = $this->fields = array("id","id_daftar","tanggal","no_rekam_medis","pasien","nama_poli","dokter","catatan_medis");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'pasien' => 'required',
				'dokter' => 'required',
				'catatan_medis' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("catatan_medis.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("catatan_medis");
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
						return	$this->redirect("catatan_medis");
					}
				}
			}
		}
		$db->where("catatan_medis.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Catatan Medis";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("catatan_medis/edit.php", $data);
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
		$db->where("catatan_medis.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("catatan_medis");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function catatan($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal", 
			"no_rekam_medis", 
			"pasien", 
			"nama_poli", 
			"dokter", 
			"catatan_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				catatan_medis.id LIKE ? OR 
				catatan_medis.id_daftar LIKE ? OR 
				catatan_medis.tanggal LIKE ? OR 
				catatan_medis.no_rekam_medis LIKE ? OR 
				catatan_medis.pasien LIKE ? OR 
				catatan_medis.nama_poli LIKE ? OR 
				catatan_medis.dokter LIKE ? OR 
				catatan_medis.catatan_medis LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "catatan_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("catatan_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Catatan Medis";
		$this->render_view("catatan_medis/catatan.php", $data); //render the full page
	}
}
