 <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
    <div class="sidebar-brand-icon">
      <h5>ADMIN | RAGNO</h5>
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
    <a class="nav-link" href="{{route('prefix_history',['page=1'])}}">
      <i class="fas fa-fw fa-retweet"></i>
      <span>Prefix History</span>
    </a>
  </li>
</li>
</ul>
