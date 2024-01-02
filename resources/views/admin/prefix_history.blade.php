@extends('template-admin.main')
@section('title','Prefix History')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Data - Prefix History</h1>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active" aria-current="page">Data - Prefix History</li>
	</ol>
</div>
<div class="row mb-3">
	<div class="col-xl-12 col-lg-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-left justify-content-between">
				<span>
					<h4 class="m-0 font-weight-bold text-primary title-rs-graph">
						Prefix History
					</h4><br/>
					<span class="label-search" style="margin-top:10px;">Specific Search :</span>
					<select name="search_by" class="form-control input-search">
						<option value="prefix" @if(!empty($find)) @if($find == 'prefix') selected @endif @endif >Prefix</option>
						<option value="origin_as" @if(!empty($find)) @if($find == 'origin_as') selected @endif @endif >Origin Asn</option>
						<option value="rcc" @if(!empty($find)) @if($find == 'rcc') selected @endif @endif >RC</option>
					</select>
					<input type="text" name="search_value" class="form-control input-search" style="margin-left:10px;" placeholder="Search here.." @if(!empty($value)) value="{{base64_decode($value)}}" @endif>
					<h6 style="margin-left: 120px;font-size: 13px;"><i>press enter to start searching</i></h6>
				</span>
				<h6>
					{!! $info_data_page !!}<br/>
					@if($page >= 2)
					<a class="btn btn-primary" href="{{route('prefix_history',['page='.$prevPage])}}"><< Previous Data</a>
					@endif
					<a class="btn btn-primary" href="{{route('prefix_history',['page='.$nextPage])}}">Next Data >></a>
				</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive p-3">
					<table class="table align-items-center table-flush" id="tablePrefixHistory" width="100%">
						<thead class="thead-light">
							<th>No</th>
							<th>Prefix</th>
							<th>Origin ASN</th>
							<th>RC</th>
							<th>AS Path</th>
							<th>First Seen</th>
							<th>Last Seen</th>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalDetailData" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle">Detail Data</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<table style="width: 100%;">
				<tr>
					<td>Prefix</td>
					<td>:</td>
					<td><span id="prefixDetail"></span></td>
				</tr>
				<tr>
					<td>Origin ASN</td>
					<td>:</td>
					<td><span id="originASDetail"></span></td>
				</tr>
				<tr>
					<td>RC</td>
					<td>:</td>
					<td><span id="rccDetail"></span></td>
				</tr>
				<tr>
					<td>AS Path</td>
					<td>:</td>
					<td><span id="asPathDetail"></span></td>
				</tr>
				<tr>
					<td>First Seen</td>
					<td>:</td>
					<td><span id="firstSeenDetail"></span></td>
				</tr>
				<tr>
					<td>Last Seen</td>
					<td>:</td>
					<td><span id="lastSeenDetail"></span></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</div>
@endsection
@section('userScript')
<script type="text/javascript">
	@if(empty($find) && empty($value))
	let URL_REQ = APP_URL+'/admin/prefix-history/data/{{$page}}';
	@else
	let URL_REQ = APP_URL+'/admin/prefix-history/data/{{$page}}/{{$find}}/{{$value}}';
	@endif
	$('#tablePrefixHistory').DataTable({
		ajax : {
			url : URL_REQ,
			method : "GET",
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
		'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
		],
		columns: [
		{data: 'no', name: 'no'},
		{data: 'prefix', name: 'prefix'},
		{data: 'origin_as', name: 'origin_as'},
		{data: 'rcc', name: 'rcc'},
		{data: 'as_path', name: 'as_path'},
		{data: 'first_seen', name: 'first_seen'},
		{data: 'last_seen', name: 'last_seen'},
		],
		bInfo: false,
		lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]]
	});

	$("[name='search_value']").on('keypress',function(e){
		if(e.which == 13) {
			var search_by = $("[name='search_by'] option:selected").val();
			var search_value = $(this).val();
			window.location.href = "{{route('prefix_history',['page=1'])}}&find="+search_by+"&value="+btoa(search_value);
		}
	});

	function showDetail(data){
		$("#prefixDetail").html(data.prefix);
		$("#originASDetail").html(data.origin_as);
		$("#rccDetail").html(data.rcc);
		$("#asPathDetail").html(data.as_path);
		$("#firstSeenDetail").html(data.first_seen);
		$("#lastSeenDetail").html(data.last_seen);
		$("#modalDetailData").modal('show');
	}
</script>
@endsection