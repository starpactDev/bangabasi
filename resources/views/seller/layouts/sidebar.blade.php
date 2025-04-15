<div class="ec-left-sidebar ec-bg-sidebar" style="font-family: Roboto, sans-serif;">
    <div id="sidebar" class="sidebar ec-sidebar-footer">

        <div class="ec- brand" id="sidebar-logo-bar" style="margin : 1rem auto;">
            <a href="{{ route('seller_dashboard') }}" title="Bongobasi">
                @if(isset($logos['4']))
                    <img class="" id="sidebar-logo-full" src="{{ asset('user/uploads/logos/' . $logos['4']->image_path) }}" alt="{{$logos['4']->location}}" style="width : 12rem !important"/>
                @endif

                @if(isset($logos['7']))
                    <img class="" id="sidebar-logo-min" src="{{ asset('user/uploads/logos/' . $logos['7']->image_path) }}" alt="{{$logos['7']->location}}" style="display : none; width : 3rem !important"/>
                @endif
            </a>
        </div>

        <!-- begin sidebar scrollbar -->
        <div class="ec-navigation" data-simplebar >
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <!-- Dashboard -->
                <li class="{{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('seller_dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <hr>
                </li>

                <!-- Collections -->
				<li>
					<a class="sidenav-item-link" href="{{ route('admin.collections.index') }}">
						<i class="mdi mdi-rhombus-split"></i>
						<span class="nav-text">Collections</span>
					</a>
				</li>

                
                <!-- Products -->
                <li class="has-sub">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-palette-advanced"></i>
                        <span class="nav-text">Products</span> <b class="caret"></b>
                    </a>
                    <div class="collapse">
                        <ul class="sub-menu" id="products" data-parent="#sidebar-menu">
                            <li class="">
                                <a class="sidenav-item-link" href="{{ route('superuser_addproduct') }}">
                                    <span class="nav-text">Add Product</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.my_products') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.my_products') }}">
                                    <span class="nav-text">My Products</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.inactive_products') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.inactive_products') }}">
                                    <span class="nav-text">Inactive Products</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.inactive_products') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('superuser.lowStockProducts') }}">
                                    <span class="nav-text">Low Stocks</span>
                                </a>
                            </li>
                        </ul>
                    </div>
					<hr/>
                </li>


                <!-- Orders -->
				<li>
					<a class="sidenav-item-link {{ request()->routeIs('admin.my_order') ? 'active' : '' }}" href="{{ route('admin.my_order') }}">
						<i class="mdi mdi-cart"></i>
						<span class="nav-text">My Orders</span>
					</a>
				</li>

				<hr/>

				<!-- Transactions -->
				<li>
					<a class="sidenav-item-link" href="{{ route('seller_transaction') }}">
						<i class="mdi mdi-currency-inr"></i>
						<span class="nav-text">Transactions</span>
					</a>
				</li>


            </ul>
            <!-- sidebar menu end -->
        </div>
    </div>
</div>
