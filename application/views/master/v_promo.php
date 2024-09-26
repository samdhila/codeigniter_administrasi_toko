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
					<h3 class="header smaller lighter blue">Promo</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="clearfix">
						<button class="btn btn-white btn-info btn-bold" data-toggle="modal" data-target="#modal_add_new" id="btn_tambah">
							<i class="ace-icon fa fa-pencil-square-o bigger-120 blue"></i>
							Tambah
						</button>
						<div class="pull-right tableTools-container"></div>
					</div>
					<br>
					<div class="table-header">
						Results for "Promo"
					</div>
					<div>
						<table id="promo-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th style="text-align:center;">No</th>
									<th style="width:30%;">Nama Promo</th>
									<th style="text-align:center;">Mulai</th>
									<th style="text-align:center;">Sampai</th>
									<th style="text-align:center;">Qty</th>
									<th>Type</th>
									<th>Kategori Produk</th>
									<th style="text-align:center;">Aksi</th>
								</tr>
							</thead>

							<tbody style="cursor: pointer;">
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
<div class="modal-dialog" style="width:80%;">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h3 class="modal-title" id="myModalLabel">Master Promo</h3>
	</br>	
</div>
	<form id="frm_promo" class="form-horizontal" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-4">
					<div class="form-group">
						<label class="control-label col-xs-4" >Nama Promo</label>
						<input type="hidden" name="ci_csrf_token" value="" />
						<input type="hidden" name="fld1" class="form-control text-uppercase" value="">
						<div class="col-xs-8">
							<textarea name="fld2" id="fld2" class="form-control" type="text" placeholder="Nama Promo..." required></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-xs-4" >Type Diskon</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld3" id="fld3" style="width:200px;" required/>
							<option value="">Please Select</option>
														<option value="Percentage"> Persentase</option>
														<option value="FreeItem"> FreeItem</option>
														<option value="Nominal"> Nominal</option>
							
						</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-xs-4" >Syarat Promo</label>
						<div class="col-xs-8">
						<select class="form-control" name="syarat_promo" id="syarat_promo" style="width:200px;" required/>
							<option value="">Please Select</option>
							<option value="QuantityItem">Quantity</option>
							<option value="TotalShopping">Total Belanja</option>
						</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-xs-4" >Size Gambar</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld6" id="ukuran" style="width:200px;" required/>
							<option value="">Please Select</option>
														<option value="Size366x500"> Besar ( Size366x500 ) </option>
														<option value="Size220x250"> Kecil ( Size220x250 ) </option>
							
						</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-4" >Kategori</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld7" id="kategori" style="width:200px;" required/>
							<option value="">Please Select</option>
													<?php
							$q = $this->db->query("SELECT id,name FROM productcategory ORDER BY name");
							$r2 = $q->result_array();
							foreach ($r2 as $row){
						?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
						<?php
							}
						?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" >All Produk</label>
						<div class="col-xs-8">
							<input type="checkbox" name="all_produk" class="form-check-input" id="all_produk">
						</div>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label class="control-label col-xs-4" >Mulai Promo</label>
						<div class="col-xs-8">
							<div class='input-group date' id='datetimepicker1' style="width:160px;">
								<input type='text' name="fld4" class="form-control"  placeholder="Mulai Promo..." required/>
								<span class="input-group-addon">
									<span class="fa fa-calendar">
									</span>
								</span>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-xs-4" >Akhir Promo</label>
						<div class="col-xs-8">
							<div class='input-group date' id='datetimepicker2' style="width:160px;">
								<input type='text' name="fld5" class="form-control" placeholder="Akhir Promo..." required/>
								<span class="input-group-addon">
									<span class="fa fa-calendar">
									</span>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" id="label_type">Diskon</label>
						<div class="col-xs-8">
							<input name="fld9" style="width:160px;" class="form-control" type="text" placeholder="Diskon..." required/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" id="label_syarat">Qty / Total Belanja</label>
						<div class="col-xs-8">
							<input name="fld8" style="width:160px;" class="form-control" type="text" placeholder="Qty..." required/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-xs-4" >Diskon / item</label>
						<div class="col-xs-8">
							<input type="checkbox" name="diskon_item" class="form-check-input" id="diskon_item">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" >Kelipatan</label>
						<div class="col-xs-8">
							<input type="checkbox" name="kelipatan" class="form-check-input" id="kelipatan">
							<span style="display:inline-block;">
								<input name="max_kelipatan" style="width:120px;" class="form-control" type="text" placeholder="Max Kelipatan" id="max_kelipatan" disabled>
							</span>
						</div>
					</div>
					
				</div>
				
				<div class="col-xs-4">
					<div class="form-group">
						<label class="control-label col-xs-4" >Gambar Promo</label>
                        <div class="col-xs-8">
							<div class="box-userpic" style="width:200px; height:200px;">
								<input class="userpic" accept="image/*" name="fld15" id="fld15" type="file" onchange="updateImg(this,'img1_output')">
								<img id="img1_output" class="img1-output img-responsive" style="width:100%; height:100%;">
							</div></br>
							<center>Format Gambar .jpg</center>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<div class="tabbable">
					<ul class="nav nav-tabs" id="myTab">
						<li class="active">
							<a data-toggle="tab" href="#home" aria-expanded="false">
								Items Promo
							</a>
						</li>

						<li class="">
							<a data-toggle="tab" href="#bonus" aria-expanded="true">
								Items Bonus
							</a>
						</li>
					</ul>

					<div class="tab-content">
						<div id="home" class="tab-pane fade active in">
							<div class="form-group" style="margin-left:10px;">
								<span class="btn btn-info" id="add-item">Add Items</span>
							</div>
							<table id="promo-produk" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th style="text-align:center;">No</th>
										<th>ID.Produk</th>
										<th>Nama</th>
										<th>Type Diskon</th>
										<th>Qty</th>
										<th>Diskon</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr class="odd gradeX" id="r0">
										<td style="width:10px"></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td hidden></td>
										<td style="width:20px"><a class="delete" href="">Delete</a></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div id="bonus" class="tab-pane fade">
							<div class="form-group" style="margin-left:10px;">
								<span class="btn btn-info" id="add-bonus">Add Bonus</span>
							</div>
							<table id="bonus-produk" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th style="text-align:center;">No</th>
										<th>ID.Produk</th>
										<th>Nama</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr class="odd gradeX" id="rb0">
										<td style="width:10px"></td>
										<td></td>
										<td></td>
										<td hidden></td>
										<td style="width:20px"><a class="delete" href="">Delete</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
		<button class="btn btn-info" id="simpan">Simpan</button>
	</div>
</div>
</div>
</div>