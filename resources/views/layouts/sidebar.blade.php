<style>
        .sidebar {
            /*background-color: #343a40;  Sidebar background color */
            background-color: #eeeeef;
            color: #fff; /* Text color */
            height: 100%;
            min-height: 640px;
            min-width: 245px;
        }

        .sidebar .nav-link {
            color: #fff; /* Default link text color */
        }

        .sidebar .nav-link.active {
           /* background-color: #007bff;  Active link background color */
           background-color: #565e64;
           color: #fff !important;
        }
        .form-check-single {
            display: grid;
            grid-template-columns: auto 1fr;
        }
    </style>
<!-- Sidebar -->
<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }} text-dark" href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/tackback') ? 'active' : '' }} text-dark" href="{{ route('admin.tackbacklist') }}">
                Tackback Products
            </a>
        </li>
        <li class="nav-item">
            {{-- admin/tackback-store/create* --}}
            {{-- {{ request()->is('admin/tackback-store/*') ? 'active' : '' }} --}}
            <a class="nav-link {{ request()->is('admin/tackback-store/*') ? 'active' : '' }} text-dark" href="{{ route('admin.stores.create') }}">
                {{-- Tackback Store --}}
                Sorting
            </a>
            <a class="nav-link {{ request()->is('admin/tackback-shipment-list/save-list') ? 'active' : '' }} text-dark" href="{{ route('admin.stores.saveList') }}">
                {{-- Tackback Store --}}
                Shipment List
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/brands/create') ? 'active' : '' }} text-dark" href="{{ route('brands.create') }}">
                Brand
            </a>
        </li>
        <!-- Add more menu items here -->
    </ul>
</div>