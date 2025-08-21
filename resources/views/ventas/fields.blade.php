<!-- Id Apertura Field -->
{!! Form::hidden('id_apertura', null, ['class' => 'form-control']) !!}

<!-- Fecha Venta Field -->
<div class="form-group col-sm-4">
    {!! Form::label('fecha_venta', 'Fecha Venta:') !!}
    {!! Form::date('fecha_venta', \Carbon\Carbon::now()->format('Y-m-d'), [
        'class' => 'form-control',
        'id' => 'fecha_venta',
        'required',
        'readonly',
    ]) !!}
</div>

<!-- Factura Nro Field -->
<div class="form-group col-sm-4">
    {!! Form::label('factura_nro', 'Factura Nro:') !!}
    {!! Form::text('factura_nro', null, ['class' => 'form-control', 'readonly']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('user_id', 'Responsable:') !!}
    {!! Form::text('user_id', $usuario, ['class' => 'form-control', 'readonly']) !!}
    {!! Form::hidden('user_id', auth()->user()->id, ['class' => 'form-control']) !!}
</div>

<!-- Id Cliente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_cliente', 'Cliente:') !!}
    {!! Form::select('id_cliente', $clientes, null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Seleccione el Cliente',
    ]) !!}
</div>

<!-- Condicion venta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('condicion_venta', 'Condicion de Venta:') !!}
    {!! Form::select('condicion_venta', $condicion_venta, null, [
        'class' => 'form-control',
        'id' => 'condicion_venta',
        'required',
    ]) !!}
</div>

<!-- Intervalo de Vencimiento Field -->
<div class="form-group col-sm-6 " id="div_intervalo" style="display: none">
    {!! Form::label('intervalo_vencimiento', 'Intervalo de vencimiento:') !!}
    {!! Form::select('intervalo_vencimiento', $intervalo_vencimiento, null, [
        'class' => 'form-control',
        'placeholder' => 'Seleccione una intervalo',
    ]) !!}
</div>

<!-- Cantidad cuota Field -->
<div class="form-group col-sm-6 " id="div_cantidad_cuota" style="display: none">
    {!! Form::label('cantidad_cuota', 'Cantidad cuota:') !!}
    {!! Form::number('cantidad_cuota', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese la cantidad de cuotas',
    ]) !!}
</div>

<!-- Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::number('total', null, ['class' => 'form-control']) !!}
</div>

<!-- Js -->
@push('scripts')
    <script>
        //comenzar la carga con document ready
        $(document).ready(function() {
          $('#condicion_venta').on('change', function() {
              var condicion_venta = $(this).val();
            if (condicion_venta == "CONTADO") {
                $('#div_intervalo').hide();
                $('#div_cantidad_cuota').hide();
            } else {
                $('#div_intervalo').show();
                $('#div_cantidad_cuota').show();
            }
          });  
        });
    </script>
@endpush
