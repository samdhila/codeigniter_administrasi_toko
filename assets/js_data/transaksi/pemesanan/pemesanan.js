$(document).ready(function() {
	function print_data(){
		/* $.ajax({
			type:'GET',
			url: base_url+'admin/c_pemesanan/',
			dataType: 'json',
			success : function(data){
		
			}
		}); */
		var cPrinterName 		= 'EPSON LX-310';
		var msPrinterType 		= 'Epson-LX';
		var PrintServer_Host 	= '';
		var PrintServer_Port 	= '1551';
		var data = [
			"                  TUKUTUKU                    <\/br>",
			"Asem Kandang, Kraton <\/br>", 
			"Pasuruan Jawa Timur 68175 <\/br>",
			"Telp : 0343-9383377 <\/br>",
			"--------------------------------------------- <\/br>",
			"#SO2018040300004 | 04-Apr-2018 12:00 <\/br>",
			"--------------------------------------------- <\/br>",
			"Nuvo Sabun Mandi            1  1,800   1,800  <\/br>",
			"GIV Sabun Mandi             1  2,000   2,000  <\/br>",
			"Emeron Shampo Sweet Apel    1  1,300   1,300  <\/br>",
			"Emeron Shampo Black Shine   1  13,000  13,000 <\/br>",
			"          Diskon :                     ()     <\/br>",
			"--------------------------------------------- <\/br>",
			"                          HARGA JUAL : 18,100 <\/br>",
			"--------------------------------------------- <\/br>",
			"                          TOTAL    :   18,100 <\/br>",
			"                          TUNAI    :   20,000 <\/br>",
			"                          Kembali  :    1.900 <\/br>",
			" <\/br>  Terima Kasih telah berbelanja di Tukutuku.  "
		];
		callRawPrint(data,cPrinterName,msPrinterType,PrintServer_Host,PrintServer_Port);
	}
	
	/* $("#print_server").click(function(){
		print_data();
	}); */
	
	//DataTable
	var myTable = 
	$('#table_pemesanan')
	.DataTable({
		"bAutoWidth": true,
		"aoColumns": [
			{ "bSortable": false },
			/*{
				"className": "details-control center",
				"orderable": false,
				"defaultContent": "",
				"bSortable": false
			},*/
			null, null, null, null, null, null, null,
			{ "bSortable": false }
		],
		"aaSorting": [],
		"aoColumnDefs": [
		{
			"aTargets":[6,7],
			"fnCreatedCell": function(c1){					   
				$(c1).css("text-align", "right");
			},
		},
		{
			"aTargets":[0,8],
			"fnCreatedCell": function(c1){					   
				$(c1).css("text-align", "center");
			},
		},
		{
			"aTargets": [7],
			render: $.fn.dataTable.render.number( ',', '.', 0 )
		}
		],										
		"sAjaxSource": base_url+'admin/c_pemesanan/get_data_pemesanan',			
		//"sScrollY": "200px",
		"bPaginate": true,
		//fixedColumns :   {
			//leftColumns: 3,
		//},
		//"iDisplayLength": 50,			
		select: {
			style: 'single'
		}
	});
	
	myTable.on('order.dt search.dt',function(){
		myTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		});
	}).draw();
	
	setInterval(function() {
		myTable.ajax.reload(null, false);
	},5000 );
	
	myTable.on('dblclick', 'tr', function (){
		var data = myTable.row( this ).data();
		var s = '<?=$modal_pemesanan;?>';
		//alert(data[9]);
		update(s,data[9]);
		$.ajax({
			type:'GET',
			url: base_url+'admin/c_pemesanan/update_status/'+data[1]+'/cek',
			dataType: 'json',
			success : function(data){
				//alert(data.status);
				if(data.st_ambil == 1){
					alert("Maaf pesanan tidak tersedia.");
					//$('#table_pemesanan').DataTable().ajax.reload();
				}else if(data.st_ambil == 2){
					//alert("Gagal");
					$('#modal_add_new').modal('show');
					$('#modal_add_new').modal({backdrop: 'static', keyboard: false});
				}
			}
		});
		
		$( "#btn_tutup" ).click(function(){
			$.ajax({
				type:'GET',
				url: base_url+'admin/c_pemesanan/update_status/'+data[1]+'/batal',
				dataType: 'json',
				success : function(data){
					if(data.st_batal == 'Success'){
						$('#table_pemesanan').DataTable().ajax.reload();
					}else if(data.st_batal == 'Gagal'){
						$('#table_pemesanan').DataTable().ajax.reload();
					}
				}
			});
		});
		
		$("#cetak_pemesanan").click(function(){
			$.ajax({
				type:'GET',
				url: base_url+'admin/c_pemesanan/update_status/'+data[1]+'/cetak',
				dataType: 'json',
				success : function(data){
					if(data.st_cetak == 'Success'){
						//alert("Success");
						$('#table_pemesanan').DataTable().ajax.reload();
					}else if(data.st_cetak == 'Gagal'){
						alert("Gagal");
						$('#table_pemesanan').DataTable().ajax.reload();
					}
				}
			});
		});
		
		$("#print_server").click(function(){	
			print_data();
		});
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
	});
				
	myTable.buttons().container().appendTo($('.tableTools-container'));
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

function update(frm,id){
	$.ajax({
		url: base_url+'admin/c_pemesanan/cari_rec',
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