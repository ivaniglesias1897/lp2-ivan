<!-- Id Apertura Field -->
<div class="col-sm-12">
    {!! Form::label('id_apertura', 'Id Apertura:') !!}
    <p>{{ $ventas->id_apertura }}</p>
</div>

<!-- Id Cliente Field -->
<div class="col-sm-12">
    {!! Form::label('id_cliente', 'Id Cliente:') !!}
    <p>{{ $ventas->id_cliente }}</p>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $ventas->total }}</p>
</div>

<!-- Fecha Venta Field -->
<div class="col-sm-12">
    {!! Form::label('fecha_venta', 'Fecha Venta:') !!}
    <p>{{ $ventas->fecha_venta }}</p>
</div>

<!-- Factura Nro Field -->
<div class="col-sm-12">
    {!! Form::label('factura_nro', 'Factura Nro:') !!}
    <p>{{ $ventas->factura_nro }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $ventas->user_id }}</p>
</div>

