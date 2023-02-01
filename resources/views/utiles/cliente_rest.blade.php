@extends('../layouts.frontend')
@section('title','Útiles')
@section('content')
    
   <main class="container">
 <h1>Cliente Rest</h1>
 <h2>Status: {{$status}}</h2>
 <p>{{$json}}</p>
 <p> {{print_r($headers)}}</p>
  <x-flash />
  <table class="table table-boredered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        foreach($datos as $dato)
        {
            ?>
            <tr>
                <td><?php echo $dato->nombre;?></td>
                <td><?php echo $dato->precio;?></td>
                <td><?php echo $dato->descripcion;?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

</main>

@endsection