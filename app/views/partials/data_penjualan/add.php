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
                    <h4 class="record-title">Add New Data Penjualan</h4>
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
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="data_penjualan-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_penjualan/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="id_pelanggan">Id Pelanggan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-id_pelanggan"  value="<?php  echo $this->set_field_value('id_pelanggan',""); ?>" type="text" placeholder="Enter Id Pelanggan"  required="" name="id_pelanggan"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-tanggal"  value="<?php  echo $this->set_field_value('tanggal',""); ?>" type="text" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-nama_pelanggan"  value="<?php  echo $this->set_field_value('nama_pelanggan',""); ?>" type="text" placeholder="Enter Nama Pelanggan"  required="" name="nama_pelanggan"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-alamat"  value="<?php  echo $this->set_field_value('alamat',""); ?>" type="text" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="no_hp">No Hp <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-no_hp"  value="<?php  echo $this->set_field_value('no_hp',""); ?>" type="text" placeholder="Enter No Hp"  required="" name="no_hp"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-kode_barang"  value="<?php  echo $this->set_field_value('kode_barang',""); ?>" type="text" placeholder="Enter Kode Barang"  required="" name="kode_barang"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-nama_barang"  value="<?php  echo $this->set_field_value('nama_barang',""); ?>" type="text" placeholder="Enter Nama Barang"  required="" name="nama_barang"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-jumlah"  value="<?php  echo $this->set_field_value('jumlah',""); ?>" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="harga">Harga <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-harga"  value="<?php  echo $this->set_field_value('harga',""); ?>" type="number" placeholder="Enter Harga" step="1"  required="" name="harga"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="total_harga">Total Harga <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-total_harga"  value="<?php  echo $this->set_field_value('total_harga',""); ?>" type="number" placeholder="Enter Total Harga" step="1"  required="" name="total_harga"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="total_bayar">Total Bayar <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-total_bayar"  value="<?php  echo $this->set_field_value('total_bayar',""); ?>" type="number" placeholder="Enter Total Bayar" step="1"  required="" name="total_bayar"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="ppn">Ppn <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-ppn"  value="<?php  echo $this->set_field_value('ppn',""); ?>" type="text" placeholder="Enter Ppn"  required="" name="ppn"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-nama_poli"  value="<?php  echo $this->set_field_value('nama_poli',""); ?>" type="number" placeholder="Enter Nama Poli" step="1"  required="" name="nama_poli"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="operator">Operator <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-operator"  value="<?php  echo $this->set_field_value('operator',""); ?>" type="number" placeholder="Enter Operator" step="1"  required="" name="operator"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="date_updated">Date Updated <span class="text-danger">*</span></label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="input-group">
                                                                                                        <input id="ctrl-date_updated" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('date_updated',""); ?>" type="datetime"  name="date_updated" placeholder="Enter Date Updated" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                                            <div class="input-group-append">
                                                                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="id_penjualan">Id Penjualan <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <input id="ctrl-id_penjualan"  value="<?php  echo $this->set_field_value('id_penjualan',""); ?>" type="text" placeholder="Enter Id Penjualan"  required="" name="id_penjualan"  class="form-control " />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="diskon">Diskon <span class="text-danger">*</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <input id="ctrl-diskon"  value="<?php  echo $this->set_field_value('diskon',""); ?>" type="text" placeholder="Enter Diskon"  required="" name="diskon"  class="form-control " />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="no_invoice">No Invoice <span class="text-danger">*</span></label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="">
                                                                                                                    <input id="ctrl-no_invoice"  value="<?php  echo $this->set_field_value('no_invoice',""); ?>" type="text" placeholder="Enter No Invoice"  required="" name="no_invoice"  class="form-control " />
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group ">
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-4">
                                                                                                                    <label class="control-label" for="id_transaksi">Id Transaksi <span class="text-danger">*</span></label>
                                                                                                                </div>
                                                                                                                <div class="col-sm-8">
                                                                                                                    <div class="">
                                                                                                                        <input id="ctrl-id_transaksi"  value="<?php  echo $this->set_field_value('id_transaksi',""); ?>" type="number" placeholder="Enter Id Transaksi" step="1"  required="" name="id_transaksi"  class="form-control " />
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group ">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <label class="control-label" for="divisi">Divisi <span class="text-danger">*</span></label>
                                                                                                                    </div>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <div class="">
                                                                                                                            <input id="ctrl-divisi"  value="<?php  echo $this->set_field_value('divisi',""); ?>" type="text" placeholder="Enter Divisi"  required="" name="divisi"  class="form-control " />
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-group ">
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <label class="control-label" for="bagian">Bagian <span class="text-danger">*</span></label>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-8">
                                                                                                                            <div class="">
                                                                                                                                <input id="ctrl-bagian"  value="<?php  echo $this->set_field_value('bagian',""); ?>" type="text" placeholder="Enter Bagian"  required="" name="bagian"  class="form-control " />
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group ">
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-sm-4">
                                                                                                                                <label class="control-label" for="lap">Lap <span class="text-danger">*</span></label>
                                                                                                                            </div>
                                                                                                                            <div class="col-sm-8">
                                                                                                                                <div class="">
                                                                                                                                    <input id="ctrl-lap"  value="<?php  echo $this->set_field_value('lap',""); ?>" type="number" placeholder="Enter Lap" step="1"  required="" name="lap"  class="form-control " />
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="form-group ">
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-sm-4">
                                                                                                                                    <label class="control-label" for="id_data_setok">Id Data Setok <span class="text-danger">*</span></label>
                                                                                                                                </div>
                                                                                                                                <div class="col-sm-8">
                                                                                                                                    <div class="">
                                                                                                                                        <input id="ctrl-id_data_setok"  value="<?php  echo $this->set_field_value('id_data_setok',""); ?>" type="number" placeholder="Enter Id Data Setok" step="1"  required="" name="id_data_setok"  class="form-control " />
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="form-group ">
                                                                                                                                <div class="row">
                                                                                                                                    <div class="col-sm-4">
                                                                                                                                        <label class="control-label" for="trx">Trx <span class="text-danger">*</span></label>
                                                                                                                                    </div>
                                                                                                                                    <div class="col-sm-8">
                                                                                                                                        <div class="">
                                                                                                                                            <input id="ctrl-trx"  value="<?php  echo $this->set_field_value('trx',""); ?>" type="text" placeholder="Enter Trx"  required="" name="trx"  class="form-control " />
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="form-group ">
                                                                                                                                    <div class="row">
                                                                                                                                        <div class="col-sm-4">
                                                                                                                                            <label class="control-label" for="setatus">Setatus <span class="text-danger">*</span></label>
                                                                                                                                        </div>
                                                                                                                                        <div class="col-sm-8">
                                                                                                                                            <div class="">
                                                                                                                                                <input id="ctrl-setatus"  value="<?php  echo $this->set_field_value('setatus',""); ?>" type="text" placeholder="Enter Setatus"  required="" name="setatus"  class="form-control " />
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                                                                    <div class="form-ajax-status"></div>
                                                                                                                                    <button class="btn btn-primary" type="submit">
                                                                                                                                        Submit
                                                                                                                                        <i class="fa fa-send"></i>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                            </form>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </section>
