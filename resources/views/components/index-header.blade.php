@props(['studies' => [], 'services' => []])
<div class="container-fluid container-xl position-relative d-flex align-items-center">

  <a href="/" class="logo d-flex align-items-center me-auto">
    <!-- Uncomment the line below if you also wish to use an image logo -->
    <img src="{{ asset('img/craetive-logo.png') }}" alt="creative logo">
  </a>

  <nav id="navmenu" class="navmenu">
    <ul>
      <li><a href="/" class="{{ request()->routeIs(['index']) ? 'active' : '' }}">Beranda</a></li>
      <li class="dropdown">
        <a href="{{ route('study.index') }}" class="{{ request()->routeIs(['study.index']) ? 'active' : '' }}">
          <span>Bidang Studi</span>
          <i class="bi bi-chevron-down toggle-dropdown"></i>
        </a>
        <ul>
          @foreach($studies as $study)
        <li>
        {{-- Perbaiki route ke 'study.show' --}}
        <a href="{{ route('study.show', $study->id) }}">
          {{ $study->name }}
        </a>
        </li>
      @endforeach
        </ul>
      </li>
      </li>
      <li class="dropdown"><a href="{{ route('service.index') }}"
          class="{{ request()->routeIs(['service.index']) ? 'active' : '' }}">Layanan Jasa <i
            class="bi bi-chevron-down toggle-dropdown"></i></a>
        <ul>
          @foreach($services as $service)
        <li>
        {{-- Perbaiki route ke 'service.show' --}}
        <a href="{{ route('service.show', $service->id) }}">
          {{ $service->name }}
        </a>
        </li>
      @endforeach
        </ul>
      </li>
      <li><a href="{{ route('student_work.index') }}"
          class="{{ request()->routeIs(['student_work.index']) ? 'active' : '' }}">Karya Siswa</a></li>
      <li><a href="{{ route('testimony.index') }}"
          class="{{ request()->routeIs(['testimony.index']) ? 'active' : '' }}">Testimoni</a></li>
      <li><a href="{{ route('article.index') }}"
          class="{{ request()->routeIs(['article.index']) ? 'active' : '' }}">Artikel</a></li>
      <li><a href="{{ route('contact.index') }}"
          class="{{ request()->routeIs(['contact.index']) ? 'active' : '' }}">Hubungi Kami</a></li>
      @auth
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Welcome Back, {{ Auth::user()->name }}
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li>
        <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
          @csrf
          <button type="submit" class="pc-link" style="border: none; background: none; cursor: pointer;">
          <div class="logout-menu" id="logout-menu">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Logout</span>
          </div>
          </button>
        </form>
        </li>
      </ul>
      </li>
    @else
      <a class="cta-btn" href="{{ route('login') }}">Login</a>
    @endauth
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
  </nav>

</div>