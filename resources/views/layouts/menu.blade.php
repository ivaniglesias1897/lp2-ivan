<!-- barra laterar izquierda -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Inicio</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('clientes.index') }}" class="nav-link {{ Request::is('clientes*') ? 'active' : '' }}">
        <i class="fa fa-users"></i>
        <p>Clientes</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('ventas.index') }}" class="nav-link {{ Request::is('ventas*') ? 'active' : '' }}">
        <i class="fa fa-shopping-basket"></i>
        <p>Ventas</p>
    </a>
</li>
<!-- Mostrar colapsado si esta en una de estas opciones del menu tanto en la etiqueta <li> como en la etiqueta ul -->
<li class="nav-item {{ 
Request::is('users*') || 
Request::is('cargos*') || 
Request::is('departamentos*') || 
Request::is('ciudades*') || 
Request::is('proveedores*') ||
Request::is('marcas*') || 
Request::is('productos*') || 
Request::is('sucursales*') || 
Request::is('cajas*') 
? 'menu-is-opening menu-open' : '' }}
">
    <a href="#" class="nav-link">
        <i class="fas fa-cogs"></i>
        <p>
            Configuraciones
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ 
    Request::is('users*')||
    Request::is('cargos*')||
    Request::is('departamentos*')||
    Request::is('ciudades*')||
    Request::is('proveedores*')||
    Request::is('marcas*')||
    Request::is('productos*')||
    Request::is('sucursales*')||
    Request::is('cajas*') ? 'block;' : 'none;' }};">
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <p>Usuarios</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('cargos.index') }}" class="nav-link {{ Request::is('cargos*') ? 'active' : '' }}">
                <i class="far fa-address-card"></i>
                <p>Cargos</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('departamentos.index') }}"
                class="nav-link {{ Request::is('departamentos*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt	"></i>
                <p>Departamentos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('proveedores.index') }}"
                class="nav-link {{ Request::is('proveedores*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                <p>Proveedores</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('marcas.index') }}" class="nav-link {{ Request::is('marcas*') ? 'active' : '' }}">
                <i class="fa fa-tags"></i>
                <p>Marcas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ciudades.index') }}" class="nav-link {{ Request::is('ciudades*') ? 'active' : '' }}">
                <i class="fas fa-city"></i>
                <p>Ciudades</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('productos.index') }}" class="nav-link {{ Request::is('productos*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <p>Productos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sucursales.index') }}"
                class="nav-link {{ Request::is('sucursales*') ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                <p>Sucursales</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('cajas.index') }}" class="nav-link {{ Request::is('cajas*') ? 'active' : '' }}">
                <i class="fa fa-cash-register"></i>
                <p>Caja</p>
            </a>
        </li>
    </ul>
</li>
