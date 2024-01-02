$(document).ready(function(){
	$('#dataTable').DataTable({
		ajax : {
			url : APP_URL+'/get/prefix-rfc-data/7d',
			method : "GET",
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
		'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
		],
		columns: [
		{data: 'no', name: 'no'},
		{data: 'date', name: 'date'},
		{data: 'prefix', name: 'prefix'},
		{data: 'rc_alias', name: 'rc_alias'},
		{data: 'last_as', name: 'last_as'},
		],
		bInfo: false,
		lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]]
	});

	$('#start-prx-rs .input-group.date').datepicker({
		format: 'dd/mm/yyyy',
		todayBtn: 'linked',
		todayHighlight: true,
		autoclose: true,        
	});

	$('#end-prx-rs .input-group.date').datepicker({
		format: 'dd/mm/yyyy',
		todayBtn: 'linked',
		todayHighlight: true,
		autoclose: true,        
	});
});

function setPrefixRFC(range){
	$("#dataTable").DataTable().destroy();
	var url;
	if(range == "range"){
		var startDate = $("#startDatePRX").val();
		var endDate = $("#endDatePRX").val();
		var startPRX = startDate.split("/").reverse().join("-");
		var endPRX = endDate.split("/").reverse().join("-");
		url = APP_URL+"/get/prefix-rfc-data/"+startPRX+"/"+endPRX;
	}else{
		url = APP_URL+'/get/prefix-rfc-data/'+range;
	}

	$('#dataTable').DataTable({
		ajax : {
			url : url,
			method : "GET",
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
		'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
		],
		columns: [
		{data: 'no', name: 'no'},
		{data: 'date', name: 'date'},
		{data: 'prefix', name: 'prefix'},
		{data: 'rc_alias', name: 'rc_alias'},
		{data: 'last_as', name: 'last_as'},
		],
		bInfo: false,
		lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]]
	});
	$("#modalRangePrefixRFC").modal('hide');
}