<h3>Texto  = {{$texto}}</h3>
{{-- This comment will not be present in the rendered HTML --}}


<h3>Declarar variables</h3>
@php
    $contador = 1;
@endphp

<h4>{{$contador}}</h4>
<hr>
<h3>Condicional 1</h3>
@if($numero==13)
<h3>Número es 13</h3>
@else
<h3>Número no es 13</h3>
@endif
<hr>
<h3>Condicional 2 (switch case)</h3>
@switch($numero)
    @case(11)
        Es 11
        @break
 
    @case(12)
        Es 12
        @break
 
    @default
        No es ninguno
@endswitch
<hr>
<h3>Condicional 3 (Operador ternario)</h3>
<h4>{{($numero==12) ? 'es 12':'no es 12'}}</h4>
<hr>
<h3>Ciclo for</h3>
<ul>
@for ($i = 1; $i <= 10; $i++)
   <li> {{ $i }}</li>
@endfor
</ul>

<hr>
<h3>Países</h3>
 
<ul>
  @foreach ($paises as $pais)
      <li>{{$loop->first}} - {{$loop->last}} - {{$loop->index}} - {{$pais['nombre'] . ' | ' .$pais['dominio']}}</li>
  @endforeach
</ul>
 
<x-componente :mensaje="$texto"/>
<hr>
@include('home.incluido')