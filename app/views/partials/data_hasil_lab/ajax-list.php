<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_hasil_lab/add");
$can_edit = ACL::is_allowed("data_hasil_lab/edit");
$can_view = ACL::is_allowed("data_hasil_lab/view");
$can_delete = ACL::is_allowed("data_hasil_lab/delete");
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
    <td class="td-nama_pemeriksaan"> <?php echo $data['nama_pemeriksaan']; ?></td>
    <td class="td-nilai_rujukan"> <?php echo $data['nilai_rujukan']; ?></td>
    <td class="td-hasil_pemeriksaan"> <?php echo $data['hasil_pemeriksaan']; ?></td>
    <td class="td-diagnosa"> <?php echo $data['diagnosa']; ?></td>
    <td class="td-jenis_pemeriksaan"> <?php echo $data['jenis_pemeriksaan']; ?></td>
    <td class="td-harga"> <?php echo $data['harga']; ?></td>
    <td class="td-id"> <?php echo $data['id']; ?></td>
    <td class="td-id_transaksi"> <?php echo $data['id_transaksi']; ?></td>
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
