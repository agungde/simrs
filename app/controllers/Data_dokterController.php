<?php 
/**
 * Data_dokter Page Controller
 * @category  Controller
 */
class Data_dokterController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_dokter";
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
		$fields = array("data_dokter.id_dokter", 
			"data_dokter.nama_dokter", 
			"data_dokter.jenis_kelamin", 
			"data_dokter.no_hp", 
			"data_dokter.alamat", 
			"data_dokter.specialist", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"data_dokter.email", 
			"data_dokter.id_user", 
			"data_dokter.jasa_poli", 
			"data_dokter.jasa_kunjungan", 
			"data_dokter.photo", 
			"data_dokter.tagihan_jasa_poli", 
			"data_dokter.tagihan_jasa_kunjungan", 
			"data_dokter.jasa_igd", 
			"data_dokter.tagihan_jasa_igd", 
			"data_dokter.operator", 
			"data_dokter.date_created", 
			"data_dokter.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	 $id_user = "".USER_ID;
 $dbhost="".DB_HOST;
$dbuser="".DB_USERNAME;
$dbpass="".DB_PASSWORD;
$dbname="".DB_NAME;
//$koneksi=open_connection();
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$cekdata = "";
$sqlcek  = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
while ($row=mysqli_fetch_array($sqlcek)){
$cekdata=$row['user_role_id'];
}
if($cekdata=="1" or $cekdata=="4"){
}else{
    $db->where("id_user='". USER_ID . "'");
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_dokter.id_dokter LIKE ? OR 
				data_dokter.nama_dokter LIKE ? OR 
				data_dokter.jenis_kelamin LIKE ? OR 
				data_dokter.no_hp LIKE ? OR 
				data_dokter.alamat LIKE ? OR 
				data_dokter.specialist LIKE ? OR 
				data_dokter.email LIKE ? OR 
				data_dokter.id_user LIKE ? OR 
				data_dokter.jasa_poli LIKE ? OR 
				data_dokter.jasa_kunjungan LIKE ? OR 
				data_dokter.photo LIKE ? OR 
				data_dokter.tagihan_jasa_poli LIKE ? OR 
				data_dokter.tagihan_jasa_kunjungan LIKE ? OR 
				data_dokter.jasa_igd LIKE ? OR 
				data_dokter.tagihan_jasa_igd LIKE ? OR 
				data_dokter.operator LIKE ? OR 
				data_dokter.date_created LIKE ? OR 
				data_dokter.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_dokter/search.php";
		}
		$db->join("data_poli", "data_dokter.specialist = data_poli.id_poli", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_dokter.id_dokter", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Dokter";
		$view_name = (is_ajax() ? "data_dokter/ajax-list.php" : "data_dokter/list.php");
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
		$fields = array("data_dokter.id_dokter", 
			"data_dokter.nama_dokter", 
			"data_dokter.jenis_kelamin", 
			"data_dokter.no_hp", 
			"data_dokter.alamat", 
			"data_dokter.specialist", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"data_dokter.email", 
			"data_dokter.jasa_poli", 
			"data_dokter.jasa_kunjungan", 
			"data_dokter.photo", 
			"data_dokter.operator", 
			"data_dokter.date_created", 
			"data_dokter.date_updated", 
			"data_dokter.tagihan_jasa_poli", 
			"data_dokter.tagihan_jasa_kunjungan", 
			"data_dokter.jasa_igd", 
			"data_dokter.tagihan_jasa_igd");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_dokter.id_dokter", $rec_id);; //select record based on primary key
		}
		$db->join("data_poli", "data_dokter.specialist = data_poli.id_poli", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Dokter";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_dokter/view.php", $record);
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
			$fields = $this->fields = array("username","nama_dokter","alamat","jenis_kelamin","no_hp","specialist","email","photo","jasa_poli","tagihan_jasa_poli","jasa_kunjungan","tagihan_jasa_kunjungan","jasa_igd","tagihan_jasa_igd");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'username' => 'required',
				'nama_dokter' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'no_hp' => 'required',
				'specialist' => 'required',
				'email' => 'required|valid_email',
				'jasa_poli' => 'required|numeric',
				'tagihan_jasa_poli' => 'required',
				'jasa_kunjungan' => 'required',
				'tagihan_jasa_kunjungan' => 'required',
				'jasa_igd' => 'required|numeric',
				'tagihan_jasa_igd' => 'required',
			);
			$this->sanitize_array = array(
				'username' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'specialist' => 'sanitize_string',
				'email' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'jasa_poli' => 'sanitize_string',
				'tagihan_jasa_poli' => 'sanitize_string',
				'jasa_kunjungan' => 'sanitize_string',
				'tagihan_jasa_kunjungan' => 'sanitize_string',
				'jasa_igd' => 'sanitize_string',
				'tagihan_jasa_igd' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE data_dokter SET operator='".USER_ID."' WHERE id_dokter='$rec_id'");
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
//$koneksi=open_connection();
$koneksi       = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$password_hash = password_hash("drpoli", PASSWORD_DEFAULT);
mysqli_query($koneksi,"INSERT INTO `user_login` (`nama`, `username`, `email`, `password`, `id_dokter`, `user_role_id`) VALUES ('".$_POST['nama_dokter']."','".$_POST['username']."', '".$_POST['email']."', '$password_hash', '$rec_id', '3')"); 
$sqlcek1 = mysqli_query($koneksi,"select * from user_login WHERE id_dokter='$rec_id'");
while ($row=mysqli_fetch_array($sqlcek1)){
    $cekdata1 = $row['id_userlogin'];
    $db->rawQuery("UPDATE data_dokter SET id_user='$cekdata1' WHERE id_dokter='$rec_id'");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_dokter");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Dokter";
		$this->render_view("data_dokter/add.php");
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
		$fields = $this->fields = array("id_dokter","nama_dokter","alamat","jenis_kelamin","no_hp","specialist","email","photo","jasa_poli","tagihan_jasa_poli","jasa_kunjungan","tagihan_jasa_kunjungan","jasa_igd","tagihan_jasa_igd");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_dokter' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'no_hp' => 'required',
				'specialist' => 'required',
				'email' => 'required|valid_email',
				'jasa_poli' => 'required|numeric',
				'tagihan_jasa_poli' => 'required',
				'jasa_kunjungan' => 'required',
				'tagihan_jasa_kunjungan' => 'required',
				'jasa_igd' => 'required|numeric',
				'tagihan_jasa_igd' => 'required',
			);
			$this->sanitize_array = array(
				'nama_dokter' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'specialist' => 'sanitize_string',
				'email' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'jasa_poli' => 'sanitize_string',
				'tagihan_jasa_poli' => 'sanitize_string',
				'jasa_kunjungan' => 'sanitize_string',
				'tagihan_jasa_kunjungan' => 'sanitize_string',
				'jasa_igd' => 'sanitize_string',
				'tagihan_jasa_igd' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_dokter.id_dokter", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$db->rawQuery("UPDATE data_dokter SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_dokter='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_dokter");
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
						return	$this->redirect("data_dokter");
					}
				}
			}
		}
		$db->where("data_dokter.id_dokter", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Dokter";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_dokter/edit.php", $data);
	}
}
