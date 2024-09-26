$(document).ready(function() {
	ck1 = '';
	ck2 = '';
	ck3 = '';
	id_img = '';
	$('#datetimepicker1').datetimepicker({
		icons: {
			time: "fa fa-clock-o",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
		},
		format: 'DD-MM-YYYY HH:mm',
		showTodayButton:true
	});
	$('#datetimepicker2').datetimepicker({
		icons: {
			time: "fa fa-clock-o",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
		},
		format: 'DD-MM-YYYY HH:mm',
		showTodayButton:true
	});

	//Button Tambah
	$('#btn_tambah').click(function(){
		$('#img1_output').hide();
		$('#frm').find('input:text, input:password, select, textarea').val('');
		$('#frm').find("input[type='hidden']", $(this)).val('');
		$('#frm').find('input:radio, input:checkbox').prop('checked', false);
		$('.box-userpic').css("background-image", "url("+base_url+'/assets/images/avatars/1.png'+")");

		$.ajax({
			dataType : "json",
			url  : base_url+'admin/c_promo/get_id',
			type:"GET",
			success: function(data){
				console.log(data.id);
					$("input[name='fld1']").val(data.id);
			},
			error: function(response){
				//console.log(response);
			}
		});
	});
	// $('#modal_add_new').on('shown.bs.modal', function () {
	// 	$('#fld7').click(function(){
	// 	if($(this).is(':checked')){
	// 		ck1 = '1';
	// 	}else{
	// 		ck1 = '0';
	// 	}
	// });
	// $('#fld12').click(function(){
	// 	if($(this).is(':checked')){
	// 		ck1 = '1';
	// 	}else{
	// 		ck1 = '0';
	// 	}
	// });
	//
	// 	// $('#if_kelipatan').click(function(){
	// 	// 	if($(this).is(':checked')){
	// 	// 		$("#fld13").prop('disabled', false);
	// 	// 		$("#fld13").prop('required', true);
	// 	// 		ck3 = '1';
	// 	// 	}else{
	// 	// 		$("#fld13").prop('disabled', true);
	// 	// 		$("#fld13").prop('required', false);
	// 	// 		$("#fld13").val('');
	// 	// 		ck3 = null;
	// 	// 	}
	// 	// });
	// });

	//DataTable
	var myTable =
	$('#promo-table')
	.DataTable({
		"bAutoWidth": false,
		"aaSorting": [],
		"bScrollCollapse": true,
		"stateSave": true,
		"aoColumnDefs": [
			{
				"aTargets":[4],
				"fnCreatedCell": function(c1){
					$(c1).css("text-align", "right");
				},
				render: $.fn.dataTable.render.number( ',', '.', 0 )
			},
			{ "bVisible": false, "aTargets": [ 8 ] }

		],
		"sAjaxSource": base_url+'admin/c_promo/get_json_data',
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
		update(s,data[8]);
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
			window.location.href='c_promo/delete_data/'+frm+'/'+id;
		}
	});
}

