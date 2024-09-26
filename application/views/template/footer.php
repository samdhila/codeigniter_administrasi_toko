<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<span class="blue bolder">Tukutuku</span>
				&copy; 2017
			</span>

			&nbsp; &nbsp;
		</div>
	</div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
	<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>

</div><!-- /.main-container -->
<!--[if !IE]> -->
<script src="<?php echo base_url()?>assets/js/jquery-2.1.4.min.js"></script>

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>


<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>assets/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url()?>assets/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>assets/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>assets/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url()?>assets/js/dataTables.select.min.js"></script>
<script src="<?php echo base_url()?>assets/js/dataTables.fixedColumns.min.js"></script>

<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url()?>assets/js/chosen.jquery.min.js"></script>

<script src="<?php echo base_url()?>assets/js/spinbox.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/js/daterangepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.knob.min.js"></script>
<script src="<?php echo base_url()?>assets/js/autosize.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.inputlimiter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-tag.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootbox.js"></script>
<!-- ace scripts -->
<script src="<?php echo base_url()?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url()?>assets/js/ace.min.js"></script>
<!-- Print Server-->
<script src="<?php echo base_url()?>assets/js_data/print.js"></script>

	</body>
</html>
<?php echo $data_js; ?>
<script>
cek_notif();
//Notifikasi Pemesanan
function cek_notif(){
	$.ajax({
		type: "GET",
		url: base_url+'index.php/admin/c_pemesanan/cek_notif',
		cache: false,
		dataType: "json",
		success: function(msg){
			//console.log(msg);
			$("#j_notif").html(msg);
			$("#j_notif_1").html(msg.jm_notif);
		}
	});
	var waktu = setTimeout("cek_notif()",5000);
}
</script>

