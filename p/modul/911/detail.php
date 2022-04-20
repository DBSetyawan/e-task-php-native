<?php
ob_start ("ob_gzhandler");
?>

<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist.min.css">
<link rel="stylesheet" href="../assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
<link rel="stylesheet" href="../assets/vendor/summernote/dist/summernote.css"/>
<link rel="stylesheet" href="../assets/vendor/dropify/css/dropify.min.css">

<?php
error_reporting(0);
session_start();
include("../../../config/koneksi.php");
$aksi="modul/actlog/act_log.php";
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysql_query("SELECT * FROM tproblemnote WHERE idnote = $id");
        while ($r = mysql_fetch_array($sql)){
		echo "
        <form class='row clearfix' method='POST' action='$aksi?p=new-post&act=problem-note-edit&id=$_GET[id]'>
		<input type='hidden' name='idnote' value='$r[idnote]'>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
								<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
								<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
								<input type='hidden' class='form-control' name='idprob' value = '$r[idprob]' readonly='readonly'>
                            </div>
                        </div>
                        <div class='col-sm-12'>
                            <div class='form-group'>
                                <textarea class='summernote' name='note' >$r[note]</textarea>
                            </div>
                        </div> 
                </div>      
            </div>
			<table width='100%'>
			<tr><td>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Update</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>  </td></tr></table>                             
                    </form>
    </div>";
								   
        } }
		?>
<!-- Javascript -->
<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/vendor/toastr/toastr.js"></script>
<script src="assets/bundles/chartist.bundle.js"></script>


<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/js/index.js"></script>
<script src="../assets/vendor/summernote/dist/summernote.js"></script>
<script src="../assets/vendor/dropify/js/dropify.min.js"></script>
<script src="assets/js/pages/forms/dropify.js"></script>


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
<script>
    $(function() {
        // validation needs name of the element
        $('#food').multiselect();

        // initialize after multiselect
        $('#basic-form').parsley();
    });
    </script>