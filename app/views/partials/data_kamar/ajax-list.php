<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_kamar/add");
$can_edit = ACL::is_allowed("data_kamar/edit");
$can_view = ACL::is_allowed("data_kamar/view");
$can_delete = ACL::is_allowed("data_kamar/delete");
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
$rec_id = (!empty($data['id_data_kamar']) ? urlencode($data['id_data_kamar']) : null);
$counter++;
?>
<tr>
    <td class="td-kamar_kelas">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_kelas/view/" . urlencode($data['kamar_kelas'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['data_kelas_nama_kelas'] ?>
        </a>
    </td>
    <td class="td-nama_kamar">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("nama_kamar_ranap/view/" . urlencode($data['nama_kamar'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['nama_kamar_ranap_nama_kamar'] ?>
        </a>
    </td>
    <td class="td-no_kamar"> <?php echo $data['no_kamar']; ?></td>
    <td class="td-harga"> <span>
        <?php 
        $id_user = "".USER_ID;
        $dbhost  = "".DB_HOST;
        $dbuser  = "".DB_USERNAME;
        $dbpass  = "".DB_PASSWORD;
        $dbname  = "".DB_NAME;
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        
        $sql = mysqli_query($koneksi,"select * from data_kelas WHERE id_kelas='".$data['kamar_kelas']."'");
        while ($row=mysqli_fetch_array($sql)){
        $hargakamar=$row['harga'];
        } echo number_format($hargakamar,0,",",".");
    ?></span></td>
    <td class="td-jumlah_ranjang"> <span>
        <?php
        if(!empty($_GET['precord'])){
        $isipre=$_GET['precord'];
        ?>
        <a size="sm" class="btn btn-sm btn-primary " href="<?php print_link("data_kamar/detile?precord=$isipre&fromdata=$rec_id");?>">
            <i class="fa fa-eye"></i>                                                    
        <?php echo $data['jumlah_ranjang']; ?> Pilih</a>
        <?php
        }else{
        ?>
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_kamar/view/$rec_id");?>"> <i class="fa fa-eye"></i>                                                    
        <?php echo $data['jumlah_ranjang']; ?> View</a>        
        <?php
        }?>
    </span></td>
    <td class="td-terisi"> <?php echo $data['terisi']; ?></td>
    <td class="td-sisa"> <span><?php
        if($data['terisi']=="" or $data['terisi']=="0" and $data['sisa']=="" or $data['sisa']=="0"){
        echo $data['jumlah_ranjang']; 
        }else{
        echo $data['sisa']; 
        }
    ?></span></td>
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
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_kamar/edit/$rec_id"); ?>">
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
