<?php

	function format_number(){
		
	}

	$nRow = 0;
	$cPrinterName 		= 'EPSON LX-310';
	$msPrinterType 		= 'Epson-LX';
	$PrintServer_Host 	= '';
	$PrintServer_Port 	= '1551';
	
	$nama_toko	= "Tukutuku";
	$address	= "Asem Kandang, Kratorn <br> Pasuruan Jawa Timur 68175";
	$telp		= "0343-9383377";
	
	$faktur		= "#SO2018040300004";
	$tgl		= "04-Apr-2018";
	
	
	$lebar = 46;
	$line  = "-";
	$space = str_repeat("",19);
	$break = "<br>";
	
	echo str_repeat("&nbsp;",19);
	echo $nama_toko;
	echo str_repeat("&nbsp;",19);
	echo $break;
	echo $address;
	echo $break;
	echo $telp;
	echo $break;
	echo str_repeat($line,$lebar);
	echo $break;
	echo $faktur;
	echo str_repeat("&nbsp;",5);
	echo $tgl;
	echo $break;
	echo str_repeat($line,$lebar);
	echo $break;
	foreach ($data_order as $row){
		$jm_karakter = 20;
		$char_q = strlen($row['name']);
		if($char_q > $jm_karakter){
			$name  = substr($row['name'],0,20);
			$name .= $row['quantity'];
			$name .= $row['unit_price'];
			$name .= "<br>".substr($row['name'],20);
		}else {
			$name  = $row['name'];
			$name .= $row['quantity'];
			$name .= $row['unit_price'];
		}
		echo $name.str_repeat("&nbsp;",2).$break;
	}
			
	/* $vaPrint[0] = $_cLeftA."LOGO"."</br></br>";
	$vaPrint[1] = $_cLeft."KWITANSI PEMBAYARAN"."</br>";
	$vaPrint[2] = str_repeat(" ",61).$nomor_kwitansi."</br></br>";
	$vaPrint[3] = $_cLeftA."Telah diterima dari";
	$vaPrint[4] = str_repeat(" ",27).":".$spasi.$nama_donatur.str_repeat(" ",38).$nik."</br></br>";
	$vaPrint[5] = $_cLeftA."Sejumlah Uang";
	$vaPrint[6] = str_repeat(" ",33).":".$spasi.$terbilang."</br></br>";
	$vaPrint[7] = $_cLeftA."Untuk pembayaran donatur bulan";
	$vaPrint[8] = str_repeat(" ",16).":".$spasi.$bulan.str_repeat(" ",40).$tanggal."</br></br>";
	$vaPrint[9] = str_repeat(" ",81)."Mengetahui,";
	$vaPrint[10] = str_repeat(" ",19)."Diterima Oleh"."</br></br></br>";
	$vaPrint[11] = $_cLeftA.str_repeat(" ",8)."|".str_repeat("-",50)."|";
	$vaPrint[12] = str_repeat(" ",10).$nm_1;
	$vaPrint[13] = str_repeat(" ",20).$nm_2."</br>";
	$vaPrint[14] = $_cLeftA.$rupiah.$spasi.":".$spasi."|".str_repeat(" ",20).$nominal.$snom."|";
	$vaPrint[15] = str_repeat(" ",10).$under_line_1;
	$vaPrint[16] = str_repeat(" ",20).$under_line_2."</br>";
	$vaPrint[17] = $_cLeftA.str_repeat(" ",8)."|".str_repeat("-",50)."|";
	$vaPrint[18] = str_repeat(" ",10).$jabatan_1;
	$vaPrint[19] = str_repeat(" ",20).$jabatan_2."</br></br>";
	$vaPrint[20] = str_repeat(" ",40).$alamat."</br>"; */
	
	//echo json_encode($vaPrint);

?>

<style>
 @media print {
    html, body {
		width: 8cm;
        display: block;
        font-family: "Calibri";
        margin: 0;
    }

    @page {
      size: 8cm;
    }
    .logo {
      width: 30%;
    }

}
</style>
<html>
<body>
<table id="print_area" style="width:302px; border:1px solid black; height:auto; padding:2px;">
	<tr>
		<td valign="top" style="font-size:13px; text-align:center;"><b>Tukutuku</b></td>
	</tr>
	<tr>
		<td valign="top" style="font-size:12px; text-align:center;">
			Asem Kandang, Kraton</br>
			Pasuruan Jawa Timur 68175</br>
			Telp : 0343-938337
		</td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
	<tr>
		<td style="font-size:11px;text-align:center;">#SO2018040300004 | 04-Apr-2018 12:00</td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
	<tr>
		<td>
			<table style=" font-size:12px; width:100%; border:0px solid black;">
				<tr>
					<td>Nuvo Sabun Mandi</td>
					<td>1</td>
					<td style="text-align:right;">1,800</td>
					<td style="text-align:right;">1,800</td>
				</tr>
				<tr>
					<td>GIV Sabun Mandi</td>
					<td>1</td>
					<td style="text-align:right;">2,000</td>
					<td style="text-align:right;">2,000</td>
				</tr>
				<tr>
					<td>Emeron Shampo Sweet Apel</td>
					<td>1</td>
					<td style="text-align:right;">1,300</td>
					<td style="text-align:right;">1,300</td>
				</tr>
				<tr>
					<td>Emeron Shampo Black Shine</td>
					<td>1</td>
					<td style="text-align:right;">13,000</td>
					<td style="text-align:right;">13,000</td>
				</tr>
				<tr>
					<td style="text-align:center;">Diskon : </td>
					<td></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">()</td>
				</tr>
				<tr>
					<td colspan="4"><hr></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">HARGA JUAL : </td>
					<td colspan="2" style="text-align:right;">18,100</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">ONGKOS KIRIM : </td>
					<td colspan="2" style="text-align:right;">0</td>
				</tr>
				<tr>
					<td colspan="4"><hr></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">TOTAL : </td>
					<td colspan="2" style="text-align:right;">18,100</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">TUNAI : </td>
					<td colspan="2" style="text-align:right;">20,000</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">KEMBALI : </td>
					<td colspan="2" style="text-align:right;">1,900</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
	<tr>
		<td style="font-size:11px;text-align:center;"><b>Terima kasih telah berbelanja di Tukutuku.</b></td>
	</tr>
