<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_permintaan_barang/add");
$can_edit = ACL::is_allowed("data_permintaan_barang/edit");
$can_view = ACL::is_allowed("data_permintaan_barang/view");
$can_delete = ACL::is_allowed("data_permintaan_barang/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col comp-grid">
                    <div class=""><div>
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['detile_request'])){
                        $norequest=$_GET['detile_request'];
                        $queryin = mysqli_query($koneksi, "SELECT * from permintaan_barang WHERE no_request='$norequest'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $datain= mysqli_fetch_assoc($queryin);
                        $id=$datain['id'];
                        $divisi=$datain['divisi'];
                        $bag=$datain['bagian'];
                        $no_request=$datain['no_request'];
                        $tanggal=$datain['tanggal'];
                        $category_barang=$datain['category_barang'];
                        $approval=$datain['approval'];
                        $total_jumlah=$datain['total_jumlah'];
                        $setatus=$datain['setatus'];
                        // $type_pembelian=$datain['type_pembelian'];
                        // $namasuplier="$nama_suplier";
                        $qu = mysqli_query($koneksi, "SELECT * from category_barang WHERE id='$category_barang'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $ro = mysqli_num_rows($qu);
                        if ($ro <> 0) {
                        $dat= mysqli_fetch_assoc($qu);
                        $namacat=$dat['category'];
                        } 
                        } else{
                        }
                        if($divisi=="IGD"){
                        $bagian=$bag;
                        }else if($divisi=="POLI"){
                        $qudtpab = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$bag'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rodtpab = mysqli_num_rows($qudtpab);
                        if ($rodtpab <> 0) {
                        $cdt= mysqli_fetch_assoc($qudtpab);
                        //  $spesial=$cdt['specialist'];
                        $bagian= $cdt['nama_poli'];
                        }else{
                        $bagian=""; 
                        }
                        }else  if($divisi=="RANAP"){
                        $qudtpab = mysqli_query($koneksi, "SELECT * from nama_kamar_ranap WHERE id='$bag'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rodtpab = mysqli_num_rows($qudtpab);
                        if ($rodtpab <> 0) {
                        $cdt= mysqli_fetch_assoc($qudtpab);
                        //  $spesial=$cdt['specialist'];
                        $bagian=$cdt['nama_kamar'];
                        }else{
                        $bagian==""; 
                        }
                        } 
                        }
                        ?>  
                    </div>
                </div><h4 >Detile Permintaan Barang Divisi <?php echo $divisi;?></h4>
            </div>
            <div class="col-md-12 comp-grid">
            </div>
        </div>
    </div>
</div>
<div  class="">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12 comp-grid">
                <?php $this :: display_page_errors(); ?>
                <div  class=" animated fadeIn page-content">
                    <div id="page-report-body" class="">
                        <table class="table table-hover table-borderless table-striped">
                            <!-- Table Body Start -->
                            <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                <tr  class="td-tanggal">
                                    <th class="title"> Tanggal: </th>
                                    <td class="value"> <?php echo $tanggal; ?></td>
                                </tr>
                                <tr  class="td-no_request">
                                    <th class="title"> No Request: </th>
                                    <td class="value"> <?php echo $no_request; ?></td>
                                </tr>
                                <tr  class="td-category_barang">
                                    <th class="title"> Category Barang: </th>
                                    <td class="value">
                                        <?php echo $namacat; ?>
                                    </td>
                                </tr>
                                <tr  class="td-total_jumlah">
                                    <th class="title"> Total Jumlah: </th>
                                    <td class="value"> <?php echo $total_jumlah; ?></td>
                                </tr>
                                <tr  class="td-divisi">
                                    <th class="title"> Divisi: </th>
                                    <td class="value"> <?php echo $divisi; ?></td>
                                </tr>
                                <tr  class="td-divisi">
                                    <th class="title"> Bagian: </th>
                                    <td class="value"> <?php echo $bagian; ?></td>
                                </tr>    
                                <tr  class="td-category_barang">
                                    <th class="title"> Status: </th>
                                    <td class="value">
                                        <?php echo $setatus; ?>
                                    </td>
                                </tr>         
                                <tr  class="td-approval_hrd">
                                    <th class="title"> Approval: </th>
                                    <td class="value"> <?php 
                                        if($approval==""){
                                        if(USER_ROLE==9){
                                        ?>
                                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("ttd/approval?detile_request=".$_GET['detile_request']);?>">
                                        <i class="fa fa-send"></i> Proses Approval</a>
                                    </button>    
                                    <?php
                                    }
                                    }else{
                                    ?>
                                    <?php Html :: page_img($approval,50,50,1); ?>     
                                    <?php
                                    }
                                ?></td>
                            </tr>
                        </tbody>
                        <!-- Table Body End -->
                    </table>
                </div>
                <div id="data_permintaan_barang-detile-records">
                    <div id="page-report-body" class="table-responsive">
                        <table class="table  table-sm text-left">
                            <thead class="table-header ">
                                <tr>
                                    <th  class="td-kode_barang"> Kode Barang</th>
                                    <th  class="td-nama_barang"> Nama Barang</th>
                                    <th  class="td-category_barang"> Category Barang</th>
                                    <th  class="td-jumlah"> Jumlah</th>
                                    <th class="td-btn"></th>
                                </tr>
                            </thead>
                            <?php
                            if(!empty($records)){
                            ?>
                            <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                <!--record-->
                                <?php
                                $counter = 0;
                                foreach($records as $data){
                                $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                $counter++;
                                ?>
                                <tr>
                                    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
                                    <td class="td-category_barang"> <?php 
                                        $qudtpab = mysqli_query($koneksi, "SELECT * from category_barang WHERE id='".$data['category_barang']."'")
                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                        $rodtpab = mysqli_num_rows($qudtpab);
                                        if ($rodtpab <> 0) {
                                        $cdt= mysqli_fetch_assoc($qudtpab);
                                        $categ=$cdt['category'];
                                        echo $categ;
                                        }else{
                                        echo $data['category_barang'];   
                                        }
                                    ?></td>
                                    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                </tr>
                                <?php 
                                }
                                ?>
                                <!--endrecord-->
                            </tbody>
                            <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                            <?php
                            }
                            ?>
                        </table>
                        <?php 
                        if(empty($records)){
                        ?>
                        <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                            <i class="fa fa-ban"></i> No record found
                        </h4>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if( $show_footer && !empty($records)){
                    ?>
                    <div class=" border-top mt-2">
                        <div class="row justify-content-center">    
                            <div class="col-md-auto justify-content-center">    
                                <div class="p-3 d-flex justify-content-between">    
                                </div>
                            </div>
                            <div class="col">   
                                <?php
                                if($show_pagination == true){
                                $pager = new Pagination($total_records, $record_count);
                                $pager->route = $this->route;
                                $pager->show_page_count = true;
                                $pager->show_record_count = true;
                                $pager->show_page_limit =true;
                                $pager->limit_count = $this->limit_count;
                                $pager->show_page_number_list = true;
                                $pager->pager_link_range=5;
                                $pager->render();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    if(USER_ROLE==20){
                    if($setatus=="Approv"){
                    ?><div align="center"><a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim()">
                    <i class="fa fa-send"></i> Proses kirim Barang</a></div>
                    <form name="proses" id="kirimbarang" method="post" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>">
                        <input type="hidden" name="kirim" value="<?php echo $no_request; ?>"/>
                            <input type="hidden" name="token" value="<?php echo $csrf_token; ?>"/>
                            </form>                               
                            <script>
                                function kirim(){ 
                                var result = confirm("Kirim Barang No Request <?php echo $no_request; ?>!! \n Apakah Semua Barang Sudah Sesuai? \n Proses Kirim Barang Ke Divisi: <?php echo $divisi; ?> Bagian: <?php echo $bagian; ?>?");
                                if (result == true) {
                                //document.getElementById('autobtn').click();
                                document.getElementById("kirimbarang").submit();
                                return true;
                                }
                                else {
                                return false;
                                }
                                }
                            </script>
                            <?php } }
                            if($setatus=="Di Kirim"){  
                            if(USER_ROLE==8){
                            $divisi="IGD";
                            $bagian="IGD";
                            ?>
                            <div align="center"><a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim()">
                            <i class="fa fa-send"></i> Terima Barang</a></div>    
                            <?php      
                            }else if(USER_ROLE==6){
                            $divisi="POLI";
                            $cekbag=$_SESSION[APP_ID.'user_data']['admin_poli'];
                            if($cekbag==$bag){
                            ?>
                            <div align="center"><a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim()">
                            <i class="fa fa-send"></i> Terima Barang</a></div>    
                            <?php      
                            }
                            }else  if(USER_ROLE==13){
                            $divisi="RANAP";
                            $cekbag=$_SESSION[APP_ID.'user_data']['admin_ranap'];  
                            if($cekbag==$bag){
                            ?>
                            <div align="center"><a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim()">
                            <i class="fa fa-send"></i> Terima Barang</a></div>    
                            <?php      
                            } 
                            }else if(USER_ROLE==5){
                            $divisi = "FARMASI";
                            $bagian= "FARMASI";
                            ?>
                            <div align="center"><a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim()">
                            <i class="fa fa-send"></i> Terima Barang</a></div>    
                            <?php   
                            }
                            ?>
                            <form name="proses" id="terimabarang" method="post" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>">
                                <input type="hidden" name="terima" value="<?php echo $no_request; ?>"/>
                                    <input type="hidden" name="token" value="<?php echo $csrf_token; ?>"/>
                                    </form>                               
                                    <script>
                                        function kirim(){ 
                                        var result = confirm("Terima Barang No Request <?php echo $no_request; ?> !!\n Apakah Semua Barang Sudah Sesuai? \n Proses Terima Barang Divisi: <?php echo $divisi; ?> Bagian: <?php echo $bagian; ?>?");
                                        if (result == true) {
                                        //document.getElementById('autobtn').click();
                                        document.getElementById("terimabarang").submit();
                                        return true;
                                        }
                                        else {
                                        return false;
                                        }
                                        }
                                    </script>
                                    <?php
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
