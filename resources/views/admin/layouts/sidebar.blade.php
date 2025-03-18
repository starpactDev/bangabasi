<style>
    ul.sub-menu li.active .nav-text {
        color: #88aaf3 !important; /* Your desired color */
    }
</style>
<div class="ec-left-sidebar ec-bg-sidebar" style="font-family: Roboto, sans-serif;">
    <div id="sidebar" class="sidebar ec-sidebar-footer">

        <div class="ec- brand" id="sidebar-logo-bar" style="margin : 1rem auto;">
            <a href="{{ route('admin_dashboard') }}" title="Bongobasi">
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
                    <a class="sidenav-item-link" href="{{ route('admin_dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <hr>
                </li>

                <!-- Users -->
                <li class="has-sub {{ request()->routeIs('admin_userlist') || request()->routeIs('admin_sellerlist') ? 'active expand' : '' }} ">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-account-group"></i>
                        <span class="nav-text">Users</span> <b class="caret"></b>
                    </a>
                    <div class="collapse  {{ request()->routeIs('admin_userlist') || request()->routeIs('admin_sellerlist') ? 'show' : ''}}">
                        <ul class="sub-menu" id="products" data-parent="#sidebar-menu">
                            <li class="{{ request()->routeIs('admin_userlist') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_userlist') }}">
                                    <span class="nav-text">User List</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin_sellerlist') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{route('admin_sellerlist')}}">
                                <span class="nav-text">Seller List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr>
                </li>

                <!-- Contact Messages -->
                <li class="{{ request()->routeIs('admin.contact') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.contact') }}">
                        <i class="mdi mdi-comment-text"></i>
                        <span class=" position-relative">Message
                            <span class="unread-count position-absolute" style="top: -0.5rem; right: -1.5rem; border-radius: 1rem; background-color: red; min-width: 1.25rem; text-align: center; line-height: 1.25rem; font-size: 0.75rem;">
                                {{ Cache::get('unread_messages_count', 0) }}
                            </span>
                        </span>
                        
                    </a>
                    <hr>
                </li>
                <li class="{{ request()->routeIs('admin.newsletter') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.newsletter') }}">
                        <i class="mdi mdi-newspaper"></i>
                        <span class="nav-text">Newsletter</span>
                    </a>
                    <hr>
                </li>

                <!-- Brands -->
                <li class="{{ request()->routeIs('admin.brands.index') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.brands.index') }}">
                        <i class="mdi mdi-tag-faces"></i>
                        <span class="nav-text">Brands</span>
                    </a>
                    <hr>
                </li>

                <!-- Blogs -->
                <li class="{{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.blogs.index') }}">
                        <i class="mdi mdi-book-open-outline"></i>
                        <span class="nav-text">Blogs</span>
                    </a>
                    <hr>
                </li>

                <!-- Category -->
                <li class="has-sub {{ request()->routeIs('admin_category') || request()->routeIs('admin_category_header_images') ? 'active expand' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-dns-outline"></i>
                        <span class="nav-text">Categories</span> <b class="caret"></b>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin_category') || request()->routeIs('admin_category_header_images') ? 'show' : '' }}">
                        <ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
                            <li class="{{ request()->routeIs('admin_category') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_category') }}">
                                    <span class="nav-text">Manage Category</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin_category_header_images') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_category_header_images') }}">
                                    <span class="nav-text">Manage Header Images</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="{{ request()->routeIs('admin.collections.index') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.collections.index') }}">
                        <i class="mdi mdi-home"></i>
                        <span class="nav-text">Collections</span>
                    </a>
                    <hr>
                </li>

                <!-- create a side bar for this route ('admin.homepage') -->
                <li class="has-sub {{ request()->routeIs('admin.homepage', 'admin.header', 'admin_sale', 'admin.aboutus', 'admin.logo.index', 'admin.configuration') ? 'active expand' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-dns-outline"></i>
                        <span class="nav-text">CMS</span> <b class="caret"></b>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.homepage') || request()->routeIs('admin.header') || request()->routeIs('admin_sale') || request()->routeIs('admin.aboutus') || request()->routeIs('admin.logo.index') || request()->routeIs('admin.configuration') ? 'show' : '' }}">
                        <ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
                            <li class="{{ request()->routeIs('admin.homepage') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.homepage') }}">
                                    <span class="nav-text">Home Data</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.header') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.header') }}">
                                    <span class="nav-text">Header Data</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin_sale') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_sale') }}">
                                    <span class="nav-text">Sale Banner</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.aboutus') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.aboutus') }}">
                                    <span class="nav-text">About Us</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.logo.index') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.logo.index') }}">
                                    <span class="nav-text">Logos</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.configuration') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.configuration') }}">
                                    <span class="nav-text">Configuration</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                
                <!-- Products -->
                <li class="has-sub {{ request()->routeIs('superuser_addproduct') || request()->routeIs('admin_viewproduct') || request()->routeIs('admin.my_products') || request()->routeIs('admin.inactive_products') || request()->routeIs('superuser.lowStockProducts') ? 'active expand' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-palette-advanced"></i>
                        <span class="nav-text">Products</span> <b class="caret"></b>
                    </a>
                    <div class="collapse {{ request()->routeIs('superuser_addproduct') || request()->routeIs('admin_viewproduct') || request()->routeIs('admin.my_products') || request()->routeIs('admin.inactive_products') || request()->routeIs('superuser.lowStockProducts') ? 'show' : '' }}">
                        <ul class="sub-menu" id="products" data-parent="#sidebar-menu">
                            <li class="{{ request()->routeIs('superuser_addproduct') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('superuser_addproduct') }}">
                                    <span class="nav-text">Add Product</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin_viewproduct') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_viewproduct') }}">
                                    <span class="nav-text">All Products</span>
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
                            <li class="{{ request()->routeIs('superuser.lowStockProducts') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('superuser.lowStockProducts') }}">
                                    <span class="nav-text">Low Stocks</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="{{ request()->routeIs('admin.review.index') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.review.index') }}">
                        <i class="mdi mdi-star-half"></i>
                        <span class="nav-text" >Manage Reviews</span>
                    </a>
                    <hr>
                </li>
                <li class="{{ request()->routeIs('admin.product.section') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.product.section') }}">
                        <i class="mdi mdi-cards-variant"></i>
                        <span class="nav-text" >PRODUCT SECTION</span>
                    </a>
                    <hr>
                </li>

                <!-- Orders -->
                <li class="has-sub {{ request()->routeIs('admin_orderlist') || request()->routeIs('admin.my_order') ? 'active expand' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-cart"></i>
                        <span class="nav-text">Orders</span> <b class="caret"></b>
                    </a>
                
                    <div class="collapse {{ request()->routeIs('admin_orderlist') || request()->routeIs('admin.my_order') ? 'show' : '' }}">
                        <ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
                            <li class="{{ request()->routeIs('admin_orderlist') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_orderlist') }}">
                                    <span class="nav-text">Order List</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.my_order') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.my_order') }}">
                                    <span class="nav-text">My Orders</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr />
                </li>
                

                <!-- Transactions -->
                <li class="has-sub {{ request()->routeIs('admin_transaction') ? 'active expand' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)">
                        <i class="mdi mdi-currency-inr"></i>
                        <span class="nav-text">Transactions</span> <b class="caret"></b>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin_transaction') ? 'show' : '' }}">
                        <ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
                            <li class="{{ request()->routeIs('admin_transaction') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin_transaction') }}">
                                    <span class="nav-text">Transaction List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
            <!-- sidebar menu end -->
        </div>
    </div>
</div>
