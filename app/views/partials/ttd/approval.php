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
    <div  class="p-2 mb-2">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Approval Permintaan Barang</h4>
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
                    <div  class=" p-2 animated fadeIn page-content">
                        <style>
                            #canvasDiv{
                            border: 2px dashed grey;
                            height:300px;
                            }
                        </style>
                        <form id="cekapprovalkey" name="cekapprovalkey" action=""  method="post">
                            <input type="hidden" name="role" value="<?php echo USER_ROLE;?>">
                                <input type="hidden" name="datid" value="<?php echo USER_ID;?>">
                                    <div class="col-sm-6">                               
                                        <b>No Request : <?php echo $_GET['detile_request'];?></b>
                                    </div>
                                    <div align="center"><i class="fa fa-arrow-circle-down "></i> Pin Dan Password Approval</div>           
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="pin">Pin Approval <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">                                
                                                    <input id="ctrl-pin"  value="<?php  echo $this->set_field_value('pin',""); ?>" type="password" placeholder="Enter Pin Approval"  required="" name="pin"  class="form-control" />
                                                    </div>  <span id="pinerror" style="color:red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="password">Password Approval <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="input-group">                                    
                                                        <input id="ctrl-password"  value="<?php  echo $this->set_field_value('password',""); ?>" type="password" placeholder="Enter Password Approval"  required="" name="password"  class="form-control" />
                                                        </div>             <span id="passerror" style="color:red;"></span>                       
                                                    </div>
                                                </div>
                                            </div>  
                                            <div align="center"><span id="keyerror" style="color:red;"></span> </div> 
                                        </form>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-8 col-md-offset-2">
                                                    <br>
                                                        <?php echo isset($msg)?$msg:''; ?>
                                                        <div align="center"><b>TTD Di Sini</b></div>
                                                        <div align="center" id="canvasDiv"></div>
                                                        <br>
                                                            <button type="button" class="btn btn-danger" id="reset-btn">Clear</button>
                                                            <button type="button" class="btn btn-danger" onClick="window.location.reload()">Closed</button>
                                                            <button type="button" class="btn btn-success"  onclick="cekapp()">Proses Approval</button>
                                                        </div>
                                                        <form id="signatureform" action="<?php print_link("ttd/approval?csrf_token=$csrf_token") ?>" style="display:none" method="post">
                                                            <input type="hidden" id="signature" name="signature">
                                                                <input type="hidden"  name="id_daftar" value="<?php echo USER_ROLE;?>">
                                                                    <input type="hidden"  name="token" value="<?php echo $csrf_token;?>">
                                                                        <input type="hidden"  name="untuk" value="<?php echo $_GET['detile_request'];?>">
                                                                            <input type="hidden"  name="ttd" value="<?php echo $_GET['detile_request'];?>">
                                                                                <input type="hidden"  name="no_rekam_medis" value="<?php echo USER_ID;?>">
                                                                                    <input type="hidden" name="signaturesubmit" value="1">
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
                                                                            <script>
                                                                                function cekapp() {
                                                                                var pin = $('#ctrl-pin').val();
                                                                                var pass = $('#ctrl-password').val();
                                                                                if(pin==""){
                                                                                document.getElementById("ctrl-pin").focus();
                                                                                document.getElementById('pinerror').innerHTML = "Please enter Your Pin!!";
                                                                                setTimeout(function(){
                                                                                $('#pinerror').hide();
                                                                                clearerror();
                                                                                }, 5000);
                                                                                return false;
                                                                                }
                                                                                if(pass==""){
                                                                                document.getElementById("ctrl-password").focus();
                                                                                document.getElementById('passerror').innerHTML = "Please enter Your Password!!";
                                                                                setTimeout(function(){
                                                                                $('#passerror').hide();
                                                                                clearerror();
                                                                                }, 5000);
                                                                                return false;
                                                                                }
                                                                                appkey();
                                                                                }            
                                                                                function clearerror() { 
                                                                                $("#keyerror").html("");
                                                                                $("#pinerror").html("");
                                                                                $("#passerror").html("");
                                                                                $("#keyerror").show();
                                                                                $("#pinerror").show();
                                                                                $("#passerror").show();
                                                                                }
                                                                                function appkey() { 
                                                                                $.ajax({
                                                                                url:"<?php print_link("datakey.php");?>",
                                                                                method:"POST",
                                                                                data: $('#cekapprovalkey').serialize(),
                                                                                dataType:"JSON",
                                                                                success:function(data)
                                                                                {
                                                                                var hasil=""+ data.passok; 
                                                                                if(hasil=="OK"){
                                                                                var mycanvas = document.getElementById('canvas');
                                                                                var img = mycanvas.toDataURL("image/png");
                                                                                anchor = $("#signature");
                                                                                anchor.val(img);
                                                                                appfile();
                                                                                }else  {
                                                                                document.getElementById('keyerror').innerHTML = "Pin/Password salah!!";
                                                                                setTimeout(function(){
                                                                                $('#keyerror').hide();
                                                                                clearerror();
                                                                                }, 5000);
                                                                                return false; 
                                                                                }       
                                                                                // alert('Data OK');
                                                                                }
                                                                                });
                                                                                }
                                                                                function appfile() { 
                                                                                $.ajax({
                                                                                url:"<?php print_link("cekttd.php");?>",
                                                                                method:"POST",
                                                                                data: $('#signatureform').serialize(),
                                                                                dataType:"JSON",
                                                                                success:function(data)
                                                                                {
                                                                                var hasil=""+ data.passok; 
                                                                                if(hasil=="OK"){
                                                                                var result = confirm("Proses Approval Permintaan Barang?");
                                                                                if (result == true) {
                                                                                //document.getElementById('autobtn').click();
                                                                                // document.getElementById("pendaftaran_lab-lab-form").submit();
                                                                                var mycanvas = document.getElementById('canvas');
                                                                                var img = mycanvas.toDataURL("image/png");
                                                                                anchor = $("#signature");
                                                                                anchor.val(img);
                                                                                $("#signatureform").submit();
                                                                                return true;
                                                                                }
                                                                                else {
                                                                                return false;
                                                                                }
                                                                                }else  {
                                                                                document.getElementById('keyerror').innerHTML = "Silahkan TTD Untuk Approval";
                                                                                setTimeout(function(){
                                                                                $('#keyerror').hide();
                                                                                clearerror();
                                                                                }, 5000);
                                                                                return false; 
                                                                                }       
                                                                                // alert('Data OK');
                                                                                }
                                                                                });
                                                                                }
                                                                                $(document).ready(() => {
                                                                                var canvasDiv = document.getElementById('canvasDiv');
                                                                                var canvas = document.createElement('canvas');
                                                                                canvas.setAttribute('id', 'canvas');
                                                                                canvasDiv.appendChild(canvas);
                                                                                $("#canvas").attr('height', $("#canvasDiv").outerHeight());
                                                                                $("#canvas").attr('width', $("#canvasDiv").width());
                                                                                if (typeof G_vmlCanvasManager != 'undefined') {
                                                                                canvas = G_vmlCanvasManager.initElement(canvas);
                                                                                }
                                                                                context = canvas.getContext("2d");
                                                                                $('#canvas').mousedown(function(e) {
                                                                                var offset = $(this).offset()
                                                                                var mouseX = e.pageX - this.offsetLeft;
                                                                                var mouseY = e.pageY - this.offsetTop;
                                                                                paint = true;
                                                                                addClick(e.pageX - offset.left, e.pageY - offset.top);
                                                                                redraw();
                                                                                });
                                                                                $('#canvas').mousemove(function(e) {
                                                                                if (paint) {
                                                                                var offset = $(this).offset()
                                                                                //addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                                                                                addClick(e.pageX - offset.left, e.pageY - offset.top, true);
                                                                                console.log(e.pageX, offset.left, e.pageY, offset.top);
                                                                                redraw();
                                                                                }
                                                                                });
                                                                                $('#canvas').mouseup(function(e) {
                                                                                paint = false;
                                                                                });
                                                                                $('#canvas').mouseleave(function(e) {
                                                                                paint = false;
                                                                                });
                                                                                var clickX = new Array();
                                                                                var clickY = new Array();
                                                                                var clickDrag = new Array();
                                                                                var paint;
                                                                                function addClick(x, y, dragging) {
                                                                                clickX.push(x);
                                                                                clickY.push(y);
                                                                                clickDrag.push(dragging);
                                                                                }
                                                                                $("#reset-btn").click(function() {
                                                                                context.clearRect(0, 0, window.innerWidth, window.innerWidth);
                                                                                clickX = [];
                                                                                clickY = [];
                                                                                clickDrag = [];
                                                                                });
                                                                                // $(document).on('click', '#btn-save', function() {
                                                                                // var mycanvas = document.getElementById('canvas');
                                                                                // var img = mycanvas.toDataURL("image/png");
                                                                                // anchor = $("#signature");
                                                                                //  anchor.val(img);
                                                                                //  $("#signatureform").submit();
                                                                                // });
                                                                                var drawing = false;
                                                                                var mousePos = {
                                                                                x: 0,
                                                                                y: 0
                                                                                };
                                                                                var lastPos = mousePos;
                                                                                canvas.addEventListener("touchstart", function(e) {
                                                                                mousePos = getTouchPos(canvas, e);
                                                                                var touch = e.touches[0];
                                                                                var mouseEvent = new MouseEvent("mousedown", {
                                                                                clientX: touch.clientX,
                                                                                clientY: touch.clientY
                                                                                });
                                                                                canvas.dispatchEvent(mouseEvent);
                                                                                }, false);
                                                                                canvas.addEventListener("touchend", function(e) {
                                                                                var mouseEvent = new MouseEvent("mouseup", {});
                                                                                canvas.dispatchEvent(mouseEvent);
                                                                                }, false);
                                                                                canvas.addEventListener("touchmove", function(e) {
                                                                                var touch = e.touches[0];
                                                                                var offset = $('#canvas').offset();
                                                                                var mouseEvent = new MouseEvent("mousemove", {
                                                                                clientX: touch.clientX,
                                                                                clientY: touch.clientY
                                                                                });
                                                                                canvas.dispatchEvent(mouseEvent);
                                                                                }, false);
                                                                                // Get the position of a touch relative to the canvas
                                                                                function getTouchPos(canvasDiv, touchEvent) {
                                                                                var rect = canvasDiv.getBoundingClientRect();
                                                                                return {
                                                                                x: touchEvent.touches[0].clientX - rect.left,
                                                                                y: touchEvent.touches[0].clientY - rect.top
                                                                                };
                                                                                }
                                                                                var elem = document.getElementById("canvas");
                                                                                var defaultPrevent = function(e) {
                                                                                e.preventDefault();
                                                                                }
                                                                                elem.addEventListener("touchstart", defaultPrevent);
                                                                                elem.addEventListener("touchmove", defaultPrevent);
                                                                                function redraw() {
                                                                                //
                                                                                lastPos = mousePos;
                                                                                for (var i = 0; i < clickX.length; i++) {
                                                                                context.beginPath();
                                                                                if (clickDrag[i] && i) {
                                                                                context.moveTo(clickX[i - 1], clickY[i - 1]);
                                                                                } else {
                                                                                context.moveTo(clickX[i] - 1, clickY[i]);
                                                                                }
                                                                                context.lineTo(clickX[i], clickY[i]);
                                                                                context.closePath();
                                                                                context.stroke();
                                                                                }
                                                                                }
                                                                                })
                                                                            </script>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
