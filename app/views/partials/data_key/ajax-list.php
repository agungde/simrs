<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_key/add");
$can_edit = ACL::is_allowed("data_key/edit");
$can_view = ACL::is_allowed("data_key/view");
$can_delete = ACL::is_allowed("data_key/delete");
?>
<?php
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
if (!empty($records)) {
?>
<!--record-->
<?php
$counter = 0;
foreach($records as $data){
$rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
$counter++;
?>
<tr>
    <td class="td-nama"> <span><?php 
        $qudtpab = mysqli_query($koneksi, "SELECT * from user_login WHERE id_userlogin='".$data['nama']."'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        $rodtpab = mysqli_num_rows($qudtpab);
        if ($rodtpab <> 0) {
        $cdt= mysqli_fetch_assoc($qudtpab);
        //$spesial=$cdt['specialist'];
        echo $cdt['nama'];
        }else{
        echo $data['nama']; 
    }?></span></td>
    <td class="td-jabatan"> <?php echo $data['jabatan']; ?></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_key/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
            </ul>
        </div>
    </td>
</tr>
<?php 
}
?>
<?php
} else {
?>
<td class="no-record-found col-12" colspan="100">
    <h4 class="text-muted text-center ">
        No Record Found
    </h4>
</td>
<?php
}
?>
