jQuery(document).ready( function($) {
	$("input[name='pdc_siva']").on("input",function(e){
		var _IVA = parseInt($("input[name='iva']").val());
		if(!_IVA) _IVA = 0;
		var _psi = parseFloat($(this).val());
		if(!_psi) _psi = 0;
		var _result = _psi * (1+(_IVA/100));
		$("input[name='pdc_civa']").val(_result.toFixed(2));
		total();
	});

	$("input[name='iva']").on("input",function(e){
		var _psi = parseFloat($("input[name='pdc_siva']").val());
		if(!_psi) _psi = 0;
		var _IVA = parseInt($(this).val());
		if(!_IVA) _IVA = 0;
		var _result = _psi * (1+(_IVA/100));
		$("input[name='pdc_civa']").val(_result.toFixed(2));
		total();
	})

	$("input[name='pdc_civa']").on("input",function(e){
		var _IVA = parseInt($("input[name='iva']").val());
		if(!_IVA) _IVA = 0;
		var _pci = parseFloat($(this).val());
		if(!_pci) _pci = 0;
		var _result = _pci / (1+(_IVA/100));
		$("input[name='pdc_siva']").val(_result.toFixed(2));
		total();
	});

	$("input[name='preparacion'], input[name='transporte'], input[name='otros']").on("input",function(e){
		total();
	});

	function total() {
		var _pci = parseFloat($("input[name='pdc_civa']").val());
		if(!_pci) _pci = 0;
		var _tpt = parseFloat($("input[name='transporte']").val());
		if(!_tpt) _tpt = 0;
		var _prp = parseFloat($("input[name='preparacion']").val());
		if(!_prp) _prp = 0;
		var _ots = parseFloat($("input[name='otros']").val());
		if(!_ots) _ots = 0;
		var _result = _pci + _tpt + _prp + _ots;
		$("input[name='coste']").val(_result.toFixed(2));
	}
})