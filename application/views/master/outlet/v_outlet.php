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
								<th style="text-align:center;">No</th>
								<th>Nama Kantor</th>
								<th>Alamat</th>
								<th>HP / Telepon</th>
								<th>Kota / Kabupaten</th>
								<th>Provinsi</th>
								<th>Area</th>
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

			<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog" style="width:75%;">
            <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 class="modal-title" id="myModalLabel">Master <?php echo $title;?></h3>
			</div>
			<form class="form-horizontal" id="frm">
                <div class="modal-body">
					<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label class="control-label col-xs-3" >Nama Outlet</label>
							<div class="col-xs-8">
								<input type="hidden" name="fld1" id="fld1" class="form-control text-uppercase" value="">
								<input name="fld2" id="fld2" class="form-control" type="text" placeholder="Nama..." required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3" >Alamat</label>
							<div class="col-xs-8">
								<textarea name="fld3" id="fld3" class="form-control" placeholder="Alamat"></textarea>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-xs-3" >Area</label>
								<div class="col-xs-8" >
									<?php
										$q = $this->db->query("SELECT id,name FROM area ORDER BY name");
										$r2 = $q->result_array();
										$option = $r2;
										foreach ($r2 as $row){
											$options4[$row['id']] = $row['name'];
										}
										echo form_dropdown('fld4',$options4,'','id="fld4"');
										?>
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3" >Provinsi</label>
							<div class="col-xs-8">
								<?php
									$q = $this->db->query("SELECT id,name FROM province ORDER BY name");
									$r2 = $q->result_array();
									$option = $r2;
									foreach ($r2 as $row){
										$options5[$row['id']] = $row['name'];
									}
									echo form_dropdown('fld5',$options5,'','id="fld5"');
									?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3" >Kota</label>
							<div class="col-xs-8">
								<?php
									$q = $this->db->query("SELECT id,name FROM city ORDER BY id");
									$r2 = $q->result_array();
									$option = $r2;
									foreach ($r2 as $row){
										$options6[$row['id']] = $row['name'];
									}
									echo form_dropdown('fld6',$options6,'','id="fld6"');
									?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3" >Kode Pos</label>
							<div class="col-xs-8">
								<input name="fld7" id="fld7" class="form-control" type="text" placeholder="Kode Pos..." required>
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label class="control-label col-xs-3" >Telepon</label>
							<div class="col-xs-8">
								<input name="fld8" id="fld8" class="form-control" type="text" placeholder="Telepon..." required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3" >Latitude</label>
							<div class="col-xs-8">
								<input name="fld9" id="fld9" class="form-control" type="text" placeholder="Latitude..." required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3" >longitude</label>
							<div class="col-xs-8">
								<input name="fld10" id="fld10" class="form-control" type="text" placeholder="longitude..." required>
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

		</div>
	</div>
</div>
