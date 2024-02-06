<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("transaksi_penjualan/add");
$can_edit = ACL::is_allowed("transaksi_penjualan/edit");
$can_view = ACL::is_allowed("transaksi_penjualan/view");
$can_delete = ACL::is_allowed("transaksi_penjualan/delete");
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
$rec_id = (!empty($data['id_transaksi_penjualan']) ? urlencode($data['id_transaksi_penjualan']) : null);
$counter++;
?>
<tr>
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
    <td class="td-harga"> <?php echo $data['harga']; ?></td>
    <td class="td-diskon"> <?php echo $data['diskon']; ?></td>
    <td class="td-ppn"> <?php echo $data['ppn']; ?></td>
    <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
    <td class="td-no_invoice"> <?php echo $data['no_invoice']; ?></td>
    <td class="td-id_data_setok"> <?php echo $data['id_data_setok']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("transaksi_penjualan/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
                <?php if($can_delete){ ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("transaksi_penjualan/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
