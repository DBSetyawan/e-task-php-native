<link rel="stylesheet" href="../assets/vendor/summernote/dist/summernote.css"/>
<?php
error_reporting(0);
session_start();
include("../../../config/koneksi.php");
$aksi="modul/911/act_911.php";
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysql_query("SELECT * FROM tlaporan WHERE no_pelaporan = '$id'");
        while ($r = mysql_fetch_array($sql)){
		echo "
        <form class='row clearfix' method='POST' action='$aksi?p=todolist&act=finished'>
			<input type='hidden' name='idprob' value='$r[NO_PELAPORAN]'>
            <div class='col-sm-12'>
				<textarea class='summernote' name='action' ></textarea>
            </div>
			<table width='100%'>
				<tr>
					<td>
						<div class='modal-footer'>
							<button type='submit' class='btn btn-primary' >SAVE</button>
						</div>  
					</td>
				</tr>
			</table>                             
        </form>";
								   
        } }
		?>
		<script src="../assets/vendor/summernote/dist/summernote.js"></script>
		<script>
    jQuery(document).ready(function() {

        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false, // set focus to editable area after initializing summernote
            popover: { image: [], link: [], air: [] }
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        
    window.save = function() {
        $(".click2edit").summernote('destroy');
    }
</script>