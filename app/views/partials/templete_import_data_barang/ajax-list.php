<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("templete_import_data_barang/add");
$can_edit = ACL::is_allowed("templete_import_data_barang/edit");
$can_view = ACL::is_allowed("templete_import_data_barang/view");
$can_delete = ACL::is_allowed("templete_import_data_barang/delete");
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
$rec_id = (!empty($data['']) ? urlencode($data['']) : null);
$counter++;
?>
<tr>
    <td class="td-file"><?php Html :: page_link_file($data['file']); ?></td>
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
