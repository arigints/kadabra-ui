@extends('template.main')
@section('title','Statistics Prefix RFC')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Statistics - Prefix RFC</h1>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Statistics - Prefix RFC</li>
	</ol>
</div>
<div class="row mb-3">
	<div class="col-xl-12 col-lg-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary title-rs-graph">Prefix RFC</h6>
				<div class="row">
					<div class="col-md-12">
						<nav>
							<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-nr-tab" data-toggle="tab" href="#nav-nr" role="tab" aria-controls="nav-nr" aria-selected="true">New Registrant</a>
								<a class="nav-item nav-link" id="nav-sd-tab" data-toggle="tab" href="#nav-sd" role="tab" aria-controls="nav-sd" aria-selected="false">Summary Data</a>
							</div>
						</nav>
					</div>
				</div>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
					aria-labelledby="dropdownMenuLink">
					<div class="dropdown-header">Filter :</div>
					<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRFC('1d')">Last 1 Day</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRFC('7d')">Last 7 Day</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRFC('30d')">Last 30 day</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalRangeRFC">Date Range</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="chart-area">
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-nr" role="tabpanel" aria-labelledby="nav-nr-tab">
						<div class="row">
							<div class="col-md-12">
								<div id="chartNewRegistrant"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="nav-sd" role="tabpanel" aria-labelledby="nav-sd-tab">
						<div class="row">
							<div class="col-md-12">
								<div id="chartSummary"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-12 col-lg-12">
	<div class="card mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary title-prf-graph">List Prefixs RFC</h6>
			<div class="dropdown no-arrow">
				<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
				aria-labelledby="dropdownMenuLink">
				<div class="dropdown-header">Filter :</div>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setPrefixRFC('1d')">Last 1 Day</a>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setPrefixRFC('7d')">Last 7 Day</a>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setPrefixRFC('30d')">Last 30 day</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalRangePrefixRFC">Date Range</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive p-3">
			<table class="table align-items-center table-flush" id="dataTable">
				<thead class="thead-light">
					<th>No</th>
					<th>Date</th>
					<th>Prefix</th>
					<th>Source</th>
					<th>AS Number</th>
				</thead>
			</table>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal fade" id="modalRangeRFC" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle">Show Range Graph</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group" id="start-dr-rs">
				<label for="startDateRoa">Start Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Start Date" id="startDateRS">
				</div>
			</div>
			<div class="form-group" id="end-dr-rs">
				<label for="endDateRoa">End Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="End Date" id="endDateRS">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setGraphRFC('range');">Show Data</button>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modalRangePrefixRFC" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle">Show Range Prefix RFC</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group" id="start-prx-rs">
				<label for="startDateRoa">Start Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Start Date" id="startDatePRX">
				</div>
			</div>
			<div class="form-group" id="end-prx-rs">
				<label for="endDateRoa">End Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="End Date" id="endDatePRX">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setPrefixRFC('range');">Show Data</button>
		</div>
	</div>
</div>
</div>
@endsection
@section('userScript')
<script src="{{asset('vendor/datatables/button/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendor/datatables/button/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor/datatables/button/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendor/datatables/button/jszip/jszip.min.js')}}"></script>
<script src="{{asset('vendor/datatables/button/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendor/datatables/button/js/buttons.print.min.js')}}"></script>
<script src="{{asset('vendor/datatables/button/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/rfc-new-and-summary.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/rfc-prefixs.js')}}"></script>
@endsection