<nav id="sidebarMenu" class="sidebar-wrapper navbar-dark bg-dark sidebar px-0">
  <div class="d-flex flex-column justify-content-between align-items-center navbar-dark bg-dark  pt-3 w-100 h-100">
    <ul class="nav navbar-dark flex-column">
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
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('repuestos.index') }}">
                {{ __('Repuestos') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="{{ route('pruebas.index') }}">
                {{ __('Pruebas') }}
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