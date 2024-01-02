 <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
    <div class="sidebar-brand-icon">
      <h5>RAGNO</h5>
    </div>
  </a>
  <hr class="sidebar-divider my-0">
   <div style="margin-left: 30px; margin-top: 15px;">
    <img src="{{asset('img/kadabra-logo-new.png')}}" style="width: 170px;">
   </div>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Features
  </div>
  <li class="nav-item">
    <a class="nav-link" href="{{route('home')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Statistics</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('stats.rfc')}}">
      <i class="fas fa-fw fa-globe"></i>
      <span>Prefix RFC</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('about')}}">
      <i class="fas fa-fw fa-info"></i>
      <span>About</span>
    </a>
  </li>
</li>
</ul>
