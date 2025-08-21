<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="ventas-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ci/Ruc</th>
                    <th>Cliente</th>
                    <th>Fecha Venta</th>
                    <th>Factura Nro</th>
                    <th>Total</th>
                    <th>Usuario</th>
                    <th colspan="3">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id_venta }}</td>
                        <td>{{ $venta->clie_ci }}</td>
                        <td>{{ $venta->cliente }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                        <td>{{ $venta->factura_nro }}</td>
                        <td>{{ number_format($venta->total, 0, '', '.') }}</td>
                        <td>{{ $venta->usuario }}</td>
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['ventas.destroy', $ventas->id_venta], 'method' => 'delete']) !!}
                            <div class='btn-group'>

                                <a href="{{ route('ventas.show', [$ventas->id_venta]) }}" 
                                    class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>

                                <a href="{{ route('ventas.edit', [$ventas->id_venta]) }}"
                                    class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('Desea anular la venta?')",
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
            {{-- @include('adminlte-templates::common.paginate', ['records' => $ventas]) --}}
        </div>
    </div>
</div>
