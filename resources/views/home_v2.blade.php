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
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">New Registrant (IDNIC)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$current_ipv4['value']}}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
            	@if($current_ipv4['percent'] >= 0)
            	<span class="text-success mr-2">
	              	<i class="fa fa-arrow-up"></i> {{number_format((float)$current_ipv4['percent'],2,'.','')}}%
	            </span>
            	@else
            	<span class="text-danger mr-2">
	              	<i class="fa fa-arrow-down"></i> {{number_format((float)$current_ipv4['percent'],2,'.','')}}%
	            </span>
            	@endif
            	<span>Since last month</span>
            </div>
          </div>
          <div class="col-auto">
            <span class="text-primary title-dashboard">IPv4</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Annual) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">New Registrant (IDNIC)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$current_ipv6['value']}}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              	@if($current_ipv6['percent'] >= 0)
            	<span class="text-success mr-2">
	              	<i class="fa fa-arrow-up"></i> {{number_format((float)$current_ipv6['percent'],2,'.','')}}%
	            </span>
            	@else
            	<span class="text-danger mr-2">
	              	<i class="fa fa-arrow-down"></i> {{number_format((float)$current_ipv6['percent'],2,'.','')}}%
	            </span>
            	@endif
            	<span>Since last month</span>
            </div>
          </div>
          <div class="col-auto">
            <span class="text-success title-dashboard">IPv6</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- New User Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">New Registrant (IDNIC)</div>
            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$current_asn['value']}}</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              	@if($current_asn['percent'] >= 0)
            	<span class="text-success mr-2">
	              	<i class="fa fa-arrow-up"></i> {{number_format((float)$current_asn['percent'],2,'.','')}}%
	            </span>
            	@else
            	<span class="text-danger mr-2">
	              	<i class="fa fa-arrow-down"></i> {{number_format((float)$current_asn['percent'],2,'.','')}}%
	            </span>
            	@endif
            	<span>Since last month</span>
            </div>
          </div>
          <div class="col-auto">
            <span class="text-info title-dashboard">ASN</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mb-3">
	<div class="col-xl-12 col-lg-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary title-prefix-graph">Last 7 Day New Registrant</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-primary-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Filter :</div>
						<a class="dropdown-item" href="javascript:void(0)" onclick="setChartPrefix('7d')">Last 7 Day</a>
						<a class="dropdown-item" href="javascript:void(0)" onclick="setChartPrefix('30d')">Last 30 day</a>
						<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalRangePrefix">Date Range</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="javascript:void(0)" onclick="setChartPrefix('all')">All</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="row">
							<div class="col-md-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="customRadioPrefix1" name="typeResultPrefix" class="custom-control-input" value="new_registrant">
									<label class="custom-control-label" for="customRadioPrefix1">New Registrant</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="customRadioPrefix2" name="typeResultPrefix" class="custom-control-input" value="summary">
									<label class="custom-control-label" for="customRadioPrefix2">Summary</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="custom-control">
							<select class="form-control form-control-sm mb-3" id="prefixOption">
				                <option value="IPv4">IPv4</option>
				                <option value="IPv6">IPv6</option>
				                <option value="All">All</option>
				            </select>
						</div>
					</div>
					<div class="col-md-12 div-prefix"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-12 col-lg-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary title-as-graph">Last 7 Day New Registrant</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-primary-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Filter :</div>
						<a class="dropdown-item" href="javascript:void(0)" onclick="setchartASN('7d')">Last 7 Day</a>
						<a class="dropdown-item" href="javascript:void(0)" onclick="setchartASN('30d')">Last 30 day</a>
						<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalRangeASN">Date Range</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="javascript:void(0)" onclick="setchartASN('all')">All</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="row">
							<div class="col-md-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="customRadioASN1" name="typeResultASN" class="custom-control-input" value="new_registrant">
									<label class="custom-control-label" for="customRadioASN1">New Registrant</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="customRadioASN2" name="typeResultASN" class="custom-control-input" value="summary">
									<label class="custom-control-label" for="customRadioASN2">Summary</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 div-asn"></div>
				</div>	
			</div>
		</div>
	</div>
</div>
<div class="row mb-3">
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
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-primary-400"></i>
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
<div class="modal fade" id="modalRangePrefix" tabindex="-1" role="dialog"
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
			<div class="form-group" id="start-dr-prefix">
				<label for="startDateRoa">Start Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Start Date" id="startDatePrefix">
				</div>
			</div>
			<div class="form-group" id="end-dr-prefix">
				<label for="endDateRoa">End Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="End Date" id="endDatePrefix">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setChartPrefix('range');">Show Data</button>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modalRangeASN" tabindex="-1" role="dialog"
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
			<div class="form-group" id="start-dr-asn">
				<label for="startDateRoa">Start Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Start Date" id="startDateASN">
				</div>
			</div>
			<div class="form-group" id="end-dr-asn">
				<label for="endDateRoa">End Date</label>
				<div class="input-group date">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="End Date" id="endDateASN">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setchartASN('range');">Show Data</button>
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
<script src="{{asset('vendor/amcharts5/index.js')}}"></script>
<script src="{{asset('vendor/amcharts5/xy.js')}}"></script>
<script src="{{asset('vendor/amcharts5/themes/Animated.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/prefix-graph.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/asn-graph.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/roa-statusv2.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/roa-statusv4.js')}}"></script>
@endsection