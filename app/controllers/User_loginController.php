<?php 
/**
 * User_login Page Controller
 * @category  Controller
 */
class User_loginController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "user_login";
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
		$fields = array("user_login.id_userlogin", 
			"user_login.nama", 
			"user_login.username", 
			"user_login.email", 
			"user_login.user_role_id", 
			"roles.role_name AS roles_role_name", 
			"user_login.photo", 
			"user_login.setatus", 
			"user_login.operator", 
			"user_login.date_created", 
			"user_login.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				user_login.id_userlogin LIKE ? OR 
				user_login.id_dokter LIKE ? OR 
				user_login.nama LIKE ? OR 
				user_login.username LIKE ? OR 
				user_login.email LIKE ? OR 
				user_login.password LIKE ? OR 
				user_login.user_role_id LIKE ? OR 
				user_login.admin_poli LIKE ? OR 
				user_login.photo LIKE ? OR 
				user_login.setatus LIKE ? OR 
				user_login.operator LIKE ? OR 
				user_login.date_created LIKE ? OR 
				user_login.date_updated LIKE ? OR 
				user_login.chat LIKE ? OR 
				user_login.device LIKE ? OR 
				user_login.last_login LIKE ? OR 
				user_login.no_ktp LIKE ? OR 
				user_login.admin_ranap LIKE ? OR 
				user_login.admin_ranap_perina LIKE ? OR 
				user_login.admin_ranap_anak LIKE ? OR 
				user_login.admin_ranap_bersalin LIKE ? OR 
				user_login.loket LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "user_login/search.php";
		}
		$db->join("roles", "user_login.user_role_id = roles.role_id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("user_login.id_userlogin", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "User Login";
		$this->render_view("user_login/list.php", $data); //render the full page
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
		$fields = array("user_login.id_userlogin", 
			"user_login.nama", 
			"user_login.email", 
			"user_login.user_role_id", 
			"roles.role_name AS roles_role_name", 
			"user_login.username", 
			"user_login.setatus", 
			"user_login.operator", 
			"user_login.date_created", 
			"user_login.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("user_login.id_userlogin", $rec_id);; //select record based on primary key
		}
		$db->join("roles", "user_login.user_role_id = roles.role_id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  User Login";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("user_login/view.php", $record);
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
			$fields = $this->fields = array("nama","username","email","password","user_role_id","admin_poli","admin_ranap","admin_ranap_perina","admin_ranap_anak","admin_ranap_bersalin","loket","photo");
			$postdata = $this->format_request_data($formdata);
			$cpassword = $postdata['confirm_password'];
			$password = $postdata['password'];
			if($cpassword != $password){
				$this->view->page_error[] = "Your password confirmation is not consistent";
			}
			$this->rules_array = array(
				'nama' => 'required',
				'username' => 'required',
				'email' => 'required|valid_email',
				'password' => 'required',
				'user_role_id' => 'required',
			);
			$this->sanitize_array = array(
				'nama' => 'sanitize_string',
				'username' => 'sanitize_string',
				'email' => 'sanitize_string',
				'user_role_id' => 'sanitize_string',
				'admin_poli' => 'sanitize_string',
				'admin_ranap' => 'sanitize_string',
				'admin_ranap_perina' => 'sanitize_string',
				'admin_ranap_anak' => 'sanitize_string',
				'admin_ranap_bersalin' => 'sanitize_string',
				'loket' => 'sanitize_string',
				'photo' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$password_text = $modeldata['password'];
			//update modeldata with the password hash
			$modeldata['password'] = $this->modeldata['password'] = password_hash($password_text , PASSWORD_DEFAULT);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("nama", $modeldata['nama']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['nama']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("username", $modeldata['username']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['username']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("email", $modeldata['email']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['email']." Already exist!";
			} 
			if($this->validated()){
		# Statement to execute before adding record
		$userroleid = $_POST['user_role_id'];
if (isset($_POST['admin_poli'])) {
$adminpoli  = $_POST['admin_poli'];
}else{
    $adminpoli = "";
}
if (isset($_POST['admin_ranap'])) {
$adminranap = $_POST['admin_ranap'];
}else{
    $adminranap = "";
}
if($userroleid=="6"){
if($adminpoli=="" or $adminpoli=="0"){
$this->set_flash_msg("Harus Pilih Admin Poli", "warning");
return  $this->redirect("user_login/add");
}
}
if($userroleid=="13"){
if($adminranap=="" or $adminranap=="0"){
$this->set_flash_msg("Harus Pilih Kamar Ranap", "warning");
return  $this->redirect("user_login/add");
}
}
if (isset($_POST['admin_ranap_anak'])) {
$adminranap_anak = $_POST['admin_ranap_anak'];
}else{
    $adminranap_anak = "";
}
if (isset($_POST['admin_ranap_perina'])) {
$adminranap_perina = $_POST['admin_ranap_perina'];
}else{
    $adminranap_perina = "";
}
if (isset($_POST['admin_ranap_bersalin'])) {
$adminranap_bersalin = $_POST['admin_ranap_bersalin'];
}else{
    $adminranap_bersalin = "";
}
if($userroleid=="21"){
if($adminranap_perina=="" or $adminranap_perina=="0"){
$this->set_flash_msg("Harus Pilih Kama Ranapr Perina", "warning");
return  $this->redirect("user_login/add");
}
}
if($userroleid=="22"){
if($adminranap_anak=="" or $adminranap_anak=="0"){
$this->set_flash_msg("Harus Pilih Kamar Ranap Anak", "warning");
return  $this->redirect("user_login/add");
}
}
if($userroleid=="23"){
if($adminranap_bersalin=="" or $adminranap_bersalin=="0"){
$this->set_flash_msg("Harus Pilih Kamar Ranap Bersalin", "warning");
return  $this->redirect("user_login/add");
}
}
if (isset($_POST['loket'])) {
$loket = $_POST['loket'];
}else{
    $loket = "";
}
if($userroleid=="19"){
if($loket=="" or $loket=="0"){
$this->set_flash_msg("Harus Pilih Loket Bersalin", "warning");
return  $this->redirect("user_login/add");
}
}
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE user_login SET operator='".USER_ID."' WHERE id_userlogin='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("user_login");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New User Login";
		$this->render_view("user_login/add.php");
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
		$fields = $this->fields = array("id_userlogin","nama","username","photo");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama' => 'required',
				'username' => 'required',
			);
			$this->sanitize_array = array(
				'nama' => 'sanitize_string',
				'username' => 'sanitize_string',
				'photo' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['nama'])){
				$db->where("nama", $modeldata['nama'])->where("id_userlogin", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['nama']." Already exist!";
				}
			}
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['username'])){
				$db->where("username", $modeldata['username'])->where("id_userlogin", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['username']." Already exist!";
				}
			} 
			if($this->validated()){
		# Statement to execute after adding record
		if($rec_id=="" or $rec_id=="0"){
 $this->set_flash_msg("Di Larang Edite System", "warning");
 return  $this->redirect("user_login");
}else{
}
		# End of before update statement
				//get files link to be deleted before updating records
				$file_fields = array('photo'); //list of file fields
				$db->where("user_login.id_userlogin", $rec_id);;
				$fields_file_paths = $db->getOne($tablename, $file_fields);
				$db->where("user_login.id_userlogin", $rec_id);;
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
		# Statement to execute after adding record
			if (isset($_POST['user_role_id'])) {
$roles = $_POST['user_role_id'];
}else{
    $roles = "";
}
if (isset($_POST['admin_poli'])) {
$admin_poli = $_POST['admin_poli'];
}else{
    $admin_poli = "0";
}
if (isset($_POST['admin_ranap'])) {
$admin_ranap = $_POST['admin_ranap'];
}else{
    $admin_ranap = "0";
}
if (isset($_POST['admin_ranap_anak'])) {
$admin_ranap_anak = $_POST['admin_ranap_anak'];
}else{
    $admin_ranap_anak = "0";
}
if (isset($_POST['admin_ranap_perina'])) {
$admin_ranap_perina = $_POST['admin_ranap_perina'];
}else{
    $admin_ranap_perina = "0";
}
if (isset($_POST['admin_ranap_bersalin'])) {
$admin_ranap_bersalin = $_POST['admin_ranap_bersalin'];
}else{
    $admin_ranap_bersalin = "0";
}
if($roles==""){
 $db->rawQuery("UPDATE user_login SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_userlogin='$rec_id'");   
    }else{
$db->rawQuery("UPDATE user_login SET user_role_id='$roles', admin_poli='$admin_poli',admin_ranap='$admin_ranap', admin_ranap_anak='$admin_ranap_anak', admin_ranap_perina='$admin_ranap_perina', admin_ranap_bersalin='$admin_ranap_bersalin', operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_userlogin='$rec_id'");     
    }
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("user_login");
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
						return	$this->redirect("user_login");
					}
				}
			}
		}
		$db->where("user_login.id_userlogin", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  User Login";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("user_login/edit.php", $data);
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
	#Statement to execute before delete record
	if($rec_id=="" or $rec_id=="0"){
 $this->set_flash_msg("Di Larang Delete System", "warning");
 return  $this->redirect("user_login");
}else{
}
	# End of before delete statement
		//list of file fields
		$file_fields = array('photo'); 
		foreach( $arr_id as $rec_id ){
			$db->where("user_login.id_userlogin", $arr_rec_id, "in");;
		}
		//get files link to be deleted before deleting records
		$files = $db->get($tablename, null , $file_fields); 
		$db->where("user_login.id_userlogin", $arr_rec_id, "in");
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
		return	$this->redirect("user_login");
	}
}
