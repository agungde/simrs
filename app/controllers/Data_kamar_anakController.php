<?php 
/**
 * Data_kamar_anak Page Controller
 * @category  Controller
 */
class Data_kamar_anakController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_kamar_anak";
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
		$fields = array("data_kamar_anak.id_data_kamar_anak", 
			"data_kamar_anak.kamar_kelas", 
			"data_kelas.nama_kelas AS data_kelas_nama_kelas", 
			"data_kamar_anak.nama_kamar", 
			"nama_kamar_ranap_anak.nama_kamar AS nama_kamar_ranap_anak_nama_kamar", 
			"data_kamar_anak.no_kamar", 
			"data_kamar_anak.jumlah_ranjang", 
			"data_kamar_anak.harga", 
			"data_kamar_anak.terisi", 
			"data_kamar_anak.sisa", 
			"data_kamar_anak.operator", 
			"data_kamar_anak.date_created", 
			"data_kamar_anak.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_kamar_anak.id_data_kamar_anak LIKE ? OR 
				data_kamar_anak.kamar_kelas LIKE ? OR 
				data_kamar_anak.nama_kamar LIKE ? OR 
				data_kamar_anak.no_kamar LIKE ? OR 
				data_kamar_anak.jumlah_ranjang LIKE ? OR 
				data_kamar_anak.harga LIKE ? OR 
				data_kamar_anak.terisi LIKE ? OR 
				data_kamar_anak.sisa LIKE ? OR 
				data_kamar_anak.operator LIKE ? OR 
				data_kamar_anak.date_created LIKE ? OR 
				data_kamar_anak.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_kamar_anak/search.php";
		}
		$db->join("data_kelas", "data_kamar_anak.kamar_kelas = data_kelas.id_kelas", "INNER");
		$db->join("nama_kamar_ranap_anak", "data_kamar_anak.nama_kamar = nama_kamar_ranap_anak.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_kamar_anak.id_data_kamar_anak", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Kamar Anak";
		$this->render_view("data_kamar_anak/list.php", $data); //render the full page
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
 mysqli_query($koneksi,"INSERT INTO `data_ranjang_anak` (`jumlah_ranjang`,`id_data_kamar`) VALUES ('$jumlah_ranjang','$rec_id')"); 
 $db->rawQuery("UPDATE data_kamar_anak SET harga='".$data['harga_ranap_anak']."', operator='".USER_ID."' WHERE id_data_kamar_anak='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_kamar_anak");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Kamar Anak";
		$this->render_view("data_kamar_anak/add.php");
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
		$fields = $this->fields = array("id_data_kamar_anak","kamar_kelas","nama_kamar","no_kamar","jumlah_ranjang");
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
				$db->where("no_kamar", $modeldata['no_kamar'])->where("id_data_kamar_anak", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['no_kamar']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("data_kamar_anak.id_data_kamar_anak", $rec_id);;
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
 $db->rawQuery("UPDATE data_kamar_anak SET harga='".$data['harga_ranap_anak']."', operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_data_kamar_anak='$rec_id'");
 mysqli_query($koneksi,"UPDATE data_ranjang_anak SET jumlah_ranjang='$jumlah_ranjang' where id_data_kamar'$rec_id')");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_kamar_anak");
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
						return	$this->redirect("data_kamar_anak");
					}
				}
			}
		}
		$db->where("data_kamar_anak.id_data_kamar_anak", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Kamar Anak";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_kamar_anak/edit.php", $data);
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
			$fields = $this->fields = array("kamar_kelas","nama_kamar","no_kamar","jumlah_ranjang","harga","terisi","sisa","operator","date_created","date_updated");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kamar_kelas' => 'required|numeric',
				'nama_kamar' => 'required',
				'no_kamar' => 'required',
				'jumlah_ranjang' => 'required|numeric',
				'harga' => 'required|numeric',
				'terisi' => 'required|numeric',
				'sisa' => 'required|numeric',
				'operator' => 'required|numeric',
				'date_created' => 'required',
				'date_updated' => 'required',
			);
			$this->sanitize_array = array(
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'jumlah_ranjang' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'terisi' => 'sanitize_string',
				'sisa' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_created' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_kamar_anak");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Kamar Anak";
		$this->render_view("data_kamar_anak/detile.php");
	}
}