</table>
</body>
</html>

<script>
function callRawPrint(vaPrintLine, cPrinterName, cPrinterType, cHost, cPort){
	if (cPrinterType=='') cPrinterType='Epson-LX';
	if (cHost=='') cHost='localhost';
	if (cPort=='') cPort='1551';
	//console.log(cHost);
	RawPrint(vaPrintLine, cPrinterName, cPrinterType, cHost, cPort);
}

function RawPrint(vaPrintLine, cPrinterName, cPrinterType, cHost, cPort){
	  var xmlHttp = new XMLHttpRequest();
	  xmlHttp.onreadystatechange = function() {
	    if(xmlHttp !== null){
	        try {
	          if (xmlHttp.readyState == 4) {
	            if (xmlHttp.status == 200) {
//	              cRetval = xmlHttp.responseText ;
//	              eval(cRetval) ;
		    	  alert(xmlHttp.responseText);
	            }
	          }
	        }catch(e){
	          if(e.message.indexOf('NS_ERROR_NOT_AVAILABLE') < 0){
//	            cRetval = xmlHttp.responseText ;
//	            eval(cRetval) ;
		    	  alert(xmlHttp.responseText);
	          }
	        }
	      }
	  }
	  var ESC = 27;
	  var RESET = String.fromCharCode(ESC,'@');
	  // ganti kertas
	  var FORM_FEED = String.fromCharCode(12);
	  var ENTER = String.fromCharCode(13);
//	  if (cPrinterType=="Epson-LX"){
		  // font size
		  var SIZE_5_CPI = String.fromCharCode(ESC,'W','1',ESC,'P');
		  var SIZE_6_CPI = String.fromCharCode(ESC,'W','1',ESC,'M');		  
		  var SIZE_10_CPI = String.fromCharCode(ESC,'P');		  
		  var SIZE_12_CPI = String.fromCharCode(ESC,'M');		  
		    //font height
		  var HEIGHT_NORMAL = String.fromCharCode(ESC,'w', '0');
		  var HEIGHT_DOUBLE = String.fromCharCode(ESC,'w', '1');
		    // double strike (satu dot dicetak 2 kali)
		  var DOUBLE_STRIKE_ON = String.fromCharCode(ESC,'G');
		  var DOUBLE_STRIKE_OFF = String.fromCharCode(ESC,'H');
		    // http://www.berklix.com/~jhs/standards/escapes.epson
		    // condensed (huruf kurus)
		  var CONDENSED_ON = String.fromCharCode(15);
		  var CONDENSED_OFF = String.fromCharCode(18);
		    // condensed (huruf gemuk)
		  var ENLARGED_ON = String.fromCharCode(14);
		  var ENLARGED_OFF = String.fromCharCode(20);
		  // line spacing
		  var SPACING_9_72 = String.fromCharCode(ESC, '0');
		  var SPACING_7_72 = String.fromCharCode(ESC, '1');
		  var SPACING_12_72 = String.fromCharCode(ESC, '2');
		    // mode draft diaktifkan
		  var MODE_DRAFT = String.fromCharCode(ESC,'x',0);
		  var MODE_NLQ = String.fromCharCode(ESC,'x',1);
		    // font Roman (halaman 47)
		  var FONT_ROMAN = String.fromCharCode(ESC,'k',0);
		    // font Sans serif
		  var FONT_SANS_SERIF = String.fromCharCode(ESC,'k',1);
//	  }
	  var escset =  RESET + SIZE_10_CPI + FONT_SANS_SERIF + CONDENSED_ON + SPACING_9_72; 
	  var prnline = " "; 
	  for(n=0;n<vaPrintLine.length;n++){
		  prnline += vaPrintLine[n];
	  }
//	  alert(prnline);
	  xmlHttp.open( "POST", "http://"+cHost+":"+cPort+"/print", true ); // false for synchronous request
	  xmlHttp.send( '{"RawData":"'+ escset + prnline  + FORM_FEED + RESET +'","PrinterName":"'+cPrinterName+'"}' );	
}
//callRawPrint(json,cPrinterName,msPrinterType,PrintServer_Host,PrintServer_Port);

</script>