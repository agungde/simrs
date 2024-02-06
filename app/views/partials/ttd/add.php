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
    <div  class=" p-2 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php 
                        if(!empty($_GET['ttd'])){
                        $untuk=$_GET['ttd'];
                        }else{
                        $untuk="";
                        }
                        if(!empty($_GET['datprecord'])){
                        $id_daftar=$_GET['datprecord'];
                        }else{
                        $id_daftar="";
                        }
                        if(!empty($_GET['datfrom'])){
                        $id_daftar=$_GET['datfrom'];
                        }
                        if(!empty($_GET['precord'])){
                        $no_rekam_medis=$_GET['precord'];
                        }else{
                        $no_rekam_medis="";
                        }
                        if(!empty($_GET['datdari'])){
                        $datdari=$_GET['datdari'];
                        }else{
                        $datdari="";
                        }
                        if(!empty($_GET['darecord'])){
                        $darecord=$_GET['darecord'];
                        }else{
                        $darecord="";
                        }
                        ?>   
                    </div></div><h4 class="record-title">TTD Untuk <?php echo $untuk;?></h4>
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
                <div class="col-md-6 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" p-2 animated fadeIn page-content">
                        <html>
                            <head>
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <style>
                                        #canvasDiv{
                                        border: 2px dashed grey;
                                        height:300px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <br>
                                                    <?php echo isset($msg)?$msg:''; ?>
                                                    <div align="center"><b>TTD Di Sini</b></div>
                                                    <div align="center" id="canvasDiv"></div>
                                                    <br>
                                                        <button type="button" class="btn btn-danger" id="reset-btn">Clear</button>
                                                        <button type="button" class="btn btn-success" id="btn-save">Simpan</button>
                                                        <button type="button" class="btn btn-danger" onClick="window.location.reload()">Closed</button>
                                                    </div>
                                                    <form id="signatureform" action="<?php print_link("ttd/add?csrf_token=$csrf_token") ?>" style="display:none" method="post">
                                                        <input type="hidden" id="signature" name="signature">
                                                            <input type="hidden"  name="id_daftar" value="<?php echo $id_daftar;?>">
                                                                <input type="hidden"  name="id_transaksi" value="<?php echo $id_transaksi;?>">
                                                                    <input type="hidden"  name="untuk" value="<?php echo $untuk;?>">
                                                                        <input type="hidden"  name="ttd" value="<?php echo $untuk;?>">
                                                                            <input type="hidden"  name="no_rekam_medis" value="<?php echo $no_rekam_medis;?>">
                                                                                <input type="hidden"  name="datdari" value="<?php echo $datdari;?>">
                                                                                    <input type="hidden"  name="darecord" value="<?php echo $darecord;?>">
                                                                                        <?php
                                                                                        if(!empty($_GET['pasien'])){
                                                                                        $pasien=$_GET['pasien'];
                                                                                        }else{
                                                                                        $pasien="";
                                                                                        }
                                                                                        if(!empty($_GET['datfrom'])){
                                                                                        $datfrom=$_GET['datfrom'];
                                                                                        }else{
                                                                                        $datfrom="";
                                                                                        }               
                                                                                        if(!empty($_GET['datprecord'])){
                                                                                        $datprecord=$_GET['datprecord'];
                                                                                        }else{
                                                                                        $datprecord="";
                                                                                        }                    
                                                                                        ?>
                                                                                        <input type="hidden"  name="pasien" value="<?php echo $pasien;?>">    
                                                                                            <input type="hidden"  name="datfrom" value="<?php echo $datfrom;?>"> 
                                                                                                <input type="hidden"  name="datprecord" value="<?php echo $datprecord;?>"> 
                                                                                                    <input type="hidden"  name="precord" value="<?php echo $_SESSION['backlink'];?>">
                                                                                                        <input type="hidden" name="signaturesubmit" value="1">
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </body>
                                                                                            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
                                                                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
                                                                                            <script>
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
                                                                                                $(document).on('click', '#btn-save', function() {
                                                                                                var mycanvas = document.getElementById('canvas');
                                                                                                var img = mycanvas.toDataURL("image/png");
                                                                                                anchor = $("#signature");
                                                                                                anchor.val(img);
                                                                                                $("#signatureform").submit();
                                                                                                });
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
                                                                                        </html>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
