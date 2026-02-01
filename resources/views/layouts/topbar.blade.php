<div class="top-navbar">
    <div class="xp-topbar">
        <div class="row align-items-center">
            <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                <div class="xp-menubar">
                    <span class="material-icons text-white">signal_cellular_alt</span>
                </div>
            </div>
            <div class="col-md-5 col-lg-3 order-3 order-md-2">
                <div class="xp-searchbar">
                    <form>
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search">
                            <button class="btn" type="submit" id="button-addon2">Go</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5 col-lg-7 order-1 order-md-3">
                <div class="xp-breadcrumbbar d-flex justify-content-start align-items-center ms-5">
                    <h4 class="page-title m-0 text-white">{{ $header ?? '' }}</h4>
                </div>
            </div>
            <div class="col-md-2 col-lg-1 order-4 order-md-4">
                <div class="xp-userbar d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center text-white">
                        <span class="material-icons me-2">account_circle</span>
                        <span class="username">{{ Auth::user()->username ?? Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>