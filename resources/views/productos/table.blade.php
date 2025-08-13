<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="productos-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Tipo IVA</th>
                    <th>Marca</th>
                    <th colspan="3">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id_producto }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ number_format($producto->precio, 0, '', '.') }}</td>
                        <td>{{ $producto->tipo_iva }}</td>
                        <td>{{ $producto->marcas }}</td>
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['productos.destroy', $producto->id_producto], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('productos.edit', [$producto->id_producto]) }}"
                                    class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('Desea borrar el producto?')",
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            {{-- @include('adminlte-templates::common.paginate', ['records' => $productos]) --}}
        </div>
    </div>
</div>
