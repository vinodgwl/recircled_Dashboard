<style>
        .sidebar {
            background-color: #343a40; /* Sidebar background color */
            color: #fff; /* Text color */
            height: 100%;
            min-height: 640px;
            min-width: 245px;
        }

        .sidebar .nav-link {
            color: #fff; /* Default link text color */
        }

        .sidebar .nav-link.active {
            background-color: #007bff; /* Active link background color */
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
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" href="{{ route('admin.tackbacklist') }}">
                Tackback Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" href="{{ route('admin.stores.create') }}">
                Tackback Store
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" href="{{ route('brands.create') }}">
                Brand
            </a>
        </li>
        <!-- Add more menu items here -->
    </ul>
</div>