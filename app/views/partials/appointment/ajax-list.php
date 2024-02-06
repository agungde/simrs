<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("appointment/add");
$can_edit = ACL::is_allowed("appointment/edit");
$can_view = ACL::is_allowed("appointment/view");
$can_delete = ACL::is_allowed("appointment/delete");
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
$rec_id = (!empty($data['id_appointment']) ? urlencode($data['id_appointment']) : null);
$counter++;
?>
<tr>
    <td class="td-tanggal_appointment"> <?php echo $data['tanggal_appointment']; ?></td>
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-no_antri_poli"> <span><div size="sm" class="btn btn-sm btn-primary"><b><?php echo $data['no_antri_poli']; ?></b></div></span></td>
    <td class="td-nama_pasien"> <span>
        <?php echo $data['nama_pasien']; ?>
        <?php
        $datapoli=$data['id_pendaftaran_poli']; 
        $sekarang       = gmdate("Y-m-d", time() + 60 * 60 * 7);
        // if($data['tanggal_appointment']=="$sekarang" and $data['setatus']==""){
        if($data['setatus']==""){
        ?>
        <a class="btn btn-sm btn-primary has-tooltip" title="Edit This Record" href="<?php print_link("pendaftaran_poli/chekin/$datapoli"); ?>">
            <i class="fa fa-edit"></i> Chekin
        </a> 
        <?php
        }
        // }
        ?>
    </span></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-nama_poli">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['nama_poli'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
        </a>
    </td>
    <td class="td-dokter"> <span><?php
        $id_user = "".USER_ID;
        $dbhost  = "".DB_HOST;
        $dbuser  = "".DB_USERNAME;
        $dbpass  = "".DB_PASSWORD;
        $dbname  = "".DB_NAME;
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        
        $sql = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='".$data['dokter']."'");
        while ($row=mysqli_fetch_array($sql)){
        $namadok=$row['nama_dokter'];
        }
    echo $namadok; ?></span></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
    <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("appointment/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("appointment/edit/$rec_id"); ?>">
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
