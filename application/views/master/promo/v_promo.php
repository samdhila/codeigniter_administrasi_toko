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
					<h3 class="header smaller lighter blue"><?php echo $title;?></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
				<!--PEMBATAS-->

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
                                        <th>Nama Promo</th>
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

				<!--PEMBATAS-->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_add_new" tabindex="-1"  role="dialog" aria-labelledby="largeModal" aria-hidden="true">
<div class="modal-dialog" style="width:70%;">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<h3 class="modal-title" id="myModalLabel">Master Promo</h3>
	</br><?php //echo $this->session->userdata('user_id');?>

</div>
<?php //echo form_open_multipart('', 'class="form-horizontal" id="frm_promo"'); ?>
	<form id="frm" class="form-horizontal">
	<div class="modal-body">
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-6">
					<div class="form-group">
						<label class="control-label col-xs-4" >Nama Promo</label>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash()?>" />
						<input type="hidden" name="fld1" id="fld1" class="form-control text-uppercase" />
						<div class="col-xs-8">
							<textarea name="fld2" id="fld2" class="form-control" type="text" placeholder="Nama Promo..." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-4" >Type Diskon</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld3" id="fld3" style="width:200px;" required/>
							<option value="">Please Select</option>
						<?php
							$options3 = array(
								"Persentase"	=> "Percentage",
								"FreeItem"		=> "FreeItem",
								"Nominal"		=> "Nominal"
							);
							foreach ($options3 as $diskon => $val){
							?>
								<option value="<?php echo $val;?>"> <?php echo $diskon;?></option>
						<?php
							}
						?>
						</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-4" >Syarat Promo</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld4" id="fld4" style="width:200px;" required/>
							<option value="">Please Select</option>
							<?php
								$options4 = array(
									"Quantity"	=> "QuantityItem",
									"Total Belanja"		=> "TotalShopping",
								);
								foreach ($options4 as $syarat => $val){
								?>
									<option value="<?php echo $val;?>"> <?php echo $syarat;?></option>
							<?php
								}
							?>
						</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-4" >Size Gambar</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld5" id="fld5" style="width:200px;" required/>
							<option value="">Please Select</option>
						<?php
							$options5 = array(
								"Besar"	=> "Size366x500",
								"Kecil"	=> "Size220x250"
							);
							foreach ($options5 as $ukuran => $val){
							?>
								<option value="<?php echo $val;?>"> <?php echo $ukuran;?> ( <?php echo $val;?> ) </option>
						<?php
							}
						?>
						</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-4" >Kategori</label>
						<div class="col-xs-8">
						<select class="form-control" name="fld6" id="fld6" style="width:200px;" required/>
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
							<input type="checkbox" name="fld7" id="fld7" class="form-check-input"/>
						</div>
					</div>

				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label class="control-label col-xs-4" >Mulai Promo</label>
						<div class="col-xs-8">
							<div class='input-group date' id='datetimepicker1' style="width:160px;">
								<input type='text' name="fld8" id="fld8" class="form-control"  placeholder="Mulai Promo..." required/>
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
								<input type='text' name="fld9" id="fld9" class="form-control" placeholder="Akhir Promo..." required/>
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
							<input name="fld10" id="fld10" style="width:160px;" class="form-control" type="text" placeholder="Diskon..." required/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" id="label_syarat">Qty / Total Belanja</label>
						<div class="col-xs-8">
							<input name="fld11" id="fld11" style="width:160px;" class="form-control" type="text" placeholder="Qty..." required/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-4" >Diskon / item</label>
						<div class="col-xs-8">
							<input type="checkbox" name="fld12" id="fld12" class="form-check-input">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" >Kelipatan</label>
						<div class="col-xs-8">
							<input type="checkbox" name="if_kelipatan" id="if_kelipatan" class="form-check-input">
							<span style="display:inline-block;">
								<input name="fld13" id="fld13" style="width:120px;" class="form-control" type="text" placeholder="Max Kelipatan" disabled>
							</span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3" >Gambar Promo</label>
                        <div class="col-xs-8">
								<div class="box-userpic" style="width:200px; height:200px;">
									<input class="userpic" accept="image/*" name="fld14" id="fld14" type="file" onchange="updateImg(this, 'img1_output')">
									<img id="img1_output" class="img1-output img-responsive" style="width:100%; height:100%;">
								</div></br>
								<center>Format Gambar .jpg</center>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--TABBABLE-->
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
		<!--TABBABLE-->
	</div>
	</form>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
		<button class="btn btn-info" id="btn_save_promo">Simpan</button>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="modal_add_item" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
<div class="modal-dialog" style="width:40%;">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="modal-title" id="myModalLabel2">Master Produk</h3>
</div>
    <form id="frm_add_item" class="form-horizontal">
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group" style="margin-left:10px;">
                    <span class="btn btn-info" id="reset-item-selected">Reset</span>
                </div>
                <table id="table-add-item" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">
                        <tr class="odd gradeX">
                            <td style="width:10px"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </form>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
        <button class="btn btn-info" id="btn-apply-add-item">Apply</button>
    </div>
</div>
</div>
</div>
