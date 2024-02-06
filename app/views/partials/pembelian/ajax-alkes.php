<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pembelian/add");
$can_edit = ACL::is_allowed("pembelian/edit");
$can_view = ACL::is_allowed("pembelian/view");
$can_delete = ACL::is_allowed("pembelian/delete");
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
$rec_id = (!empty($data['id_pembelian']) ? urlencode($data['id_pembelian']) : null);
$counter++;
?>
<tr>
    <td class="td-tanggal_pembelian"> <?php echo $data['tanggal_pembelian']; ?></td>
    <td class="td-no_invoice"> <span>
        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("data_pembelian?csrf_token=$csrf_token&noinvoice=".$data['no_invoice']); ?>">
            <i class="fa fa-eye"></i>
        <?php echo $data['no_invoice']; ?></a></span></td>
        <td class="td-nama_suplier"> <?php echo $data['nama_suplier']; ?></td>
        <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
        <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
        <td class="td-total_jumlah"> <?php echo $data['total_jumlah']; ?></td>
        <td class="td-total_harga_beli"> <?php echo $data['total_harga_beli']; ?></td>
        <td class="td-total_diskon"> <?php echo $data['total_diskon']; ?></td>
        <td class="td-ppn"> <?php echo $data['ppn']; ?></td>
        <td class="td-category_barang">
            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
                <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
            </a>
        </td>
        <td class="td-operator"> <?php echo $data['operator']; ?></td>
        <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
        <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
        <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
        <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
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
    