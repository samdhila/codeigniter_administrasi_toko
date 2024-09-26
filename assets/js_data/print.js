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
		  var ESC = 17;
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
		  var escset =  RESET + SIZE_10_CPI + FONT_ROMAN + CONDENSED_ON + SPACING_9_72; 
		  var prnline = " "; 
		  for(n=0;n<vaPrintLine.length;n++){
			  prnline += vaPrintLine[n];
		  }
	//	  alert(prnline);
		  xmlHttp.open( "POST", "http://"+cHost+":"+cPort+"/print", true ); // false for synchronous request
		  xmlHttp.send( '{"RawData":"'+ escset + prnline  + FORM_FEED + RESET +'","PrinterName":"'+cPrinterName+'"}' );	
	}