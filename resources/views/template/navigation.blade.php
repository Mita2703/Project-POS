<nav class="mt-2">
  <!--begin::Sidebar Menu-->
  <ul
    class="nav sidebar-menu flex-column"
    data-lte-toggle="treeview"
    role="navigation"
    aria-label="Main navigation"
    data-accordion="false"
    id="navigation">

    <li class="nav-item menu-open">
      <a href="{{ url('/') }}" class="nav-link active">
        <i class="bi bi-shop-window"></i>
        <p>
          HOME
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('order') }}" class="nav-link active">
        <i class="bi bi-bookmark-fill"></i>
        <p>
          ORDER
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('transaction') }}" class="nav-link active">
        <i class="bi bi-cash-coin"></i>
        <p>
          TRANSAKSI
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="{{ url('category') }}" class="nav-link active">
        <i class="bi bi-tags"></i>
        <p>
          KATEGORI
        </p>
      </a>
    </li>
  </ul>
  <!--end::Sidebar Menu-->
</nav>