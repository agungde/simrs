
<?php
  require('config.php');
$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";

if (isset($_POST['tglpos'])) {
	$sekarang=$_POST['tglpos'];
	//$sekarang=date_format($sekarang,"Y-m-d");
	//echo ">$date<";
	//$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
}else{
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
}

//$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
$tgl0=$sekarang;
$tgl1    =date("Y-m-d", strtotime("-1 day", strtotime($sekarang)));
$tgl2    =date("Y-m-d", strtotime("-2 day", strtotime($sekarang)));
$tgl3    =date("Y-m-d", strtotime("-3 day", strtotime($sekarang)));
$tgl4    =date("Y-m-d", strtotime("-4 day", strtotime($sekarang)));
$tgl5    =date("Y-m-d", strtotime("-5 day", strtotime($sekarang)));
$tgl6    =date("Y-m-d", strtotime("-6 day", strtotime($sekarang)));
$tgl7    =date("Y-m-d", strtotime("-7 day", strtotime($sekarang)));
$tgl8    =date("Y-m-d", strtotime("-8 day", strtotime($sekarang)));
$tgl9    =date("Y-m-d", strtotime("-9 day", strtotime($sekarang)));

$query0 = mysqli_query($koneksi, "SELECT COUNT(*) AS num0 from appointment WHERE tanggal_appointment='$tgl0'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows0 = mysqli_num_rows($query0);
 if ($rows0 <> 0) {
     $dat0=mysqli_fetch_assoc($query0);
     $data0=$dat0['num0'];
 }else{
     $data0="0";
 }

$query1 = mysqli_query($koneksi, "SELECT COUNT(*) AS num1 from appointment WHERE tanggal_appointment='$tgl1'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows1 = mysqli_num_rows($query1);
 if ($rows1 <> 0) {
     $dat1=mysqli_fetch_assoc($query1);
     $data1=$dat1['num1'];
 }else{
     $data1="0";
 }
 
 $query2 = mysqli_query($koneksi, "SELECT COUNT(*) AS num2 from appointment WHERE tanggal_appointment='$tgl2'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows2 = mysqli_num_rows($query2);
 if ($rows2 <> 0) {
     $dat2=mysqli_fetch_assoc($query2);
     $data2=$dat2['num2'];
 }else{
     $data2="0";
 }
 $query3 = mysqli_query($koneksi, "SELECT COUNT(*) AS num3 from appointment WHERE tanggal_appointment='$tgl3'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows3 = mysqli_num_rows($query3);
 if ($rows3 <> 0) {
     $dat3=mysqli_fetch_assoc($query3);
     $data3=$dat3['num3'];
 }else{
     $data3="0";
 }
 $query4 = mysqli_query($koneksi, "SELECT COUNT(*) AS num4 from appointment WHERE tanggal_appointment='$tgl4'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows4 = mysqli_num_rows($query4);
 if ($rows4 <> 0) {
     $dat4=mysqli_fetch_assoc($query4);
     $data4=$dat4['num4'];
 }else{
     $data4="0";
 }
 $query5 = mysqli_query($koneksi, "SELECT COUNT(*) AS num5 from appointment WHERE tanggal_appointment='$tgl5'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows5 = mysqli_num_rows($query5);
 if ($rows5 <> 0) {
     $dat5=mysqli_fetch_assoc($query5);
     $data5=$dat5['num5'];
 }else{
     $data5="0";
 }
 $query6 = mysqli_query($koneksi, "SELECT COUNT(*) AS num6 from appointment WHERE tanggal_appointment='$tgl6'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows6 = mysqli_num_rows($query6);
 if ($rows6 <> 0) {
     $dat6=mysqli_fetch_assoc($query6);
     $data6=$dat6['num6'];
 }else{
     $data6="0";
 }
 $query7 = mysqli_query($koneksi, "SELECT COUNT(*) AS num7 from appointment WHERE tanggal_appointment='$tgl7'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows7 = mysqli_num_rows($query7);
 if ($rows7 <> 0) {
     $dat7=mysqli_fetch_assoc($query7);
     $data7=$dat7['num7'];
 }else{
     $data7="0";
 }
 $query8 = mysqli_query($koneksi, "SELECT COUNT(*) AS num8 from appointment WHERE tanggal_appointment='$tgl8'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows8 = mysqli_num_rows($query8);
 if ($rows8 <> 0) {
     $dat8=mysqli_fetch_assoc($query8);
     $data8=$dat8['num8'];
 }else{
     $data8="0";
 }
 $query9 = mysqli_query($koneksi, "SELECT COUNT(*) AS num9 from appointment WHERE tanggal_appointment='$tgl9'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows9 = mysqli_num_rows($query9);
 if ($rows9 <> 0) {
     $dat9=mysqli_fetch_assoc($query9);
     $data9=$dat9['num9'];
 }else{
     $data9="0";
 }
?>
           
<script  type="text/javascript">
  var ctx = document.getElementById("barchart").getContext("2d");
  var data = {
            labels: [<?php 
			  echo "'$tgl0',";
			  echo "'$tgl1',";
			  echo "'$tgl2',";
			  echo "'$tgl3',";
			  echo "'$tgl4',";
			  echo "'$tgl5',";
			  echo "'$tgl6'";
			  ?>],
            datasets: [
            {
              label: "Appointment",
              data: [<?php 
			  echo "'$data0',";
			  echo "'$data1',";
			  echo "'$data2',";
			  echo "'$data3',";
			  echo "'$data4',";
			  echo "'$data5',";
			  echo "'$data6'";
			  ?>],
              backgroundColor: [
                '#32CD32',
                '#32CD32',
                '#32CD32',
                '#32CD32',
                '#32CD32',
                '#32CD32',
                '#32CD32'
              ]
            }
            ]
            };

  var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
            legend: {
              display: false
            },
            barValueSpacing: 20,
            scales: {
              yAxes: [{
                  ticks: {
                      min: 0,
                  }
              }],
              xAxes: [{
                          gridLines: {
                              color: "rgba(0, 0, 0, 0)",
                          }
                      }]
              }
          }
        });
</script>
