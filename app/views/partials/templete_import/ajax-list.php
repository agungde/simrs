<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("templete_import/add");
$can_edit = ACL::is_allowed("templete_import/edit");
$can_view = ACL::is_allowed("templete_import/view");
$can_delete = ACL::is_allowed("templete_import/delete");
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
    <td class="td-nama"> <?php echo $data['nama']; ?></td>
    <td class="td-file"><?php Html :: page_link_file($data['file']); ?></td>
    <td class="td-action"> <span>
        <?php
        if($user_role_id=="1" or $user_role_id=="4"){?>
        <a class="btn btn-sm btn-info has-tooltip"  href="<?php print_link("templete_import/edit/$rec_id"); ?>">
        <i class="fa fa-edit"></i> Edit </a>
        <a class="btn btn-sm btn-danger has-tooltip record-delete-btn"  href="<?php print_link("templete_import/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
        <i class="fa fa-times"></i> Delete  </a>
        <?php }?>                     
    </span>
</td>
<td class="td-operator">
    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
        <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
    </a>
</td>
<td class="td-date_created"> <?php echo $data['date_created']; ?></td>
<td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
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
