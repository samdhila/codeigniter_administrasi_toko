<!-- basic scripts -->
		<!--[if !IE]> -->
		<script src="<?php echo base_url()?>assets/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
		
		<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/bootbox.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.easypiechart.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/spin.js"></script>
		<!-- ace scripts -->
		<script src="<?php echo base_url()?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/ace.min.js"></script>
	</body>
</html>

<?php echo $data_js; ?>