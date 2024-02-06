<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_pembelian/add");
$can_edit = ACL::is_allowed("data_pembelian/edit");
$can_view = ACL::is_allowed("data_pembelian/view");
$can_delete = ACL::is_allowed("data_pembelian/delete");
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
$rec_id = (!empty($data['id_data_pembelian']) ? urlencode($data['id_data_pembelian']) : null);
$counter++;
?>
<tr>
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
    <td class="td-harga_beli"> <?php echo $data['harga_beli']; ?></td>
    <td class="td-ppn"> <?php echo $data['ppn']; ?></td>
    <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
    <td class="td-tanggal_expired"> <?php echo $data['tanggal_expired']; ?></td>
    <td class="td-diskon"> <?php echo $data['diskon']; ?></td>
    <td class="td-total_diskon"> <?php echo $data['total_diskon']; ?></td>
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
