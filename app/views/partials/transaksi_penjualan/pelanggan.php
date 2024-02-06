<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Pelanggan</h4>
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
                <div class="col-md-7 comp-grid">
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
                        if(isset($_POST['pelanggan'])){
                        $search  = $_POST['pelanggan'];
                        $querypl = mysqli_query($koneksi, "SELECT * from pelanggan where id_pelanggan='$search' or nama_pelanggan='$search'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowspl = mysqli_num_rows($querypl);
                        if ($rowspl <> 0) {
                        $datapl         = mysqli_fetch_assoc($querypl);
                        $id_pelanggan    = $datapl['id_pelanggan'];
                        $nama_pelanggan = $datapl['nama_pelanggan'];
                        $alamat         = $datapl['alamat'];
                        $no_hp         = $datapl['phone'];
                        mysqli_query($koneksi, "UPDATE transaksi_penjualan SET nama_pelanggan='$nama_pelanggan', alamat='$alamat',no_hp='$no_hp',id_pelanggan='$id_pelanggan' WHERE id_jual='$idtrace'");
                        mysqli_query($koneksi, "UPDATE penjualan SET nama_pelanggan='$nama_pelanggan', alamat='$alamat',no_hp='$no_hp',id_pelanggan='$id_pelanggan' WHERE id_jual='$idtrace'");
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Berhasil Di Ganti Ke Pelanggan');
                            document.location='<?php print_link("transaksi_penjualan/penjualan"); ?>';
                        </script>
                        <?php 
                        }
                        ?>  
                    </div>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="transaksi_penjualan-pelanggan-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi_penjualan/pelanggan?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <label class="control-label" for="cari">Cari Nama/No HP/Alamat Pelanggan</label>
                                <div id="ctrl-nama_barang" class=""> 
                                    <input type="text" id="searchpel" placeholder="Cari Nama/No HP/Alamat Pelanggan" name="pelanggan" class="form-control "/> 
                                </div>
                            </div>    
                        </div>
                        <div id="displaypel"></div>
                        <div class="form-group form-submit-btn-holder text-center mt-3">
                            <div class="form-ajax-status"></div>
                            <button class="btn btn-primary" type="submit" >
                                Submit
                                <i class="fa fa-send"></i>
                            </button>
                        </div>
                    </form>
                    <script>
                        function validateForm() {
                        let x = document.forms["myForm"]["pelanggan"].value;
                        if (x == "") {
                        // alert("Isi Form Pelanggan!!");
                        return false;
                        //clearTimeout(reloadpage);
                        }else{
                        reloadpage();
                        }
                        }       
                        function reloadpage() {
                        setTimeout(function(){ window.location.reload();}, 2000);
                        }
                        function fillpel(Value) {
                        //Assigning value to "search" div in "search.php" file.
                        $('#searchpel').val(Value);
                        //Hiding "display" div in "search.php" file.
                        $('#displaypel').hide();
                        }
                        $(document).ready(function() {
                        //On pressing a key on "Search box" in "search.php" file. This function will be called.
                        $('#searchpel').val("").focus();
                        $('#searchpel').keyup(function(e){
                        var tex = $(this).val();
                        console.log(tex);
                        if(tex !=="" && e.keyCode===13){
                        }
                        e.preventDefault();
                        //Assigning search box value to javascript variable named as "name".
                        var name = $('#searchpel').val();
                        //Validating, if "name" is empty.
                        if (name == "") {
                        //Assigning empty value to "display" div in "search.php" file.
                        $("#displaypel").html("");
                        }
                        //If name is not empty.
                        else {
                        //AJAX is called.
                        $.ajax({
                        //AJAX type is "Post".
                        type: "POST",
                        //Data will be sent to "ajax.php".
                        url: "<?php print_link("pelanggan.php") ?>",
                        //Data, that will be sent to "ajax.php".
                        data: {
                        //Assigning value of "name" into "search" variable.
                        search: name
                        },
                        //If result found, this funtion will be called.
                        success: function(html) {
                        //Assigning result to "display" div in "search.php" file.
                        $("#displaypel").html(html).show();
                        }
                        });
                        }
                        });
                        });
                    </script> 
                    <style>
                        a:hover {
                        cursor: pointer;
                        background-color: #F5F5DC;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
