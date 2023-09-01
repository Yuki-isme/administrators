<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('admin/assets/img/icons/dashboard.svg') }}"
                            alt="img"><span>
                            Dashboard</span> </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Product</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'show active' : '' }}">Product List</a></li>
                        <li><a href="{{ route('products.create') }}" class="{{ request()->routeIs('products.create') ? 'show active' : '' }}">Add Product</a></li>
                        @if (request()->routeIs('products.edit'))
                            <li><a href="" class="show active">Edit Product</a></li>
                        @endif
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Category</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'show active' : '' }}">Category List</a></li>
                        <li><a href="{{ route('categories.create') }}" class="{{ request()->routeIs('categories.create') ? 'show active' : '' }}">Add Category</a></li>
                        <li><a href="{{ route('categories.sub_index') }}" class="{{ request()->routeIs('categories.sub_index') ? 'show active' : '' }}">Sub Category List</a></li>
                        <li><a href="{{ route('categories.sub_create') }}" class="{{ request()->routeIs('categories.sub_create') ? 'show active' : '' }}">Add Sub Category</a></li>
                        @if (request()->routeIs('categories.edit'))
                            <li><a href="" class="show active">Edit Category</a></li>
                        @elseif(request()->routeIs('categories.sub_edit'))
                            <li><a href="" class="show active">Edit Sub Category</a></li>
                        @endif
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Brand</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.index') ? 'show active' : '' }}">Brand List</a></li>
                        <li><a href="{{ route('brands.create') }}" class="{{ request()->routeIs('brands.create') ? 'show active' : '' }}">Add Brand</a></li>
                        @if (request()->routeIs('brands.edit'))
                            <li><a href="" class="show active">Edit Brand</a></li>
                        @endif
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Tag</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.index') ? 'show active' : '' }}">Tag List</a></li>
                        <li><a href="{{ route('brands.create') }}" class="{{ request()->routeIs('brands.create') ? 'show active' : '' }}">Add Tag</a></li>
                    </ul>
                </li>
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/sales1.svg') }}"
                            alt="img"><span>
                            Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="saleslist.html">Sales List</a></li>
                        <li><a href="pos.html">POS</a></li>
                        <li><a href="pos.html">New Sales</a></li>
                        <li><a href="salesreturnlists.html">Sales Return List</a></li>
                        <li><a href="createsalesreturns.html">New Sales Return</a></li>
                    </ul>
                </li> --}}
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/purchase1.svg') }}"
                            alt="img"><span>
                            Order</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="purchaselist.html">Order List</a></li>
                        <li><a href="addpurchase.html">Order Success</a></li>
                        <li><a href="addpurchase.html">Order Processing</a></li>
                        <li><a href="importpurchase.html">Order Cancel</a></li>
                    </ul>
                </li>
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/expense1.svg') }}"
                            alt="img"><span>
                            Expense</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="expenselist.html">Expense List</a></li>
                        <li><a href="createexpense.html">Add Expense</a></li>
                        <li><a href="expensecategory.html">Expense Category</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/quotation1.svg') }}"
                            alt="img"><span>
                            Quotation</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="quotationList.html">Quotation List</a></li>
                        <li><a href="addquotation.html">Add Quotation</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/transfer1.svg') }}"
                            alt="img"><span>
                            Transfer</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="transferlist.html">Transfer List</a></li>
                        <li><a href="addtransfer.html">Add Transfer </a></li>
                        <li><a href="importtransfer.html">Import Transfer </a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/return1.svg') }}"
                            alt="img"><span>
                            Return</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="salesreturnlist.html">Sales Return List</a></li>
                        <li><a href="createsalesreturn.html">Add Sales Return </a></li>
                        <li><a href="purchasereturnlist.html">Purchase Return List</a></li>
                        <li><a href="createpurchasereturn.html">Add Purchase Return </a></li>
                    </ul>
                </li> --}}
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/places.svg') }}"
                            alt="img"><span>
                            Places</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="newcountry.html">New Country</a></li>
                        <li><a href="countrieslist.html">Countries list</a></li>
                        <li><a href="newstate.html">New State </a></li>
                        <li><a href="statelist.html">State list</a></li>
                    </ul>
                </li>
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Application</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="chat.html">Chat</a></li>
                        <li><a href="calendar.html">Calendar</a></li>
                        <li><a href="email.html">Email</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/time.svg') }}"
                            alt="img"><span>
                            Report</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="purchaseorderreport.html">Purchase order report</a></li>
                        <li><a href="inventoryreport.html">Inventory Report</a></li>
                        <li><a href="salesreport.html">Sales Report</a></li>
                        <li><a href="invoicereport.html">Invoice Report</a></li>
                        <li><a href="purchasereport.html">Purchase Report</a></li>
                        <li><a href="supplierreport.html">Supplier Report</a></li>
                        <li><a href="customerreport.html">Customer Report</a></li>
                    </ul>
                </li> --}}
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/users1.svg') }}"
                            alt="img"><span>
                            Users</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admins.index') }}" class="{{ request()->routeIs('admins.index') ? 'show active' : '' }}">Users List</a></li>
                        <li><a href="{{ route('admins.create') }}" class="{{ request()->routeIs('admins.create') ? 'show active' : '' }}">New User </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/users1.svg') }}"
                            alt="img"><span>
                            Admin</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admins.index') }}" class="{{ request()->routeIs('admins.index') ? 'show active' : '' }}">Admin List</a></li>
                        <li><a href="{{ route('admins.create') }}" class="{{ request()->routeIs('admins.create') ? 'show active' : '' }}">New Admin</a></li>
                        <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.index') ? 'show active' : '' }}">Roles List</a></li>
                        <li><a href="{{ route('roles.create') }}" class="{{ request()->routeIs('roles.create') ? 'show active' : '' }}">New Role</a></li>
                        <li><a href="{{ route('permissions.index') }}" class="{{ request()->routeIs('permissions.index') ? 'show active' : '' }}">Permissions List</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/settings.svg') }}"
                            alt="img"><span>
                            Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        {{-- <li><a href="generalsettings.html">General Settings</a></li>
                        <li><a href="emailsettings.html">Email Settings</a></li>
                        <li><a href="paymentsettings.html">Payment Settings</a></li>
                        <li><a href="currencysettings.html">Currency Settings</a></li>
                        <li><a href="grouppermissions.html">Group Permissions</a></li>
                        <li><a href="taxrates.html">Tax Rates</a></li> --}}
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
