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
			<div class="clearfix">
				<button class="btn btn-white btn-info btn-bold" data-toggle="modal" data-target="#modal_add_new" id="btn_tambah">
					<i class="ace-icon fa fa-pencil-square-o bigger-120 blue"></i>
					Tambah
				</button>
				<div class="pull-right tableTools-container"></div>
			</div>
			<div class="table-header">
				Results for "<?php echo $title;?>"
			</div>
			<div class="row">
				<div class="col-xs-12">
				<table id="dynamic-table" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>BarCode</th>
							<th>Nama Barang</th>
							<th>Ukuran</th>
							<th>Brand</th>
							<th>Warna</th>
							<th>Kategori</th>
							<th>Supplier</th>
							<th>Unit</th>
							<th>Harga Beli</th>
							<th>Harga Jual</th>
							<th>Keterangan</th>
							<th>Aksi</th>
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
			
			
			<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog" style="width:75%;">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 class="modal-title" id="myModalLabel">Master Barang</h3>
            </div>
			<form class="form-horizontal" id="frm" enctype="multipart/form-data">
                <div class="modal-body">
				<div class="row">
				<div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Barcode</label>
                        <div class="col-xs-8">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash()?>" />
							<input type="hidden" name="fld1" id="fld1" class="form-control text-uppercase">
                            <input name="fld2" id="fld2" class="form-control text-uppercase" type="text" placeholder="BarCode..." required>
                        </div>
                    </div>
 
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Nama Barang</label>
                        <div class="col-xs-8">
                            <input name="fld3" id="fld3" class="form-control" type="text" placeholder="Nama Barang..." required>
                        </div>
                    </div>
 
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Ukuran</label>
                        <div class="col-xs-8">
                            <input name="fld4" id="fld4" class="form-control" type="text" placeholder="ukuran..." required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Brand</label>
                        <div class="col-xs-8">
						<?php							
							$q = $this->db->query("SELECT id,name FROM brand ORDER BY name");
							$r2 = $q->result_array();
							//$option = $r2;
							foreach ($r2 as $row){
								$options5[$row['id']] = $row['name'];
							}
							echo form_dropdown('fld5',$options5,'','id="fld5"');
						?>						
                        </div>
                    </div>
 
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Warna</label>
                        <div class="col-xs-8">
						<?php							
							$q = $this->db->query("SELECT id,name FROM color ORDER BY name");
							$r2 = $q->result_array();
							//$option = $r2;
							foreach ($r2 as $row){
								$options6[$row['id']] = $row['name'];
							}
							echo form_dropdown('fld6',$options6,'','id="fld6"');
						?>						
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Kategori</label>
                        <div class="col-xs-8">
						<?php							
							$q = $this->db->query("SELECT id,name FROM productcategory ORDER BY name");
							$r2 = $q->result_array();
							//$option = $r2;
							foreach ($r2 as $row){
								$options7[$row['id']] = $row['name'];
							}
							echo form_dropdown('fld7',$options7,'','id="fld7"');
						?>						
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Unit</label>
                        <div class="col-xs-8">
						<?php							
							$q = $this->db->query("SELECT id,name FROM unit ORDER BY name");
							$r2 = $q->result_array();
							//$option = $r2;
							foreach ($r2 as $row){
								$options71[$row['id']] = $row['name'];
							}
							echo form_dropdown('fld71',$options71,'','id="fld71"');
						?>						
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Keterangan</label>
                        <div class="col-xs-8">
							<textarea name="fld72" id="fld72" class="form-control" id="form-field-8" placeholder="Keterangan Produk"></textarea>
						</div>
                    </div>
				</div>
				
				<div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Supplier</label>
                        <div class="col-xs-8">
						<?php							
							$q = $this->db->query("SELECT id,name FROM supplier ORDER BY name");
							$r2 = $q->result_array();
							//$option = $r2;
							foreach ($r2 as $row){
								$options8[$row['id']] = $row['name'];
							}
							echo form_dropdown('fld8',$options8,'','id="fld8"');
						?>						
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Harga Beli</label>
                        <div class="col-xs-8">
                            <input name="fld9" id="fld9" class="form-control" type="text" placeholder="Harga..." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Harga Jual</label>
                        <div class="col-xs-8">
                            <input name="fld10" id="fld10" class="form-control" type="text" placeholder="Harga..." required>
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label col-xs-3" >Gambar Produk</label>
                        <div class="col-xs-8">
								<div class="box-userpic" style="width:333px; height:327px;">
									<input class="userpic" accept="image/*" name="fld12" id="fld12" type="file" onchange="updateImg(this, 'img1_output')">
									<img id="img1_output" class="img1-output img-responsive" style="width:100%; height:100%;">
								</div>
						</div>
					</div>
				</div>
                </div>
				</div>
 
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_save">Simpan</button>
                </div>
            </form>
            </div>
			</div>
			</div>
			
											
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->