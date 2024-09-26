$(document).ready(function() {
	//Button Tambah
	$('#btn_tambah').click(function(){
		$('#img1_output').hide();
		$('#frm').find('input:text, input:password, select, textarea').val('');
		$('#frm').find("input[type='hidden']", $(this)).val('');
        $('#frm').find('input:radio, input:checkbox').prop('checked', false);
		$('.box-userpic').css("background-image", "url("+base_url+'/assets/images/avatars/1.png'+")");
	});
	//DataTable
	var myTable =
	$('#dynamic-table')
	.DataTable({
		"bAutoWidth": false,
		"aaSorting": [],
		"bScrollCollapse": true,
		"stateSave": true,
		"aoColumnDefs": [
			{
				"aTargets":[0],
				"sWidth": "5%",
				"fnCreatedCell": function(c1){
					$(c1).css("text-align", "center");
				}
			},
			{
				"aTargets":[9],
				"fnCreatedCell": function(c1){
					$(c1).css("text-align", "right");
				},
				render: $.fn.dataTable.render.number( ',', '.', 0 )
			},
			{
				"aTargets":[10],
				"fnCreatedCell": function(c1){
					$(c1).css("text-align", "right");
				},
				render: $.fn.dataTable.render.number( ',', '.', 0 )
			},
			{ "bVisible": false, "aTargets": [ 11 ] },
			{ "bVisible": false, "aTargets": [ 13 ] }

		],
		"sAjaxSource": base_url+'admin/c_produk/get_json_data',
		"bPaginate": true,
		select: {
			style: 'single'
		}
	});

	myTable.on('order.dt search.dt', function () {
		myTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	}).draw();

	myTable.on('dblclick', 'tr', function (){
		var data = myTable.row( this ).data();
		//alert(data[3]);
		var s = '1';
		update(s,data[13]);
		$('#modal_add_new').modal('show');
	});

	$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
		new $.fn.dataTable.Buttons( myTable, {
		buttons: [
		  {
			"extend": "colvis",
			"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
			"className": "btn btn-white btn-primary btn-bold",
			columns: ':not(:first):not(:last)'
		  },
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "csv",
			"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "excel",
			"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "pdf",
			"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
			"className": "btn btn-white btn-primary btn-bold",
			autoPrint: false,
			message: 'This print was produced using the Print button for DataTables'
		  }	,
		  {
			"text": "<i class='fa fa-refresh'></i> <span class='hidden'>Refreh</span>",
			"className": "btn btn-white btn-primary btn-bold",
			action: function ( e, dt, node, config ) {
				dt.ajax.reload();
			}
		  }
		]
	} );

	myTable.buttons().container().appendTo( $('.tableTools-container') );

	//style the message box
	var defaultCopyAction = myTable.button(1).action();
	myTable.button(1).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});

	var defaultColvisAction = myTable.button(0).action();
	myTable.button(0).action(function (e, dt, button, config) {
		defaultColvisAction(e, dt, button, config);
		if($('.dt-button-collection > .dropdown-menu').length == 0) {
			$('.dt-button-collection')
			.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
			.find('a').attr('href', '#').wrap("<li />")
		}
		$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
	});
});

function rem(frm,id){
	bootbox.confirm("Anda yakin akan menghapus data ini?", function(result) {
		if(result) {
			window.location.href='c_produk/delete_data/'+frm+'/'+id;
		}
	});
}

$('#btn_save').on('click',function(){
	var id = $('#fld1').val();
	var barcode = $('#fld2').val();
	var name = $('#fld3').val();
	var ukuran = $('#fld4').val();
	var brand = $('#fld5').val();
	var warna = $('#fld6').val();
	var kategori = $('#fld7').val();
	var unit = $('#fld71').val();
	var keterangan = $('#fld72').val();
	var supplier = $('#fld8').val();
	var beli = $('#fld9').val();
	var jual = $('#fld10').val();
	var short_name = $('#fld3').val();
	//console.log(id);
	if(barcode !="" && name !='' && ukuran !='' && brand !='' && warna !='' && kategori !='' && unit !='' && keterangan !='' && supplier !='' && beli !='' && jual !=''){
		$.ajax({
			type : "POST",
			url  : base_url+'admin/c_produk/add_produk',
			dataType : "JSON",
			data : {id:id, barcode:barcode, name:name, ukuran:ukuran, brand:brand, warna:warna, kategori:kategori,
			unit:unit, keterangan:keterangan, supplier:supplier, beli:beli, jual:jual, short_name:short_name},
			success: function(data){
				//console.log(data);
				if(data.status == 'terdaftar'){
					alert('Produk sudah terdaftar..!!');
				}
				var file_data = $('#fld12').prop('files')[0];
				var form_data = new FormData();
				form_data.append('fld12',file_data);
				//console.log($("input[name='fld1']").val())
					$.ajax({
						dataType : "Text",
						url  : base_url+'admin/c_produk/upload_gambar?id='+id,
						cache : false,
						contentType:false,
						processData:false,
						data:form_data,
						type:"POST",
						success: function(response){
							//console.log(response);
							$('#modal_add_new').modal('hide');
							$('#dynamic-table').DataTable().ajax.reload(null, false);
						},
						error: function(response){
							//console.log(response);
						}
					});
			}
		});
		return false;
	}else{
		alert("Lengkapi Form (*)");
	}
});

function update(frm,id){
	$.ajax({
		url: base_url+'admin/c_produk/cari_rec',
		method: 'GET',
		data: {
			id: id,
			frm: frm
		},
		success:function(result) {
			$("input[name='fld1']").val(id);
			//console.log(result);
			var res = JSON.parse(result);
			res.forEach(addFill);
		}
	});
}

function addFill(item, index){
	if(item.fld.substring(0,3) == "img"){
		$(item.fld).load(item.fld);
		$(item.fld).attr('src',item.val);
	} else if(item.fld.substring(0,5) == "table"){
		$(item.fld).html(item.val);
	} else if(item.fld.substring(0,4) == "span"){
		$(item.fld).html(item.val);
	} else if(item.fld.substring(0,1) != ""){
		$(item.fld).val(item.val);
	}
}


function updateImg(input, previewImgId) {
	try {
		if (input.files && input.files[0]) {
			var file = input.files[0];
			var reader = new FileReader();
			reader.onload = function (e) {
				var img = document.getElementById(previewImgId);
				//alert(e.target.result);
				var dataurl = e.target.result;
				dataurl = "data:image/" + file.name.split('.').slice(-1)[0] + ";base64," + dataurl.split(',')[1];
				//alert(dataurl);
				img.src = dataurl;
			};
			reader.readAsDataURL(input.files[0]);
			$('#img1_output').show();
			$('.box-userpic').css("background-image", "none");
		}
	} catch (e) {
		alert(e);
	}
}
