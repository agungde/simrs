<?php 
/**
 * Ruang_perina Page Controller
 * @category  Controller
 */
class Ruang_perinaController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ruang_perina";
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
			"tanggal_masuk", 
			"nama_pasien", 
			"no_rekam_medis", 
			"tgl_lahir", 
			"umur", 
			"action", 
			"pemeriksaan_fisik", 
			"catatan_medis", 
			"tindakan", 
			"rekam_medis", 
			"obat", 
			"lab", 
			"status", 
			"tanggal_keluar", 
			"assesment_medis", 
			"assesment_triase");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				ruang_perina.id LIKE ? OR 
				ruang_perina.tanggal_masuk LIKE ? OR 
				ruang_perina.nama_pasien LIKE ? OR 
				ruang_perina.no_rekam_medis LIKE ? OR 
				ruang_perina.tgl_lahir LIKE ? OR 
				ruang_perina.umur LIKE ? OR 
				ruang_perina.action LIKE ? OR 
				ruang_perina.pemeriksaan_fisik LIKE ? OR 
				ruang_perina.catatan_medis LIKE ? OR 
				ruang_perina.tindakan LIKE ? OR 
				ruang_perina.rekam_medis LIKE ? OR 
				ruang_perina.obat LIKE ? OR 
				ruang_perina.lab LIKE ? OR 
				ruang_perina.status LIKE ? OR 
				ruang_perina.tanggal_keluar LIKE ? OR 
				ruang_perina.assesment_medis LIKE ? OR 
				ruang_perina.assesment_triase LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "ruang_perina/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("ruang_perina.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Ruang Perina";
		$this->render_view("ruang_perina/list.php", $data); //render the full page
	}
}
