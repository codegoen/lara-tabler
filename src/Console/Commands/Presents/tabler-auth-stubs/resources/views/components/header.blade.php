<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav flex-row order-md-last">
      <x-avatar></x-avatar>
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div>
        <form action="." method="get">
          <div class="input-icon">
            <span class="input-icon-addon">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
            </span>
            <input type="text" class="form-control" placeholder="Search…">
          </div>
        </form>
      </div>
    </div>
  </div>
</header>

<form style="display: none;" action="{{ route('logout') }}" method="post" id="logout">
  @csrf
</form>
