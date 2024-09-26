<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<li class="active">Dashboard</li>
				</li>
			</ul><!-- /.breadcrumb -->			
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Monitoring Pemesanan</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="btn-group btn-group-justified">
						<a href="<?php echo base_url();?>admin/c_pemesanan" class="btn btn-warning">Open</a>
						<a href="<?php echo base_url();?>admin/c_pemesanan_2" class="btn btn-success">Shipped</a>
						<a href="<?php echo base_url();?>admin/c_pemesanan_3" class="btn btn-primary">Done</a>
					</div>
				</div>
			</div><br>

			<div class="clearfix">
				<div class="pull-right tableTools-container"></div>
			</div>
			<div class="table-header">
				Results for "Monitoring Pemesanan"
			</div>
			<div>
				<table id="table_pemesanan" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">No</th>
							<th>Id Pemesanan</th>
							<th>Tanggal</th>
							<th>Pelanggan</th>
							<th width="100px">Metode</th>
							<th width="100px">Status</th>
							<th width="100px">Diskon</th>
							<th width="120px">Total Pemesanan</th>
							<th width="100px" style="text-align:center;">Aksi</th>
						</tr>
					</thead>
					<tbody style="cursor: pointer;">
						<tr>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
											
			<!-- Modal -->	
			<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog" style="width:75%;">
				<div class="modal-content">
				<div class="modal-header">
					<!--<button type="button" class="close" id="close_modal1" data-dismiss="modal" aria-hidden="true">x</button>-->
					<h3 class="modal-title" id="myModalLabel">Konfirmasi Pemesanan</h3>
				</div>
				<form id="frmpemesanan" class="form-horizontal" method="post" action="<?php echo base_url();?>admin/c_pemesanan/update_pemesanan_shipped">
					<div class="modal-body">
						<div class="col-xs-6">
							<div class="form-group">
								<label class="control-label col-xs-3" >Nama Pemesan</label>
								<div class="col-xs-8">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash()?>" />
									<input type="hidden" name="fld1" class="form-control text-uppercase" value="">
									<input name="fld2" class="form-control text-uppercase" type="text" placeholder="Nama..." required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" >Nama Penerima</label>
								<div class="col-xs-8">
									<input name="fld3" class="form-control" placeholder="Nama Penerima">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" >Alamat Penerima</label>
								<div class="col-xs-8">
									<textarea name="fld4" class="form-control" placeholder="Alamat"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" >No.telepon</label>
								<div class="col-xs-8">
									<input name="fld5" class="form-control" placeholder="no.telp">
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label class="control-label col-xs-3" >Note</label>
								<div class="col-xs-8">
									<textarea name="fld6" class="form-control" placeholder="Note"></textarea>
								</div>
							</div>
							<div class="col-sm-5 pull-right">
								<h4 class="pull-right">
									ID.Pemesanan :
									<span class="red" id="fld7"></span>
								</h4>
							</div>
						</div>
						<table id="child-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Barang</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Diskon</th>
									<th>Total</th>
								</tr>
							</thead>

							<tbody>
								<tr class="item-control">
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" id="btn_tutup" aria-hidden="true">Tutup</button>
					<button class="btn btn-success" id="cetak_pemesanan" data-toggle="modal" href="#modal_print_preview">Cetak</button>
					<button class="btn btn-info" id="Proses" onclick="$('#frmpemesanan').closest('form').submit();">Proses</button>
				</div>
				</div>
				</div>
			</div>
			
			
			<!-- Modal Pemesanan Shipped-->	
			<div class="modal fade" id="modal_add_new_sp" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog" style="width:75%;">
				<div class="modal-content">
				<div class="modal-header">
					<!--<button type="button" class="close" id="close_modal1" data-dismiss="modal" aria-hidden="true">x</button>-->
					<h3 class="modal-title" id="myModalLabel">Konfirmasi Pemesanan</h3>
				</div>
				<form id="frmpemesanan_sp" class="form-horizontal" method="post" action="<?php echo base_url();?>admin/c_pemesanan/update_pemesanan_done">
					<div class="modal-body">
						<div class="col-xs-6">
							<div class="form-group">
								<label class="control-label col-xs-3" >Nama Pemesan</label>
								<div class="col-xs-8">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash()?>" />
									<input type="hidden" name="fld1" class="form-control text-uppercase" value="">
									<input name="fld2" class="form-control text-uppercase" type="text" placeholder="Nama..." required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" >Nama Penerima</label>
								<div class="col-xs-8">
									<input name="fld3" class="form-control" placeholder="Nama Penerima">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" >Alamat Penerima</label>
								<div class="col-xs-8">
									<textarea name="fld4" class="form-control" placeholder="Alamat"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" >No.telepon</label>
								<div class="col-xs-8">
									<input name="fld5" class="form-control" placeholder="no.telp">
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label class="control-label col-xs-3" >Note</label>
								<div class="col-xs-8">
									<textarea name="fld6" class="form-control" placeholder="Note"></textarea>
								</div>
							</div>
							<div class="col-sm-5 pull-right">
								<h4 class="pull-right">
									ID.Pemesanan :
									<span class="red" id="fld7"></span>
								</h4>
							</div>
						</div>
						<table id="child-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Barang</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Diskon</th>
									<th>Total</th>
								</tr>
							</thead>

							<tbody>
								<tr class="item-control">
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" id="btn_tutup" aria-hidden="true">Tutup</button>
					<button class="btn btn-success" id="cetak_pemesanan" data-toggle="modal" href="#modal_print_preview">Cetak</button>
					<button class="btn btn-info" id="Done" onclick="$('#frmpemesanan_sp').closest('form').submit();">Done</button>
				</div>
				</div>
				</div>
			</div>
			
			
			<!-- Modal Print-->
			<div class="modal fade" id="modal_print_preview" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
				<div class="modal-dialog" style="width:90%;">
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 class="modal-title" id="myModalLabel">Print Preview</h3>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<div class="space-6"></div>
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								<div class="widget-box transparent">
									<div class="widget-header widget-header-large">
										<h3 class="widget-title grey lighter">
											<i class="ace-icon fa"><img src="<?php echo base_url()?>assets/images/logo.png" style="width:25px;height:25px;"></i>
											Customer Invoice
										</h3>

										<div class="widget-toolbar no-border invoice-info">
											<span class="invoice-info-label">Invoice:</span>
											<span class="red">#<span id="fld7"></span></span>

											<br />
											<span class="invoice-info-label">Date:</span>
											<span class="blue"><?=Date('d-M-Y');?></span>
										</div>

										<div class="widget-toolbar hidden-480">
											<a href="#" id="print_server">
												<i class="ace-icon fa fa-print"> Print Server</i>
											</a>
										</div>
										<div class="widget-toolbar hidden-480">
											<a href="#" onclick="window.print();">
												<i class="ace-icon fa fa-print"> Print</i>
											</a>
										</div>
									</div>

									<div class="widget-body">
										<div class="widget-main padding-24">
											<div class="row">
												<div class="col-sm-6">
													<div class="row">
														<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
															<b>Informasi Outlet</b>
														</div>
													</div>

													<div style="width:450px;">
														<ul class="list-unstyled spaced">
															<li>
																<i class="ace-icon fa fa-caret-right blue"></i>Tukutuku.com
															</li>

															<li style="display: flex; justify-content: space-around;">
																<i class="ace-icon fa fa-caret-right blue"></i>Asem Kandang, Kraton, Pasuruan, Jawa Timur, Indonesia , Pasuruan Jawa Timur 68175
															</li>

															<li>
																<i class="ace-icon fa fa-caret-right blue"></i>0343-9383377
															</li>

															<li class="divider"></li>

															<li>
																<i class="ace-icon fa fa-caret-right blue"></i>
																<b>Informasi Tagihan</b>
															</li>
														</ul>
													</div>
												</div><!-- /.col -->

												<div class="col-sm-6">
													<div class="row">
														<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
															<b>Informasi Pelanggan</b>
														</div>
													</div>

													<div style="width:450px;">
														<ul class="list-unstyled  spaced">
															<li>
																<i class="ace-icon fa fa-caret-right green"></i><span id="fld2"></span> / <span id="fld3"></span>
															</li>

															<li style="display: flex; width:450px;">
																<i class="ace-icon fa fa-caret-right green"></i><span id="fld4"></span>
															</li>

															<li>
																<i class="ace-icon fa fa-caret-right green"></i><span id="fld5"></span>
															</li>
														</ul>
													</div>
												</div><!-- /.col -->
											</div><!-- /.row -->

											<div class="space"></div>

											<div>
												<table id="child-table" class="table table-striped table-bordered">
													<thead>
														<tr>
															<th class="center">#</th>
															<th>Product</th>
															<th class="hidden-xs">Description</th>
															<th class="hidden-480">Discount</th>
															<th>Total</th>
														</tr>
													</thead>

													<tbody>
														<tr class="item-control">
															<td></td>
														</tr>
													</tbody>
												</table>
											</div>

											<div class="hr hr8 hr-double hr-dotted"></div>

											<div class="row">
												<div class="col-sm-7 pull-left"> Catatan </div>
											</div>

											<div class="space-6"></div>
											<div class="well">
												Terima Kasih telah berbelanja di Tukutuku.
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- PAGE CONTENT ENDS -->
					</div>
				</div>
				</div>
				</div>
				</div>

				<!-- End Modal Print -->
			
			
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->