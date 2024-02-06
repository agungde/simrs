<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_ranjang/add");
$can_edit = ACL::is_allowed("data_ranjang/edit");
$can_view = ACL::is_allowed("data_ranjang/view");
$can_delete = ACL::is_allowed("data_ranjang/delete");
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
    <td class="td-id"><a href="<?php print_link("data_ranjang/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
    <td class="td-id_data_kamar"> <?php echo $data['id_data_kamar']; ?></td>
    <td class="td-jumlah_ranjang"> <?php echo $data['jumlah_ranjang']; ?></td>
    <td class="td-no_1"> <?php echo $data['no_1']; ?></td>
    <td class="td-no_2"> <?php echo $data['no_2']; ?></td>
    <td class="td-no_3"> <?php echo $data['no_3']; ?></td>
    <td class="td-no_4"> <?php echo $data['no_4']; ?></td>
    <td class="td-no_5"> <?php echo $data['no_5']; ?></td>
    <td class="td-no_6"> <?php echo $data['no_6']; ?></td>
    <td class="td-no_7"> <?php echo $data['no_7']; ?></td>
    <td class="td-no_8"> <?php echo $data['no_8']; ?></td>
    <td class="td-no_9"> <?php echo $data['no_9']; ?></td>
    <td class="td-no_10"> <?php echo $data['no_10']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_ranjang/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_ranjang/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
                <?php if($can_delete){ ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_ranjang/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                    <i class="fa fa-times"></i> Delete 
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
