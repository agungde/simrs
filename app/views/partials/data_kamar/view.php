<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_kamar/add");
$can_edit = ACL::is_allowed("data_kamar/edit");
$can_view = ACL::is_allowed("data_kamar/view");
$can_delete = ACL::is_allowed("data_kamar/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Data Kamar</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id_data_kamar']) ? urlencode($data['id_data_kamar']) : null);
                        $jumranjang=$data['jumlah_ranjang'];
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-kamar_kelas">
                                        <th class="title"> Kamar Kelas: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_kelas/view/" . urlencode($data['kamar_kelas'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_kelas_nama_kelas'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-nama_kamar">
                                        <th class="title"> Nama Kamar: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_kamar']; ?>" 
                                                data-pk="<?php echo $data['id_data_kamar'] ?>" 
                                                data-url="<?php print_link("data_kamar/editfield/" . urlencode($data['id_data_kamar'])); ?>" 
                                                data-name="nama_kamar" 
                                                data-title="Enter Nama Kamar" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php 
                                                $id_user = "".USER_ID;
                                                $dbhost  = "".DB_HOST;
                                                $dbuser  = "".DB_USERNAME;
                                                $dbpass  = "".DB_PASSWORD;
                                                $dbname  = "".DB_NAME;
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                $sqlcek1 = mysqli_query($koneksi,"select * from nama_kamar_ranap WHERE id='".$data['nama_kamar']."'");
                                                $rows1 = mysqli_num_rows($sqlcek1);
                                                if ($rows1 <> 0) {
                                                $row= mysqli_fetch_assoc($sqlcek1); 
                                                echo $row['nama_kamar'];
                                                }else{
                                                echo $data['nama_kamar']; 
                                                }
                                                ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-no_kamar">
                                        <th class="title"> No Kamar: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_kamar']; ?>" 
                                                data-pk="<?php echo $data['id_data_kamar'] ?>" 
                                                data-url="<?php print_link("data_kamar/editfield/" . urlencode($data['id_data_kamar'])); ?>" 
                                                data-name="no_kamar" 
                                                data-title="Enter No Kamar" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['no_kamar']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-harga">
                                        <th class="title"> Harga: </th>
                                        <td class="value"><?php 
                                            $sql = mysqli_query($koneksi,"select * from data_kelas WHERE id_kelas='".$data['kamar_kelas']."'");
                                            while ($row=mysqli_fetch_array($sql)){
                                            $hargakamar=$row['harga'];
                                            } echo number_format($hargakamar,0,",",".");
                                        ?></td>
                                    </tr>            
                                    <tr  class="td-jumlah_ranjang">
                                        <th class="title"> Jumlah Ranjang: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['jumlah_ranjang']; ?>" 
                                                data-pk="<?php echo $data['id_data_kamar'] ?>" 
                                                data-url="<?php print_link("data_kamar/editfield/" . urlencode($data['id_data_kamar'])); ?>" 
                                                data-name="jumlah_ranjang" 
                                                data-title="Enter Jumlah Ranjang" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="number" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['jumlah_ranjang']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-terisi">
                                        <th class="title"> Terisi: </th>
                                        <td class="value"> <?php echo $data['terisi']; ?></td>
                                    </tr>
                                    <tr  class="td-sisa">
                                        <th class="title"> Sisa: </th>
                                        <td class="value"><?php
                                            if($data['terisi']=="" or $data['terisi']=="0" and $data['sisa']=="" or $data['sisa']=="0"){
                                            echo $data['jumlah_ranjang']; 
                                            }else{
                                            echo $data['sisa']; 
                                            }
                                        ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        //$rec_id
                        ?>
                        <div align="center"><h3>Data Ranjang</h3></div>
                        <div align="center"><h4><img src="<?php print_link("assets/images/bed.png") ?>" width="35px"
                            height="35px"/> = isi | <img src="<?php print_link("assets/images/bed0.png") ?>" width="35px"
                            height="35px"/> = Kosong</h4></div>
                            <div id="appointment-liveap-records">    
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-striped table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <?php
                                                $Query = "SELECT * FROM data_ranjang WHERE id_data_kamar='$rec_id'";
                                                $ExecQuery = MySQLi_query($koneksi, $Query);   
                                                $hitung=0;
                                                //while ($Result = MySQLi_fetch_array($ExecQuery)) {
                                                // $hitung=$hitung + 1;
                                                // $jumran=$Result['jumlah_ranjang'];
                                                for($a = 0; $a < $jumranjang; $a++){
                                                $nom=$a + 1;
                                                echo "<th >No $nom</th>";
                                                }?>
                                            </tr>
                                        </thead>
                                        <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                            <tr>
                                                <?php
                                                while ($Result = MySQLi_fetch_array($ExecQuery)) {
                                                for($b = 0; $b < $jumranjang; $b++){
                                                $nob=$b + 1;
                                                $dat="no_$nob";
                                                if($Result[$dat]==""){
                                                ?>
                                                <td><img src="<?php print_link("assets/images/bed0.png") ?>" width="35px"
                                                height="35px"/></td>
                                                <?php
                                                }else{
                                                ?>
                                                <td><img src="<?php print_link("assets/images/bed.png") ?>" width="35px"
                                                height="35px"/></td>
                                                <?php
                                                }
                                                }
                                                }
                                                ?>
                                            </tr>  </tbody>
                                        </table>                                           
                                    </div></div></br>
                                    <div class="p-3 d-flex">
                                    </div>
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <!-- Empty Record Message -->
                                    <div class="text-muted p-3">
                                        <i class="fa fa-ban"></i> No Record Found
                                    </div>
                                    <?php
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
