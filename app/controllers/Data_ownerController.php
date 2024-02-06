<?php 
/**
 * Data_owner Page Controller
 * @category  Controller
 */
class Data_ownerController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_owner";
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
			"nama", 
			"alamat", 
			"email", 
			"phone", 
			"harga_layanan_pasien_baru", 
			"harga_layanan_pasien_lama", 
			"biaya_layanan", 
			"logo", 
			"date_created", 
			"date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_owner.id LIKE ? OR 
				data_owner.nama LIKE ? OR 
				data_owner.alamat LIKE ? OR 
				data_owner.email LIKE ? OR 
				data_owner.phone LIKE ? OR 
				data_owner.operator LIKE ? OR 
				data_owner.harga_layanan_pasien_baru LIKE ? OR 
				data_owner.harga_layanan_pasien_lama LIKE ? OR 
				data_owner.biaya_layanan LIKE ? OR 
				data_owner.logo LIKE ? OR 
				data_owner.date_created LIKE ? OR 
				data_owner.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_owner/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_owner.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Owner";
		$this->render_view("data_owner/list.php", $data); //render the full page
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
			"nama", 
			"alamat", 
			"email", 
			"phone", 
			"logo");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_owner.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Owner";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_owner/view.php", $record);
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
			$fields = $this->fields = array("nama","alamat","email","phone","harga_layanan_pasien_baru","harga_layanan_pasien_lama","biaya_layanan","logo");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama' => 'required',
				'alamat' => 'required',
				'email' => 'required|valid_email',
				'phone' => 'required',
				'harga_layanan_pasien_baru' => 'required|numeric',
				'harga_layanan_pasien_lama' => 'required|numeric',
				'biaya_layanan' => 'required',
				'logo' => 'required',
			);
			$this->sanitize_array = array(
				'nama' => 'sanitize_string',
				'email' => 'sanitize_string',
				'phone' => 'sanitize_string',
				'harga_layanan_pasien_baru' => 'sanitize_string',
				'harga_layanan_pasien_lama' => 'sanitize_string',
				'biaya_layanan' => 'sanitize_string',
				'logo' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_owner");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Owner";
		$this->render_view("data_owner/add.php");
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
		$fields = $this->fields = array("id","nama","alamat","email","phone","harga_layanan_pasien_baru","harga_layanan_pasien_lama","biaya_layanan","logo");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama' => 'required',
				'alamat' => 'required',
				'email' => 'required|valid_email',
				'phone' => 'required',
				'harga_layanan_pasien_baru' => 'required|numeric',
				'harga_layanan_pasien_lama' => 'required|numeric',
				'biaya_layanan' => 'required',
				'logo' => 'required',
			);
			$this->sanitize_array = array(
				'nama' => 'sanitize_string',
				'email' => 'sanitize_string',
				'phone' => 'sanitize_string',
				'harga_layanan_pasien_baru' => 'sanitize_string',
				'harga_layanan_pasien_lama' => 'sanitize_string',
				'biaya_layanan' => 'sanitize_string',
				'logo' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				//get files link to be deleted before updating records
				$file_fields = array('logo'); //list of file fields
				$db->where("data_owner.id", $rec_id);;
				$fields_file_paths = $db->getOne($tablename, $file_fields);
				$db->where("data_owner.id", $rec_id);;
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
			$db->rawQuery("UPDATE data_owner SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_owner");
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
						return	$this->redirect("data_owner");
					}
				}
			}
		}
		$db->where("data_owner.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Owner";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_owner/edit.php", $data);
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
		$file_fields = array('logo'); 
		foreach( $arr_id as $rec_id ){
			$db->where("data_owner.id", $arr_rec_id, "in");;
		}
		//get files link to be deleted before deleting records
		$files = $db->get($tablename, null , $file_fields); 
		$db->where("data_owner.id", $arr_rec_id, "in");
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
		return	$this->redirect("data_owner");
	}
}
