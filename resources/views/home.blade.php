@extends('template.main')
@section('title','Statistics')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Statistics</h1>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="./">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Statistics</li>
	</ol>
</div>
<div class="row mb-3">
	<div class="col-xl-12 col-lg-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary title-rs-graph">Last 7 Day New Registrant</h6>
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
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
				aria-labelledby="dropdownMenuLink">
				<div class="dropdown-header">Filter :</div>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRS('7d')">Last 7 Day</a>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRS('30d')">Last 30 day</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalRangeRS">Date Range</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="chart-area">
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-nr" role="tabpanel" aria-labelledby="nav-nr-tab">
					<div class="row">
						<div class="col-md-12">
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio1" name="newRegistrantRadio" class="custom-control-input" value="prefix">
								<label class="custom-control-label" for="customRadio1">New Prefix</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio2" name="newRegistrantRadio" class="custom-control-input" value="asn">
								<label class="custom-control-label" for="customRadio2">New ASN Data</label>
							</div>
						</div>
					</div>
					<div id="chartNewRegistrant"></div>
				</div>
				<div class="tab-pane fade" id="nav-sd" role="tabpanel" aria-labelledby="nav-sd-tab">
					<div class="row">
						<div class="col-md-12">
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio3" name="summaryRadio" class="custom-control-input" value="prefix">
								<label class="custom-control-label" for="customRadio3">New Prefix</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio4" name="summaryRadio" class="custom-control-input" value="asn">
								<label class="custom-control-label" for="customRadio4">New ASN Data</label>
							</div>
						</div>
					</div>
					<div id="chartSummary"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="col-xl-12 col-lg-12">
	<div class="card mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<div class="row">
				<div class="col-md-12">
					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-lrs-tab" data-toggle="tab" href="#nav-lrs" role="tab" aria-controls="nav-lrs" aria-selected="true">Last ROA Status</a>
							<a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">History</a>
						</div>
					</nav>
				</div>
			</div>
			<div class="dropdown no-arrow">
				<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
				aria-labelledby="dropdownMenuLink">
				<div class="dropdown-header">Filter :</div>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRoa('7d');">Last 7 Day</a>
				<a class="dropdown-item" href="javascript:void(0)" onclick="setGraphRoa('30d');">Last 30 Day</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalRangeRoa">Date Range</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="chart-area">
			<div class="tab-content" id="nav-tabContent2">
				<div class="tab-pane fade show active" id="nav-lrs" role="tabpanel" aria-labelledby="nav-lrs-tab">
					<div id="chartRoaLastDay"></div>
				</div>
				<div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
					<div class="row">
						<div class="col-md-3">
							<h6 class="m-0 font-weight-bold text-primary title-roa-graph">Last 7d Roa Status<br>
								<select class="form-control" id="selectRC">-- Select --</select>
							</h6>
						</div>
					</div>
					<div id="chartRoa"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal fade" id="modalRangeRS" tabindex="-1" role="dialog"
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
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setGraphRS('range');">Show Data</button>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modalRangeRoa" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle">Show Range Graph Roa</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="form-group" id="start-dr-roa">
				<label for="startDateRoa">Start Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Start Date" id="startDateRoa">
				</div>
			</div>
			<div class="form-group" id="end-dr-roa">
				<label for="endDateRoa">End Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="End Date" id="endDateRoa">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setGraphRoa('range');">Show Data</button>
		</div>
	</div>
</div>
</div>
@endsection
@section('userScript')
<script type="text/javascript" src="{{asset('custom/summary-data.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/new-registrantv2.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/roa-statusv2.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/roa-statusv4.js')}}"></script>
@endsection