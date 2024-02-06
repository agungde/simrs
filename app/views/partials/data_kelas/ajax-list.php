<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_kelas/add");
$can_edit = ACL::is_allowed("data_kelas/edit");
$can_view = ACL::is_allowed("data_kelas/view");
$can_delete = ACL::is_allowed("data_kelas/delete");
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
$rec_id = (!empty($data['id_kelas']) ? urlencode($data['id_kelas']) : null);
$counter++;
?>
<tr>
    <td class="td-nama_kelas"> <?php echo $data['nama_kelas']; ?></td>
    <td class="td-harga"> <span>Rp.<?php echo number_format($data['harga'],0,",",".");?></span></td>
    <td class="td-harga_ranap_anak"><span>Rp.<?php echo number_format($data['harga_ranap_anak'],0,",",".");?></span></td>
    <td class="td-harga_ranap_bersalin"> <span>Rp.<?php echo number_format($data['harga_ranap_bersalin'],0,",",".");?></span></td>
    <td class="td-harga_ranap_perina"> <span>Rp.<?php echo number_format($data['harga_ranap_perina'],0,",",".");?></span></td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_kelas/edit/$rec_id"); ?>">
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
