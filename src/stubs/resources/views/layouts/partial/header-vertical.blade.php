<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="flex-row navbar-nav order-md-last">
            @include('layouts.partial.avatar-menu')
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div>
                <form action="." method="get">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"></path>
                                <circle cx="10" cy="10" r="7"></circle>
                                <line x1="21" y1="21" x2="15" y2="15"></line>
                            </svg>
                        </span>
                        <input type="text" class="form-control" placeholder="Search…" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
