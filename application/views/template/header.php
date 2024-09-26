<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Tukutuku</title>
		<meta name="description" content="USID Tukutuku" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<!-- Select Picker-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/chosen.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-colorpicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/fonts.googleapis.com.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-rtl.min.css" />
		<script src="<?php echo base_url()?>assets/js/ace-extra.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/html5shiv.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/respond.min.js"></script>
		<script type="text/javascript">
			var base_url = "<?php echo base_url();?>";
		</script>
		<style>
			select:required:invalid {
				color: gray;
			}
			option[value=""][disabled] {
				display: none;
			}
			option {
				color: black;
			}
			.box-userpic{
			width: 100%;
			height: 100%;
			//border: 2px solid rgba(0,0,0,.3);
			display: inline-block;
			position: relative;
			background: url('<?php echo base_url()?>assets/images/avatars/1.png') no-repeat;
			background-size: cover;
			float: left;
			margin:0 auto;
			}
			.userpic {
			width: 100%;
			height: 100%;
			//border: 2px solid rgba(0,0,0,.3);
			display: inline-block;
			position: absolute;
			opacity: 0;
			z-index: 2;
			}
		</style>
	</head>
	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>
				<div class="navbar-header pull-left">
					<a href="<?php echo base_url()?>content" class="navbar-brand">
						<small>
							<i class="fa"><img src="<?php echo base_url()?>assets/images/logo.png" style="width:25px;height:25px;"></i>
							Tukutuku
						</small>
					</a>
				</div>
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important" id="j_notif"></span>
							</a>
							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									<span id="j_notif_1"></span> Order Baru
								</li>
								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
										<?php //foreach ($r2 as $row):?>
											<?php 
											/* echo '<li>
													<a href="#">
														<i class="btn btn-xs btn-primary fa fa-user"></i>
														'.$row['order_id'].' - '.$row['payment_method'].'...
													</a>
												</li>'
											; */?>
										<?php //endforeach;?>
									</ul>
								</li>
								<li class="dropdown-footer">
									<a href="<?php echo base_url();?>admin/c_pemesanan">
										Lihat Semua
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo base_url()?>assets/images/avatars/avatar2.png" alt="User's Photo" />
								<span class="user-info">
									<?=strtoupper($this->session->userdata('nama'));?></br>
									<?=$this->session->userdata('office_name');?>
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>
							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>
								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="<?php echo base_url()?>login/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>