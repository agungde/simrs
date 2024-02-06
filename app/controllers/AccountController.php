<?php 
/**
 * Account Page Controller
 * @category  Controller
 */
class AccountController extends SecureController{
	function __construct(){
		parent::__construct(); 
		$this->tablename = "user_login";
	}
	/**
		* Index Action
		* @return null
		*/
	function index(){
		$db = $this->GetModel();
		$rec_id = $this->rec_id = USER_ID; //get current user id from session
		$db->where ("id_userlogin", $rec_id);
		$tablename = $this->tablename;
		$fields = array("user_login.id_userlogin", 
			"user_login.nama", 
			"user_login.email", 
			"user_login.username", 
			"user_login.user_role_id", 
			"roles.role_name AS roles_role_name", 
			"user_login.operator", 
			"user_login.date_created");
		$db->join("roles", "user_login.user_role_id = roles.role_id", "INNER");
		$user = $db->getOne($tablename , $fields);
		if(!empty($user)){
			$page_title = $this->view->page_title = "My Account";
			$this->render_view("account/view.php", $user);
		}
		else{
			$this->set_page_error();
			$this->render_view("account/view.php");
		}
	}
	/**
     * Update user account record with formdata
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = USER_ID;
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
			 if(USER_ROLE==2){
     mysqli_query($koneksi,"UPDATE data_pasien SET nama_pasien='".$_POST['nama']."', email='".$_POST['email']."', photo='".$_POST['photo']."' WHERE id_user='$rec_id'");
  mysqli_query($koneksi,"UPDATE biodata SET nama='".$_POST['nama']."', email='".$_POST['email']."', photo='".$_POST['photo']."' WHERE id_user='$rec_id'");
}
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					$db->where ("id_userlogin", $rec_id);
					$user = $db->getOne($tablename , "*");
					set_session("user_data", $user);// update session with new user data
					return $this->redirect("account");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$this->set_flash_msg("No record updated", "warning");
						return	$this->redirect("account");
					}
				}
			}
		}
		$db->where("user_login.id_userlogin", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "My Account";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("account/edit.php", $data);
	}
	/**
     * Change account email
     * @return BaseView
     */
	function change_email($formdata = null){
		if($formdata){
			$email = trim($formdata['email']);
			$db = $this->GetModel();
			$rec_id = $this->rec_id = USER_ID; //get current user id from session
			$tablename = $this->tablename;
			$db->where ("id_userlogin", $rec_id);
			$result = $db->update($tablename, array('email' => $email ,'email_status'=>'not verified'));
			if($result){
				//logout user and send new email verification link
				session_destroy();
				$this->redirect("index/send_verify_email_link/$email");
			}
			else{
				$this->set_page_error("Email not changed");
			}
		}
		return $this->render_view("account/change_email.php");
	}
}
