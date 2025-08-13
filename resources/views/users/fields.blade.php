<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre y Apellido:') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ingrese el Nombre y Apellido',
    ]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Nick Name:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese el Nick Name']) !!}
</div>

<!-- password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Ingrese la Contraseña:') !!}
    {!! Form::password('password', [
        'class' => 'form-control',
        isset($users) ? '' : 'required',
        'placeholder' => isset($user) ? 'Dejar vacio sino se actualiza' : 'Ingrese la Contraseña',
    ]) !!}
</div>

<!-- Ci Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ci', 'Nro. Documento:') !!}
    {!! Form::text('ci', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ingrese el Nro. Documento',
    ]) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::textarea('direccion', null, [
        'class' => 'form-control',
        'rows' => '3',
        'placeholder' => 'Ingrese la Direccion',
    ]) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Telefono']) !!}
</div>

<!-- Fecha Ingreso Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_ingreso', 'Fecha Ingreso:') !!}
    {!! Form::date('fecha_ingreso', null, ['class' => 'form-control', 'id' => 'fecha_ingreso', 'required']) !!}
</div>
