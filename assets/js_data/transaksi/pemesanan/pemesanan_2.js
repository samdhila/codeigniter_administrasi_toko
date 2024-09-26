$(document).ready(function() {
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
		"sAjaxSource": base_url+'admin/c_pemesanan_2/get_data_pemesanan',			
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
	
	myTable.on('order.dt search.dt', function () {
		myTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	}).draw();
	
	setInterval(function() {
		myTable.ajax.reload(null, false);
	},5000 );
	
	
	myTable.on('dblclick', 'tr', function (){
		var data = myTable.row( this ).data();
		var s = '<?=$modal_pemesanan;?>';
		//alert(data[9]);
		update(s,data[9]);
		
		$('#modal_add_new_sp').modal('show');
		$('#modal_add_new_sp').modal({backdrop: 'static', keyboard: false});
		
		$( "#cetak_pemesanan" ).click(function() {
		  $.ajax({
				type:'GET',
				url: base_url+'admin/c_pemesanan/update_status/'+data[1]+'/cetak',
				dataType: 'json',
				success : function(data){
					if(data.st_cetak == 'Success'){
						//alert("Success");
						$('#dynamic-table').DataTable().ajax.reload();
					}else if(data.st_cetak == 'Gagal'){
						alert("Gagal");
						$('#dynamic-table').DataTable().ajax.reload();
					}
				}
			});
		});
		
		
		/*if(s=='1' || s=='2' || s=='5' || s=='6') update(s,data[3]);
		
		
		if(v_url == 'data/transaksi/pemesanan.php'){
		}else if(v_url == 'data/transaksi/pemesanan_shipped.php'){
			$('#modal_add_new_sp').modal('show');
		}else if(v_url == 'data/transaksi/pemesanan_done.php'){
			$('#modal_add_new_sp').modal('show');
			$('#kirim_2').hide();
		}else{
			$('#modal_add_new').modal('show');
		} */
	});
});

function update(frm,id){
	$.ajax({
		url: base_url+'admin/c_pemesanan_2/cari_rec',
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