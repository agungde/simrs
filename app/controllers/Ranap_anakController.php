<?php 
/**
 * Ranap_anak Page Controller
 * @category  Controller
 */
class Ranap_anakController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ranap_anak";
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
			"id_transaksi", 
			"id_igd", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"no_ktp", 
			"tl", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"jenis_kelamin", 
			"umur", 
			"no_hp", 
			"email", 
			"nama_orang_tua", 
			"pembayaran", 
			"setatus_bpjs", 
			"penanggung_jawab", 
			"id_penanggung_jawab", 
			"alamat_penanggung_jawab", 
			"no_hp_penanggung_jawab", 
			"hubungan", 
			"ranap_anak", 
			"action", 
			"setatus", 
			"dokter_pengirim", 
			"tindakan", 
			"resep_obat", 
			"pasien", 
			"kamar_kelas", 
			"nama_kamar", 
			"no_kamar", 
			"no_ranjang", 
			"dokter_ranap_anak", 
			"poli", 
			"lab", 
			"catatan_medis", 
			"assesment_medis", 
			"pemeriksaan_fisik", 
			"rekam_medis", 
			"tanggal_keluar", 
			"back_link", 
			"operator", 
			"date_created", 
			"date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				ranap_anak.id LIKE ? OR 
				ranap_anak.id_transaksi LIKE ? OR 
				ranap_anak.id_igd LIKE ? OR 
				ranap_anak.tanggal_masuk LIKE ? OR 
				ranap_anak.no_rekam_medis LIKE ? OR 
				ranap_anak.no_ktp LIKE ? OR 
				ranap_anak.tl LIKE ? OR 
				ranap_anak.nama_pasien LIKE ? OR 
				ranap_anak.alamat LIKE ? OR 
				ranap_anak.tanggal_lahir LIKE ? OR 
				ranap_anak.jenis_kelamin LIKE ? OR 
				ranap_anak.umur LIKE ? OR 
				ranap_anak.no_hp LIKE ? OR 
				ranap_anak.email LIKE ? OR 
				ranap_anak.nama_orang_tua LIKE ? OR 
				ranap_anak.pembayaran LIKE ? OR 
				ranap_anak.setatus_bpjs LIKE ? OR 
				ranap_anak.penanggung_jawab LIKE ? OR 
				ranap_anak.id_penanggung_jawab LIKE ? OR 
				ranap_anak.alamat_penanggung_jawab LIKE ? OR 
				ranap_anak.no_hp_penanggung_jawab LIKE ? OR 
				ranap_anak.hubungan LIKE ? OR 
				ranap_anak.ranap_anak LIKE ? OR 
				ranap_anak.action LIKE ? OR 
				ranap_anak.setatus LIKE ? OR 
				ranap_anak.dokter_pengirim LIKE ? OR 
				ranap_anak.tindakan LIKE ? OR 
				ranap_anak.resep_obat LIKE ? OR 
				ranap_anak.pasien LIKE ? OR 
				ranap_anak.kamar_kelas LIKE ? OR 
				ranap_anak.nama_kamar LIKE ? OR 
				ranap_anak.no_kamar LIKE ? OR 
				ranap_anak.no_ranjang LIKE ? OR 
				ranap_anak.dokter_ranap_anak LIKE ? OR 
				ranap_anak.poli LIKE ? OR 
				ranap_anak.lab LIKE ? OR 
				ranap_anak.catatan_medis LIKE ? OR 
				ranap_anak.assesment_medis LIKE ? OR 
				ranap_anak.pemeriksaan_fisik LIKE ? OR 
				ranap_anak.rekam_medis LIKE ? OR 
				ranap_anak.tanggal_keluar LIKE ? OR 
				ranap_anak.back_link LIKE ? OR 
				ranap_anak.operator LIKE ? OR 
				ranap_anak.date_created LIKE ? OR 
				ranap_anak.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "ranap_anak/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("ranap_anak.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Ranap Anak";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("ranap_anak/list.php", $data); //render the full page
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
			"id_transaksi", 
			"id_igd", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"no_ktp", 
			"tl", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"jenis_kelamin", 
			"umur", 
			"no_hp", 
			"email", 
			"nama_orang_tua", 
			"pembayaran", 
			"setatus_bpjs", 
			"penanggung_jawab", 
			"id_penanggung_jawab", 
			"alamat_penanggung_jawab", 
			"no_hp_penanggung_jawab", 
			"hubungan", 
			"ranap_anak", 
			"action", 
			"setatus", 
			"dokter_pengirim", 
			"tindakan", 
			"resep_obat", 
			"pasien", 
			"kamar_kelas", 
			"nama_kamar", 
			"no_kamar", 
			"no_ranjang", 
			"dokter_ranap_anak", 
			"poli", 
			"lab", 
			"catatan_medis", 
			"assesment_medis", 
			"pemeriksaan_fisik", 
			"rekam_medis", 
			"tanggal_keluar", 
			"back_link", 
			"operator", 
			"date_created", 
			"date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("ranap_anak.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Ranap Anak";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("ranap_anak/view.php", $record);
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
			$fields = $this->fields = array("id_transaksi","id_igd","tanggal_masuk","no_rekam_medis","no_ktp","tl","nama_pasien","alamat","tanggal_lahir","jenis_kelamin","umur","no_hp","email","nama_orang_tua","pembayaran","setatus_bpjs","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","ranap_anak","action","setatus","dokter_pengirim","tindakan","resep_obat","pasien","kamar_kelas","nama_kamar","no_kamar","no_ranjang","dokter_ranap_anak","poli","lab","catatan_medis","assesment_medis","pemeriksaan_fisik","rekam_medis","tanggal_keluar","back_link","operator","date_updated");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_transaksi' => 'required|numeric',
				'id_igd' => 'required|numeric',
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'no_ktp' => 'required|numeric',
				'tl' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'umur' => 'required',
				'no_hp' => 'required',
				'email' => 'required|valid_email',
				'nama_orang_tua' => 'required',
				'pembayaran' => 'required|numeric',
				'setatus_bpjs' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'ranap_anak' => 'required',
				'action' => 'required',
				'setatus' => 'required',
				'dokter_pengirim' => 'required|numeric',
				'tindakan' => 'required',
				'resep_obat' => 'required',
				'pasien' => 'required',
				'kamar_kelas' => 'required|numeric',
				'nama_kamar' => 'required',
				'no_kamar' => 'required',
				'no_ranjang' => 'required',
				'dokter_ranap_anak' => 'required|numeric',
				'poli' => 'required|numeric',
				'lab' => 'required',
				'catatan_medis' => 'required',
				'assesment_medis' => 'required',
				'pemeriksaan_fisik' => 'required',
				'rekam_medis' => 'required',
				'tanggal_keluar' => 'required',
				'back_link' => 'required',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
			);
			$this->sanitize_array = array(
				'id_transaksi' => 'sanitize_string',
				'id_igd' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'nama_orang_tua' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'ranap_anak' => 'sanitize_string',
				'action' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'no_ranjang' => 'sanitize_string',
				'dokter_ranap_anak' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("ranap_anak");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Ranap Anak";
		$this->render_view("ranap_anak/add.php");
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
		$fields = $this->fields = array("id","id_transaksi","id_igd","tanggal_masuk","no_rekam_medis","no_ktp","tl","nama_pasien","alamat","tanggal_lahir","jenis_kelamin","umur","no_hp","email","nama_orang_tua","pembayaran","setatus_bpjs","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","ranap_anak","action","setatus","dokter_pengirim","tindakan","resep_obat","pasien","kamar_kelas","nama_kamar","no_kamar","no_ranjang","dokter_ranap_anak","poli","lab","catatan_medis","assesment_medis","pemeriksaan_fisik","rekam_medis","tanggal_keluar","back_link","operator","date_updated");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_transaksi' => 'required|numeric',
				'id_igd' => 'required|numeric',
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'no_ktp' => 'required|numeric',
				'tl' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'umur' => 'required',
				'no_hp' => 'required',
				'email' => 'required|valid_email',
				'nama_orang_tua' => 'required',
				'pembayaran' => 'required|numeric',
				'setatus_bpjs' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'ranap_anak' => 'required',
				'action' => 'required',
				'setatus' => 'required',
				'dokter_pengirim' => 'required|numeric',
				'tindakan' => 'required',
				'resep_obat' => 'required',
				'pasien' => 'required',
				'kamar_kelas' => 'required|numeric',
				'nama_kamar' => 'required',
				'no_kamar' => 'required',
				'no_ranjang' => 'required',
				'dokter_ranap_anak' => 'required|numeric',
				'poli' => 'required|numeric',
				'lab' => 'required',
				'catatan_medis' => 'required',
				'assesment_medis' => 'required',
				'pemeriksaan_fisik' => 'required',
				'rekam_medis' => 'required',
				'tanggal_keluar' => 'required',
				'back_link' => 'required',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
			);
			$this->sanitize_array = array(
				'id_transaksi' => 'sanitize_string',
				'id_igd' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'nama_orang_tua' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'ranap_anak' => 'sanitize_string',
				'action' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'no_ranjang' => 'sanitize_string',
				'dokter_ranap_anak' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("ranap_anak.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("ranap_anak");
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
						return	$this->redirect("ranap_anak");
					}
				}
			}
		}
		$db->where("ranap_anak.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Ranap Anak";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("ranap_anak/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","id_transaksi","id_igd","tanggal_masuk","no_rekam_medis","no_ktp","tl","nama_pasien","alamat","tanggal_lahir","jenis_kelamin","umur","no_hp","email","nama_orang_tua","pembayaran","setatus_bpjs","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","ranap_anak","action","setatus","dokter_pengirim","tindakan","resep_obat","pasien","kamar_kelas","nama_kamar","no_kamar","no_ranjang","dokter_ranap_anak","poli","lab","catatan_medis","assesment_medis","pemeriksaan_fisik","rekam_medis","tanggal_keluar","back_link","operator","date_updated");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'id_transaksi' => 'required|numeric',
				'id_igd' => 'required|numeric',
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'no_ktp' => 'required|numeric',
				'tl' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'umur' => 'required',
				'no_hp' => 'required',
				'email' => 'required|valid_email',
				'nama_orang_tua' => 'required',
				'pembayaran' => 'required|numeric',
				'setatus_bpjs' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'ranap_anak' => 'required',
				'action' => 'required',
				'setatus' => 'required',
				'dokter_pengirim' => 'required|numeric',
				'tindakan' => 'required',
				'resep_obat' => 'required',
				'pasien' => 'required',
				'kamar_kelas' => 'required|numeric',
				'nama_kamar' => 'required',
				'no_kamar' => 'required',
				'no_ranjang' => 'required',
				'dokter_ranap_anak' => 'required|numeric',
				'poli' => 'required|numeric',
				'lab' => 'required',
				'catatan_medis' => 'required',
				'assesment_medis' => 'required',
				'pemeriksaan_fisik' => 'required',
				'rekam_medis' => 'required',
				'tanggal_keluar' => 'required',
				'back_link' => 'required',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
			);
			$this->sanitize_array = array(
				'id_transaksi' => 'sanitize_string',
				'id_igd' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'nama_orang_tua' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'ranap_anak' => 'sanitize_string',
				'action' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'no_ranjang' => 'sanitize_string',
				'dokter_ranap_anak' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("ranap_anak.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
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
		$db->where("ranap_anak.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("ranap_anak");
	}
}
