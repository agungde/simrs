<?php 
/**
 * Data_kamar Page Controller
 * @category  Controller
 */
class Data_kamarController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_kamar";
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
		$fields = array("data_kamar.id_data_kamar", 
			"data_kamar.kamar_kelas", 
			"data_kelas.nama_kelas AS data_kelas_nama_kelas", 
			"data_kamar.nama_kamar", 
			"nama_kamar_ranap.nama_kamar AS nama_kamar_ranap_nama_kamar", 
			"data_kamar.no_kamar", 
			"data_kamar.harga", 
			"data_kamar.jumlah_ranjang", 
			"data_kamar.terisi", 
			"data_kamar.sisa", 
			"data_kamar.operator", 
			"user_login.nama AS user_login_nama", 
			"data_kamar.date_created", 
			"data_kamar.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_kamar.id_data_kamar LIKE ? OR 
				data_kamar.kamar_kelas LIKE ? OR 
				data_kamar.nama_kamar LIKE ? OR 
				data_kamar.no_kamar LIKE ? OR 
				data_kamar.harga LIKE ? OR 
				data_kamar.jumlah_ranjang LIKE ? OR 
				data_kamar.terisi LIKE ? OR 
				data_kamar.sisa LIKE ? OR 
				data_kamar.operator LIKE ? OR 
				data_kamar.date_created LIKE ? OR 
				data_kamar.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_kamar/search.php";
		}
		$db->join("data_kelas", "data_kamar.kamar_kelas = data_kelas.id_kelas", "INNER");
		$db->join("nama_kamar_ranap", "data_kamar.nama_kamar = nama_kamar_ranap.id", "INNER");
		$db->join("user_login", "data_kamar.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_kamar.id_data_kamar", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Kamar";
		$view_name = (is_ajax() ? "data_kamar/ajax-list.php" : "data_kamar/list.php");
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
		$fields = array("data_kamar.id_data_kamar", 
			"data_kamar.kamar_kelas", 
			"data_kelas.nama_kelas AS data_kelas_nama_kelas", 
			"data_kamar.nama_kamar", 
			"nama_kamar_ranap.nama_kamar AS nama_kamar_ranap_nama_kamar", 
			"data_kamar.no_kamar", 
			"data_kamar.harga", 
			"data_kamar.jumlah_ranjang", 
			"data_kamar.terisi", 
			"data_kamar.sisa", 
			"data_kamar.operator", 
			"user_login.nama AS user_login_nama");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_kamar.id_data_kamar", $rec_id);; //select record based on primary key
		}
		$db->join("data_kelas", "data_kamar.kamar_kelas = data_kelas.id_kelas", "INNER");
		$db->join("nama_kamar_ranap", "data_kamar.nama_kamar = nama_kamar_ranap.id", "INNER");
		$db->join("user_login", "data_kamar.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Kamar";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_kamar/view.php", $record);
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
			$fields = $this->fields = array("kamar_kelas","nama_kamar","no_kamar","jumlah_ranjang");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kamar_kelas' => 'required',
				'nama_kamar' => 'required',
				'no_kamar' => 'required|numeric',
				'jumlah_ranjang' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'jumlah_ranjang' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("no_kamar", $modeldata['no_kamar']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['no_kamar']." Already exist!";
			} 
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
$jumlah_ranjang = $_POST['jumlah_ranjang'];
$kamar_kelas    = $_POST['kamar_kelas'];
   $queryb = mysqli_query($koneksi, "select * from data_kelas WHERE id_kelas='$kamar_kelas'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
$data   = mysqli_fetch_assoc($queryb);
 mysqli_query($koneksi,"INSERT INTO `data_ranjang` (`jumlah_ranjang`,`id_data_kamar`) VALUES ('$jumlah_ranjang','$rec_id')"); 
 $db->rawQuery("UPDATE data_kamar SET harga='".$data['harga']."', operator='".USER_ID."' WHERE id_data_kamar='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_kamar");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Kamar";
		$this->render_view("data_kamar/add.php");
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
		$fields = $this->fields = array("id_data_kamar","kamar_kelas","nama_kamar","no_kamar","jumlah_ranjang");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kamar_kelas' => 'required',
				'nama_kamar' => 'required',
				'no_kamar' => 'required|numeric',
				'jumlah_ranjang' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'jumlah_ranjang' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['no_kamar'])){
				$db->where("no_kamar", $modeldata['no_kamar'])->where("id_data_kamar", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['no_kamar']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("data_kamar.id_data_kamar", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$jumlah_ranjang = $_POST['jumlah_ranjang'];
$kamar_kelas    = $_POST['kamar_kelas'];
   $queryb = mysqli_query($koneksi, "select * from data_kelas WHERE id_kelas='$kamar_kelas'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
$data   = mysqli_fetch_assoc($queryb);
 $db->rawQuery("UPDATE data_kamar SET harga='".$data['harga']."', operator='".USER_ID."' WHERE id_data_kamar='$rec_id'");
 mysqli_query($koneksi,"UPDATE data_ranjang SET jumlah_ranjang='$jumlah_ranjang' where id_data_kamar'$rec_id')"); 
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_kamar");
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
						return	$this->redirect("data_kamar");
					}
				}
			}
		}
		$db->where("data_kamar.id_data_kamar", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Kamar";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_kamar/edit.php", $data);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function detile($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("operator");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'operator' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'operator' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_kamar");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Kamar";
		$this->render_view("data_kamar/detile.php");
	}
}
