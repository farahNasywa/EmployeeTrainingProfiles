<!--begin::Sidebar Toggle Button (mobile / below lg)-->
<!-- This uses AdminLTE's OFFICIAL mechanism (adminlte.js already handles this click
     automatically via the data-lte-toggle="sidebar" attribute). Don't add any other
     custom CSS/JS to open/close the sidebar, to avoid conflicting with AdminLTE's
     built-in system. -->
<button
  type="button"
  class="btn d-lg-none position-fixed top-0 start-0 m-2"
  style="z-index: 1055; background:#0F3387; color:#fff; width:42px; height:42px; border-radius:8px; display:flex; align-items:center; justify-content:center;"
  data-lte-toggle="sidebar"
  aria-label="Open menu"
>
  <i class="bi bi-list fs-5"></i>
</button>
<!--end::Sidebar Toggle Button-->

<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="./index.html" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="{{ asset('img/logobpma.png') }}"
        alt="BPMA Logo"
        class="brand-image opacity-75 shadow"
      />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      {{-- <p class="brand-text">EMPLOYEE TRAINING PROFILES</p> --}}
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
      >
        <li class="nav-item">
          <a href="{{ route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : ''}}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.daftarpegawai')}}" class="nav-link">
            <i class="nav-icon bi bi-palette"></i>
            <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Employee List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link {{ request()->routeIs('admin.deputies.*') || request()->routeIs('admin.divisions.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-pencil-square"></i>
            <p>
              Organizational Structure
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.deputies.index') }}" class="nav-link {{ request()->routeIs('admin.deputies.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Deputies</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.divisions.index') }}" class="nav-link {{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Divisions</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link {{ request()->routeIs('admin.trainings.*') || request()->routeIs('admin.employee-trainings.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-box-seam-fill"></i>
            <p>
              Training
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.trainings.index') }}" class="nav-link {{ request()->routeIs('admin.trainings.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Training List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.employee-trainings.index') }}" class="nav-link {{ request()->routeIs('admin.employee-trainings.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Employee Training List</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-clipboard-fill"></i>
            <p>
              Categories & Subcategories
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Category List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.subcategories.index') }}" class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Subcategory List</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link {{ request()->routeIs('admin.recommendation-types.*') || request()->routeIs('admin.training-recommendations.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-tree-fill"></i>
            <p>
              Recommendations
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.recommendation-types.index') }}" class="nav-link {{ request()->routeIs('admin.recommendation-types.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Recommendation List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.training-recommendations.index') }}" class="nav-link {{ request()->routeIs('admin.training-recommendations.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p class="text-nowrap overflow-hidden text-overflow-ellipsis">Employee Recommendation List</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>
              User List
            </p>
          </a>
        </li>
        <li class="nav-item mt-3 mb-3">
          <form action="{{ route('logout') }}" method="POST" class="px-2">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
          </form>
        </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->

<style>
  /* Prevent odd horizontal scroll inside the sidebar */
  .app-sidebar {
    overflow-x: hidden;
  }

  .sidebar-menu .nav-link p {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .sidebar-menu .btn-danger {
    width: 100%;
    padding: 10px;
    font-weight: bold;
    border-radius: 4px;
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .sidebar-menu .btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
  }

  /* Add space at the top so content (title, buttons, etc.) isn't covered
     by the fixed-position sidebar toggle button in the top-left corner on mobile. */
  @media (max-width: 991.98px) {
    .app-main {
      padding-top: 56px;
    }
  }

  /* Just cosmetic font/padding adjustments on small phones.
     Sidebar open/close is fully handled by native AdminLTE, not touched here. */
  @media (max-width: 575.98px) {
    .sidebar-menu .nav-link {
      padding-top: 0.65rem;
      padding-bottom: 0.65rem;
    }

    .sidebar-menu .nav-link p {
      font-size: 0.9rem;
    }
  }
</style>