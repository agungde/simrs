<?php 
/**
 * Data_setok Page Controller
 * @category  Controller
 */
class Data_setokController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_setok";
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
		$fields = array("data_setok.id", 
			"data_setok.tanggal", 
			"data_setok.kode_barang", 
			"data_setok.nama_barang", 
			"data_setok.category_barang", 
			"category_barang.category AS category_barang_category", 
			"data_setok.setok_awal", 
			"data_setok.jumlah", 
			"data_setok.divisi", 
			"data_setok.bagian", 
			"data_setok.date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_setok.id LIKE ? OR 
				data_setok.tanggal LIKE ? OR 
				data_setok.kode_barang LIKE ? OR 
				data_setok.nama_barang LIKE ? OR 
				data_setok.category_barang LIKE ? OR 
				data_setok.setok_awal LIKE ? OR 
				data_setok.jumlah LIKE ? OR 
				data_setok.divisi LIKE ? OR 
				data_setok.bagian LIKE ? OR 
				data_setok.operator LIKE ? OR 
				data_setok.date_created LIKE ? OR 
				data_setok.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_setok/search.php";
		}
		$db->join("category_barang", "data_setok.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_setok.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Setok";
		$this->render_view("data_setok/list.php", $data); //render the full page
	}
}