$('#btn_save_promo').on('click',function(){
	if($('#fld7').is(':checked')){
			ck1 = '1';
		}else{
			ck1 = '0';
		}
		if($('#fld12').is(':checked')){
			ck2 = '1';
		}else{
			ck2 = '0';
		}
		if($('#if_kelipatan').is(':checked')){
			ck3 = '1';
		}else{
			ck3 = '0';
		}
		var ary_item = [];
		var ary_bonus = [];
		var ary_promo = [];

		ary_promo.push({
			fld1 : $("input[name='fld1']").val(), //id
			fld2 : $("textarea[name='fld2']").val(), //nama promo
			fld3 : $("select[name='fld3']").val(), //tipe diskon
			fld4 : $("select[name='fld4']").val(), //syarat promo
			fld5 : $("select[name='fld5']").val(), //size gambar
			fld6 : $("select[name='fld6']").val(), //kategori
			fld7 : ck1, //all produk
			fld8 : $("input[name='fld8']").val(), //mulai promo
			fld9 : $("input[name='fld9']").val(), //akhir promo
			fld10: $("input[name='fld10']").val(), //diskon
			fld11: $("input[name='fld11']").val(), //quantity peritem
			fld12: ck2, //diskon peritem
			if_kelipatan: ck3, //jika kelipatan
			fld13: $("input[name='fld13']").val(), //max kelipatan
			fld14: $("input[name='fld14']").val(), //gambar promo
		});

		$(function () {
			//items
      $('#promo-produk tr').each(function (a, b) {
				if(a>0){
					ary_item.push({
						0:b.cells[1].innerText, //id produk
						1:b.cells[2].innerText, //nama
						2:$("input[name='fld1']").val(), //ID PROMO
						3:b.cells[3].innerText, //tipe diskon
						4:b.cells[4].children[0].value, //quantity
						5:b.cells[5].children[0].value //diskon
					});
				}
      });
			//bonus
			$('#bonus-produk tr').each(function (a, b) {
				if(a>0){
					ary_bonus.push({
						0:b.cells[1].innerText,
						1:b.cells[3].innerText,
						2:$("input[name='fld1']").val()
					});
				}
      });
		var lgh_itempromo = $('#promo-produk tr').length;
		console.log(lgh_itempromo);

		$.ajax({
			type: 'post',
			url: base_url+'admin/c_promo/add_data',
			data: {
				data_promo : ary_promo,
				//data_item  : ary_item,
				//data_bonus : ary_bonus
			},
			success: function(res){
				alert(res);
			}
		});

		var file_data = $('#fld14').prop('files')[0];
		var form_data = new FormData();
		form_data.append('fld14',file_data);
			$.ajax({
				dataType : "Text",
				url  : base_url+'admin/c_promo/upload_gambar?id='+$("input[name='fld1']").val(),
				cache : false,
				contentType:false,
				processData:false,
				data:form_data,
				type:"POST",
				success: function(response){
					//console.log(response);
					$('#modal_add_new').modal('toggle');
					$('#promo-table').DataTable().ajax.reload(null, false);
				},
				error: function(response){
					//console.log(response);
				}
			});
		return false;
	})
});
$('#add-item').click(function(){
		//table_add_item.rows('.selected').deselect();
		$('#myModalLabel2').html('Item Produk');
		$('#modal_add_item').modal('show');
	});
	$('#add-bonus').click(function(){
		//table_add_item.rows('.selected').deselect();
		$('#myModalLabel2').html('Produk Bonus');
		$('#modal_add_item').modal('show');
	});
	//DataTable
		$('#table-add-item')
		.DataTable({
			"bAutoWidth": false,
			"aaSorting": [],
			"sAjaxSource": base_url+'admin/c_promo/get_json_data_item',
			"bPaginate": true,
			"aoColumnDefs": [
				{
					"aTargets":[2],
					"fnCreatedCell": function(c1){
						$(c1).css("display", "none");
					}
				}
			]
		});

		var table_add_item = $('#table-add-item').DataTable();
    $('#btn-apply-add-item').click( function () {
        var tblData = table_add_item.rows('.selected').data();
			rowCount = table_add_item.rows('.selected').data().length;
		var tmpData, cnt = 1, citem;
		citem = ($("#myModalLabel2").text() == "Produk Bonus") ? "bonus" : "item";

		if(citem == 'item'){
			var row_num = parseInt( $('#promo-produk').parent().find('tr').length );
			if(row_num > 1) cnt = row_num;
			for (var i=0;i<rowCount;i++) {
				c = cnt++;
				a = "$('#r"+c+"').remove();";
				tmpData += '<tr class="odd gradeX" id="r'+c+'">'+
					'<td style="width:10px">'+c+'</td>'+
					'<td>'+table_add_item.rows('.selected').data()[i][2]+'</td>'+
					'<td>'+table_add_item.rows('.selected').data()[i][1]+'</td>'+
					'<td>'+$("select[name='fld3']").val()+'</td>'+
					'<td><input type="text" id="qty-r'+c+'" value="'+$("input[name='fld11']").val()+'" style="width:100px;" /></td>'+
					'<td><input type="text" id="disc-r'+c+'" value="'+$("input[name='fld10']").val()+'" style="width:100px;" /></td>'+
					'<td hidden></td>'+
					'<td>'+'<a href="#" onclick="'+a+'">Delete</a>'+'</td>'+
					'</tr>';
			}
			if($('#r0').length > 0) $('#r0').remove();
			$('#promo-produk tbody').append(tmpData);
		}
		if(citem == 'bonus'){
			var row_num = parseInt( $('#bonus-produk').parent().find('tr').length );
			if(row_num > 1) cnt = row_num;
			for (var i=0;i<rowCount;i++) {
				c = cnt++;
				a = "$('#rb"+c+"').remove();";
				tmpData += '<tr class="odd gradeX" id="rb'+c+'">'+
					'<td style="width:10px">'+c+'</td>'+
					'<td>'+table_add_item.rows('.selected').data()[i][2]+'</td>'+
					'<td>'+table_add_item.rows('.selected').data()[i][1]+'</td>'+
					'<td hidden></td>'+
					'<td>'+'<a href="#" onclick="'+a+'">Delete</a>'+'</td>'+
					'</tr>';
			}
			if($('#rb0').length > 0) $('#rb0').remove();
			$('#bonus-produk tbody').append(tmpData);
		}
		$('#modal_add_item').modal('toggle');
    });

	$('#reset-item-selected').click(function(){
		table_add_item.rows('.selected').deselect();
	});
	$('#table-add-item tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

function update(frm,id){
	$.ajax({
		url: base_url+'admin/c_promo/cari_rec',
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

function addFill(item, index) {
	if(item.fld.substring(0,3) == "img"){
		$(item.fld).load(item.fld);
		$(item.fld).attr('src',item.val);
	} else if(item.fld.substring(0,5) == "table"){
		$(item.fld).html(item.val);
	} else if(item.fld.substring(0,4) == "span"){
		$(item.fld).html(item.val);
	} else if(item.fld.substring(0,4) == "chk1"){
		//console.log("ck1 =", item.val);
		if( item.val == '1'){
			$("#fld7").prop('checked', true);
		}else if(item.val == '0'){
			$("#fld7").prop('checked', false);
		}else {
			$("#fld7").prop('checked', false);
		}
	}
	else if(item.fld.substring(0,4) == "chk2"){
		if(item.val == '1'){
			//console.log("ck2 =", item.val);
			$("#fld12").prop('checked', true);
		}else if (item.val == '0'){
			$("#fld12").prop('checked', false);
		}else {
			$("#fld12").prop('checked', false);
		}
	}
	//  else if(item.fld.substring(0,4) == "chk3"){
	// 	if(item.val == '1' || item.val == 1){
	// 		$("#if_kelipatan").prop('checked', true);
	// 	}else{
	// 		$("#if_kelipatan").prop('checked', false);
	// 	}
	// }
	else if(item.fld.substring(0,1) != ""){
		$(item.fld).val(item.val);
	}
	//cek_chekbox();
}

// function cek_chekbox(){
// 	if($('#if_kelipatan').is(':checked')){
// 		$("#fld13").prop('disabled', false);
// 		$("#fld13").prop('required', true);
// 	}else{
// 		$("#fld13").prop('disabled', true);
// 		$("#fld13").prop('required', false);
// 	}
// }

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
