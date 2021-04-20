<nav id="sidebarMenu" style="position: sticky; top: 3.4rem; z-index: 100; height: calc(100vh - 3.8em) "
  class="col-md-3 col-lg-2 bg-dark sidebar px-0 collapse">
  <div class="d-flex flex-column justify-content-between align-items-center sidebar-sticky  pt-3 w-100 h-100">
    <ul class="nav navbar-dark flex-column" id="sidebarUl">
      <li class="nav-item">
        <a class="nav-link text-light" href="{{route('home')}}">
          {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-home">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg> --}}
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a style="cursor: pointer" class="nav-link text-light" data-toggle="collapse" data-target="#administracion"
          aria-controls="administracion">
          Administracion
        </a>
        {{-- Etiqueta nivel 2  --}}
        <div id="administracion" class="nav-link text-dark collapse py-0">
          <ul class="ml-5 nav-item navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('clientes.index') }}">
                {{ __('Clientes') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('empleados.index') }}">
                {{ __('Empleados') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('pedidos.index') }}">
                {{ __('Pedidos') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('servicios.index') }}">
                {{ __('Servicios') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('paquetes.index') }}">
                {{ __('Paquetes') }}
              </a>
            </li>
          </ul>
        </div>
        {{-- Etiqueta nivel 2  --}}
      </li>
      <li class="nav-item">
        <a style="cursor: pointer" class="nav-link text-light" data-toggle="collapse" data-target="#logistica"
          aria-controls="logistica">
          Logistica
        </a>
        {{-- Etiqueta nivel 2  --}}
        <div id="logistica" class="nav-link text-dark collapse py-0">
          <ul class="ml-5 nav-item navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('transportes.index') }}">
                {{ __('Transportes') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('taller.index') }}">
                {{ __('Taller') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('revisiones.index') }}">
                {{ __('Calidad') }}
              </a>
            </li>
          </ul>
        </div>
        {{-- Etiqueta nivel 2  --}}
      </li>
    </ul>
  </div>
</nav>
<nav id="sidebarMenu2" style="position: sticky; top: 3.4rem; z-index: 100; height: calc(100vh - 3.8em) "
  class="d-none d-md-block overflow-auto col-md-3 col-lg-2 bg-dark px-0 show">
  <div class="d-flex flex-column justify-content-between align-items-center sidebar-sticky  pt-3 w-100 h-100">
    <ul class="nav navbar-dark flex-column" id="sidebarUl">
      <li class="nav-item">
        <a class="nav-link text-light" href="{{route('home')}}">
          {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-home">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg> --}}
          Dashboard
        </a>
      </li>
      {{-- Etiqueta nivel 1 Administracion  --}}
      <li class="nav-item">
        <a style="cursor: pointer" class="nav-link text-light" data-toggle="collapse" data-target="#administracion"
          aria-controls="administracion">
          Administracion
        </a>
        {{-- Etiqueta nivel 2  --}}
        <div id="administracion" class="nav-link text-dark collapse py-0">
          <ul class="ml-5 nav-item navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('clientes.index') }}">
                {{ __('Clientes') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('empleados.index') }}">
                {{ __('Empleados') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('pedidos.index') }}">
                {{ __('Pedidos') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('servicios.index') }}">
                {{ __('Servicios') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('paquetes.index') }}">
                {{ __('Paquetes') }}
              </a>
            </li>
          </ul>
        </div>
        {{-- Etiqueta nivel 2  --}}
      </li>
      <li class="nav-item">
        <a style="cursor: pointer" class="nav-link text-light" data-toggle="collapse" data-target="#logistica"
          aria-controls="logistica">
          Logistica
        </a>
        {{-- Etiqueta nivel 2  --}}
        <div id="logistica" class="nav-link text-dark collapse py-0">
          <ul class="ml-5 nav-item navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('transportes.index') }}">
                {{ __('Transportes') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('taller.index') }}">
                {{ __('Taller') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('revisiones.index') }}">
                {{ __('Calidad') }}
              </a>
            </li>
          </ul>
        </div>
        {{-- Etiqueta nivel 2  --}}
      </li>
    </ul>
  </div>
</nav>