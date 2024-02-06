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
    <td class="td-id_data_penjualan"><a href="<?php print_link("data_penjualan/view/$data[id_data_penjualan]") ?>"><?php echo $data['id_data_penjualan']; ?></a></td>
    <td class="td-id_pelanggan"> <?php echo $data['id_pelanggan']; ?></td>
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-nama_pelanggan"> <?php echo $data['nama_pelanggan']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
    <td class="td-harga"> <?php echo $data['harga']; ?></td>
    <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
    <td class="td-total_bayar"> <?php echo $data['total_bayar']; ?></td>
    <td class="td-ppn"> <?php echo $data['ppn']; ?></td>
    <td class="td-nama_poli"> <?php echo $data['nama_poli']; ?></td>
    <td class="td-operator"> <?php echo $data['operator']; ?></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="td-id_penjualan"> <?php echo $data['id_penjualan']; ?></td>
    <td class="td-diskon"> <?php echo $data['diskon']; ?></td>
    <td class="td-no_invoice"> <?php echo $data['no_invoice']; ?></td>
    <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
    <td class="td-bagian"> <?php echo $data['bagian']; ?></td>
    <td class="td-lap"> <?php echo $data['lap']; ?></td>
    <td class="td-id_data_setok"> <?php echo $data['id_data_setok']; ?></td>
    <td class="td-trx"> <?php echo $data['trx']; ?></td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_penjualan/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_penjualan/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
                <?php if($can_delete){ ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_penjualan/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
