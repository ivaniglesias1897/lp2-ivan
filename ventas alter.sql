-- Alter ventas
Alter table ventas add column condicion_venta varchar(50);
Alter table ventas add column intervalo integer default 0
comment on column ventas.intervalo 
is 'intervalo para saber cada cuendo sera el vencimiento solo para creditos';
Alter table ventas add column cantidad_cuotas integer default 0;
Alter table ventas add column estado varchar(30);