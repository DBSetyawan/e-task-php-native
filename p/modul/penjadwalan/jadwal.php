<?php
$date = date('Y-m-d');
$month = date('m');
error_reporting(0);
session_start();
?>
<div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href='javascript:void(0);' class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Penjadwalan Pekerjaan</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="?p=planning"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Penjadwalan Pekerjaan</li>
                        </ul>
                    </div>      
                </div>
            </div>

            <div class="row clearfix">
			
			<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<iframe src="modul/penjadwalan/index.php" style="position:sticky; top:20%; left:5%; bottom:10%; right:10%; width:100%; height:950px; border:none; margin:0; padding:0; overflow:hidden;"></iframe>   
			</div>
                
            </div>            
            </div>

  <script src="modul/911/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#reject').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/rejectproblem.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
                      