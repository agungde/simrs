<?php 
/**
 * Data_ranjang_perina Page Controller
 * @category  Controller
 */
class Data_ranjang_perinaController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_ranjang_perina";
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
			"id_data_kamar", 
			"jumlah_ranjang", 
			"no_1", 
			"no_2", 
			"no_3", 
			"no_4", 
			"no_5", 
			"no_6", 
			"no_7", 
			"no_8", 
			"no_9", 
			"no_10");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_ranjang_perina.id LIKE ? OR 
				data_ranjang_perina.id_data_kamar LIKE ? OR 
				data_ranjang_perina.jumlah_ranjang LIKE ? OR 
				data_ranjang_perina.no_1 LIKE ? OR 
				data_ranjang_perina.no_2 LIKE ? OR 
				data_ranjang_perina.no_3 LIKE ? OR 
				data_ranjang_perina.no_4 LIKE ? OR 
				data_ranjang_perina.no_5 LIKE ? OR 
				data_ranjang_perina.no_6 LIKE ? OR 
				data_ranjang_perina.no_7 LIKE ? OR 
				data_ranjang_perina.no_8 LIKE ? OR 
				data_ranjang_perina.no_9 LIKE ? OR 
				data_ranjang_perina.no_10 LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_ranjang_perina/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_ranjang_perina.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Ranjang Perina";
		$this->render_view("data_ranjang_perina/list.php", $data); //render the full page
	}
}
