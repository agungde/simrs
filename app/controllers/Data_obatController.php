<?php 
/**
 * Data_obat Page Controller
 * @category  Controller
 */
class Data_obatController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_obat";
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
			"kode_obat", 
			"penggunaan", 
			"nama_obat", 
			"pbf", 
			"hna", 
			"hja", 
			"tipe", 
			"satuan", 
			"operator", 
			"tanggal_dibuat", 
			"tanggal_diperbarui");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_obat.id LIKE ? OR 
				data_obat.kode_obat LIKE ? OR 
				data_obat.penggunaan LIKE ? OR 
				data_obat.nama_obat LIKE ? OR 
				data_obat.pbf LIKE ? OR 
				data_obat.hna LIKE ? OR 
				data_obat.hja LIKE ? OR 
				data_obat.tipe LIKE ? OR 
				data_obat.satuan LIKE ? OR 
				data_obat.operator LIKE ? OR 
				data_obat.tanggal_dibuat LIKE ? OR 
				data_obat.tanggal_diperbarui LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_obat/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_obat.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Obat";
		$this->render_view("data_obat/list.php", $data); //render the full page
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
			"kode_obat", 
			"penggunaan", 
			"nama_obat", 
			"pbf", 
			"hna", 
			"hja", 
			"tipe", 
			"satuan", 
			"operator", 
			"tanggal_dibuat", 
			"tanggal_diperbarui");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_obat.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Obat";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_obat/view.php", $record);
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
			$fields = $this->fields = array("kode_obat","penggunaan","nama_obat","pbf","hna","hja","tipe","satuan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_obat' => 'required',
				'penggunaan' => 'required',
				'nama_obat' => 'required',
				'pbf' => 'required',
				'hna' => 'required|numeric',
				'hja' => 'required|numeric',
				'tipe' => 'required',
				'satuan' => 'required',
			);
			$this->sanitize_array = array(
				'kode_obat' => 'sanitize_string',
				'penggunaan' => 'sanitize_string',
				'nama_obat' => 'sanitize_string',
				'pbf' => 'sanitize_string',
				'hna' => 'sanitize_string',
				'hja' => 'sanitize_string',
				'tipe' => 'sanitize_string',
				'satuan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("kode_obat", $modeldata['kode_obat']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['kode_obat']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("nama_obat", $modeldata['nama_obat']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['nama_obat']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$id_user = "".USER_ID;
if($_POST['kode_obat']=="Auto"){
$db->rawQuery("UPDATE data_obat SET kode_obat='DTOB$rec_id', operator='$id_user' WHERE id='$rec_id'");
}else{
$db->rawQuery("UPDATE data_obat SET operator='$id_user' WHERE id='$rec_id'");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_obat");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Obat";
		$this->render_view("data_obat/add.php");
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
		$fields = $this->fields = array("id","kode_obat","penggunaan","nama_obat","pbf","hna","hja","tipe","satuan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_obat' => 'required',
				'penggunaan' => 'required',
				'nama_obat' => 'required',
				'pbf' => 'required',
				'hna' => 'required|numeric',
				'hja' => 'required|numeric',
				'tipe' => 'required',
				'satuan' => 'required',
			);
			$this->sanitize_array = array(
				'kode_obat' => 'sanitize_string',
				'penggunaan' => 'sanitize_string',
				'nama_obat' => 'sanitize_string',
				'pbf' => 'sanitize_string',
				'hna' => 'sanitize_string',
				'hja' => 'sanitize_string',
				'tipe' => 'sanitize_string',
				'satuan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['kode_obat'])){
				$db->where("kode_obat", $modeldata['kode_obat'])->where("id", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['kode_obat']." Already exist!";
				}
			}
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['nama_obat'])){
				$db->where("nama_obat", $modeldata['nama_obat'])->where("id", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['nama_obat']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("data_obat.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$id_user = "".USER_ID;
$db->rawQuery("UPDATE data_obat SET operator='$id_user', tanggal_diperbarui='".date("Y-m-d H:i:s")."' WHERE id='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_obat");
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
						return	$this->redirect("data_obat");
					}
				}
			}
		}
		$db->where("data_obat.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Obat";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_obat/edit.php", $data);
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
		$db->where("data_obat.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_obat");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function impor($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("penggunaan","nama_obat","pbf","hna","hja","tipe","operator","tanggal_dibuat","tanggal_diperbarui","kode_obat","satuan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'penggunaan' => 'required',
				'nama_obat' => 'required',
				'pbf' => 'required',
				'hna' => 'required|numeric',
				'hja' => 'required|numeric',
				'tipe' => 'required',
				'operator' => 'required|numeric',
				'tanggal_dibuat' => 'required',
				'tanggal_diperbarui' => 'required',
				'kode_obat' => 'required',
				'satuan' => 'required',
			);
			$this->sanitize_array = array(
				'penggunaan' => 'sanitize_string',
				'nama_obat' => 'sanitize_string',
				'pbf' => 'sanitize_string',
				'hna' => 'sanitize_string',
				'hja' => 'sanitize_string',
				'tipe' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'tanggal_dibuat' => 'sanitize_string',
				'tanggal_diperbarui' => 'sanitize_string',
				'kode_obat' => 'sanitize_string',
				'satuan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_obat");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Obat";
		$this->render_view("data_obat/impor.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function proses($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("kode_obat","penggunaan","nama_obat","pbf","hna","hja","tipe","operator","tanggal_dibuat","tanggal_diperbarui","satuan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_obat' => 'required',
				'penggunaan' => 'required',
				'nama_obat' => 'required',
				'pbf' => 'required',
				'hna' => 'required|numeric',
				'hja' => 'required|numeric',
				'tipe' => 'required',
				'operator' => 'required|numeric',
				'tanggal_dibuat' => 'required',
				'tanggal_diperbarui' => 'required',
				'satuan' => 'required',
			);
			$this->sanitize_array = array(
				'kode_obat' => 'sanitize_string',
				'penggunaan' => 'sanitize_string',
				'nama_obat' => 'sanitize_string',
				'pbf' => 'sanitize_string',
				'hna' => 'sanitize_string',
				'hja' => 'sanitize_string',
				'tipe' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'tanggal_dibuat' => 'sanitize_string',
				'tanggal_diperbarui' => 'sanitize_string',
				'satuan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_obat");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Obat";
		$this->render_view("data_obat/proses.php");
	}
}
