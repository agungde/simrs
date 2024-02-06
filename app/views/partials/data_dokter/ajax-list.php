<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_dokter/add");
$can_edit = ACL::is_allowed("data_dokter/edit");
$can_view = ACL::is_allowed("data_dokter/view");
$can_delete = ACL::is_allowed("data_dokter/delete");
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
$rec_id = (!empty($data['id_dokter']) ? urlencode($data['id_dokter']) : null);
$counter++;
?>
<tr>
    <td class="td-nama_dokter"> <?php echo $data['nama_dokter']; ?></td>
    <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-specialist">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['specialist'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
        </a>
    </td>
    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
    <td class="td-jasa_poli"> <span>Rp.<?php echo number_format($data['jasa_poli'],0,",",".");?></span></td>
    <td class="td-jasa_kunjungan"> <span>Rp.<?php echo number_format($data['jasa_kunjungan'],0,",",".");?></span></td>
    <td class="td-photo"> <?php echo $data['photo']; ?></td>
    <td class="td-tagihan_jasa_poli"> <?php echo $data['tagihan_jasa_poli']; ?></td>
    <td class="td-tagihan_jasa_kunjungan"> <?php echo $data['tagihan_jasa_kunjungan']; ?></td>
    <td class="td-jasa_igd"> <?php echo $data['jasa_igd']; ?></td>
    <td class="td-tagihan_jasa_igd"> <?php echo $data['tagihan_jasa_igd']; ?></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_dokter/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_dokter/edit/$rec_id"); ?>">
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
