<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : ''  }}">
      <a class="nav-link " href="{{ route('dashboard') }}">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('category.*') ? 'active' : ''  }}">
      <a class="nav-link {{ request()->routeIs('category.*') ? '' : 'collapsed'  }} " data-bs-toggle="collapse" href="#category" aria-expanded="false" aria-controls="category">
        <i class="mdi mdi-circle-outline menu-icon"></i>
        <span class="menu-title">Category</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('category.*') ? 'show' : ''  }}" id="category">
        <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link {{ request()->routeIs('category.index')  ? 'active' : ''  }}" href="{{ route('category.index')  }}">View Category</a></li>
          <li class="nav-item"> <a class="nav-link {{ request()->routeIs('category.create') ? 'active' : ''  }}" href="{{ route('category.create') }}">Add Category</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : ''  }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#product" aria-expanded="false" aria-controls="product">
        <i class="mdi mdi-circle-outline menu-icon"></i>
        <span class="menu-title">Products</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('products.*') ? 'show' : ''  }}" id="product">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : ''  }}" href="{{ route('products.index') }}">View Products</a></li>
          <li class="nav-item"> <a class="nav-link {{ request()->routeIs('products.create') ? 'active' : ''  }}" href="{{ route('products.create') }}">Add Product</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->routeIs('brand.index') ? 'active' : ''  }}">
      <a class="nav-link" href="{{ route('brand.index') }}">
        <i class="mdi mdi-chart-pie menu-icon"></i>
        <span class="menu-title">Brands</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('colors.index') ? 'active' : ''  }}">
      <a class="nav-link" href="{{ route('colors.index') }}">
        <i class="mdi mdi-chart-pie menu-icon"></i>
        <span class="menu-title">Colors</span>
      </a>
    </li>

  <li class="nav-item {{ request()->routeIs('sizes.index') ? 'active' : ''  }}">
      <a class="nav-link" href="{{ route('sizes.index') }}">
          <i class="mdi mdi-chart-pie menu-icon"></i>
          <span class="menu-title">Size</span>
      </a>
  </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="mdi mdi-account menu-icon"></i>
        <span class="menu-title">Users</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href=""> Login </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('dashboard') }}"> Login 2 </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/register-2.html"> Register 2 </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/lock-screen.html"> Lockscreen </a></li>
        </ul>
      </div>
    </li>


    <li class="nav-item {{ request()->routeIs('sliders.index') ? 'active' : ''  }}">
      <a class="nav-link" href="{{ route('sliders.index') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Home Slider</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/icons/mdi.html">
        <i class="mdi mdi-emoticon menu-icon"></i>
        <span class="menu-title">Site Setting</span>
      </a>
    </li>


  </ul>
</nav>
