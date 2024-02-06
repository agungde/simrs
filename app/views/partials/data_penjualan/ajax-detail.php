<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_penjualan/add");
$can_edit = ACL::is_allowed("data_penjualan/edit");
$can_view = ACL::is_allowed("data_penjualan/view");
$can_delete = ACL::is_allowed("data_penjualan/delete");
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
$rec_id = (!empty($data['id_data_penjualan']) ? urlencode($data['id_data_penjualan']) : null);
$counter++;
?>
<tr>
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
    <td class="td-harga"> <?php echo $data['harga']; ?></td>
    <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
    <td class="td-total_bayar"> <?php echo $data['total_bayar']; ?></td>
    <td class="td-id_penjualan"> <?php echo $data['id_penjualan']; ?></td>
    <td class="td-no_invoice"> <?php echo $data['no_invoice']; ?></td>
    <td class="td-id_transaksi"> <?php echo $data['id_transaksi']; ?></td>
    <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
    <td class="td-bagian"> <?php echo $data['bagian']; ?></td>
    <td class="td-lap"> <?php echo $data['lap']; ?></td>
    <td class="td-id_data_setok"> <?php echo $data['id_data_setok']; ?></td>
    <td class="td-trx"> <?php echo $data['trx']; ?></td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
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
