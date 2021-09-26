<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Nexura Prueba</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Data Tables -->
        <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            div#DataTables_Table_0_wrapper {
                width: 100%;
            }

            table.dataTable {
                width: 100%!important;
            }
            label.error {
                color: #dc3545;
                font-size: 14px;
            }
        </style>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="container p-4">
            <h1>Lista de Empleados</h1>
            <div class="row py-4 text-right justify-content-end">
                <div class="col">
                    <button type="button" id="createEmpleado" class="btn btn-success d-block float-right" data-toggle="modal" data-target="#ajaxModal"><i class="fas fa-user-plus"></i> Crear</button>
                </div>
                
            </div>
            <div class="row py-4">
                <div class="col">
                    <table class="table empleados-table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col"><i class="fas fa-user"></i> Nombre</th>
                            <th scope="col"><i class="fas fa-at"></i> Email</th>
                            <th scope="col"><i class="fas fa-venus-mars"></i> Sexo</th>
                            <th scope="col"><i class="fas fa-briefcase"></i> Area</th>
                            <th scope="col"><i class="fas fa-envelope"></i> Boletin</th>
                            <th scope="col">Modificar</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            <br>
            
            </div>
            <!-- Modal -->
            <div class="modal fade" id="ajaxModal" tabindex="-1" aria-labelledby="ajaxModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="ajaxModalLabel">Crear Empleado</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-primary" role="alert">
                                Los campos con asteriscos (*) son obligatorios
                            </div>
                            <form id="empleadoForm" name="empleadoForm" class="form-horizontal" >
                                @csrf
                                <input type="hidden" name="id" id='id'>
                                <div class="form-group">
                                    <label for="nombre">Nombre completo <span class="text-danger">*</span></label>
                                    {!! Form::text('nombre', null, array('id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Nombre completo', 'required' => 'required' )) !!}
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                    {!! Form::email('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Correo electrónico', 'required' => 'required' )) !!}
                                </div>
                                <div class="form-group">
                                    <label for="sexo">Sexo <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexo" id="masculino" value="M" required>
                                        <label class="form-check-label" for="masculino">
                                            Masculino
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexo" id="femenino" value="F" required>
                                        <label class="form-check-label" for="femenino">
                                            Femenino
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area_id">Areas <span class="text-danger">*</span></label>
                                    {!! Form::select('area_id', $areas,[], array('id' => 'area_id', 'class' => 'form-control', 'required' => 'required' )) !!}
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="boletin" name="boletin" value="1">
                                    <label class="form-check-label" for="boletin" >Deseo recibir boletín informativo</label>
                                </div>
                                <div class="form-group ">
                                    <label for="roles">Roles <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        @foreach($roles as $value)
                                            <label>{{ Form::checkbox('roles[]', $value->id, false, array('id' => 'rol-'.$value->id, 'class' => 'form-check-input roles')) }}
                                            {{ $value->nombre }}</label>
                                            <br/>
                                        @endforeach
                                    </div>
                                </div>
                                <button id="save" type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
            <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery(function(){
                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var table = jQuery('.empleados-table').DataTable({
                        serveside:true,
                        processing:true,
                        ajax:"{{route('empleados.index')}}",
                        columns:[
                            {data:'id', name:'id'},
                            {data:'nombre', name:'nombre'},
                            {data:'email', name:'email'},
                            {data:'sexo', name:'sexo'},
                            {data:'area_id', name:'area'},
                            {data:'boletin', name:'boletin'},
                            {data:'modificar', name:'modificar'},
                            {data:'eliminar', name:'eliminar'}
                        ],
                        responsive: true,
                        "language": {
                            "decimal":        "",
                            "emptyTable":     "No hay datos",
                            "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                            "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                            "infoFiltered":   "(Filtrando de _MAX_ total de registros)",
                            "infoPostFix":    "",
                            "thousands":      ",",
                            "lengthMenu":     "Mostrar _MENU_ registros",
                            "loadingRecords": "Cargando...",
                            "processing":     "Procesando...",
                            "search":         "Buscar:",
                            "zeroRecords":    "No se encontratron registros",
                            "paginate": {
                                "first":      "Primero",
                                "last":       "Ultimo",
                                "next":       "Siguiente",
                                "previous":   "Anterior"
                            },
                            "aria": {
                            "sortAscending":  ": activar para ordenar la columna ascendente",
                            "sortDescending": ": activar para ordenar la columna descendente"
                            }
                        }
                    });
                    $('#createEmpleado').click(function(){
                        $('#id').val();
                        $('#empleadoForm').trigger("reset");
                        $('#ajaxModal').modal('show');
                    });
                    $('#save').click(function(e){
                        e.preventDefault();
                        if($('#nombre').val() == ''){
                            alert('Por favor completa el campo del Nombre');
                            $('#nombre').focus();
                        } else if($('#email').val() == ''){
                            alert('Por favor completa el campo del Correo Electronico');
                            $('#email').focus();
                        } else if ($('input:radio[name="sexo"]:checked').val() == undefined) {
                            alert('Por favor completa el campo del Sexo');
                            $('#masculino').focus();
                        } else if($('#area_id').val() == ''){
                            alert('Por favor completa el campo del Area');
                            $('#area_id').focus();
                        } else if($('#descripcion').val() == ''){
                            alert('Por favor completa el campo de la Descripcion');
                            $('#descripcion').focus();
                        } else if ($('#boletin').not(':checked').length) {
                            alert('Por favor completa el campo del boletin');
                            $('#boletin').focus();
                        } else if ($("input[name='roles[]']:checked").length == 0) {
                            alert('Por favor completa el campo del Rol');
                            $('input:radio[name^="roles"]').focus();
                        } else{
                            $(this).html('Guardar');
                            $.ajax({
                                data:$("#empleadoForm").serialize(),
                                url: "{{route('empleados.store')}}",
                                type:"POST",
                                dataType:'json',
                                cache: false,
                                crossDomain: false,
                                success:function(data){
                                    $('#empleadoForm').trigger("reset");
                                    $('#ajaxModal').modal('hide');
                                    table.ajax.reload();
                                    alert('Empleado Creado Exitosamente');
                                },
                                error:function(data){
                                    console.log('Error:', data);
                                    $("#save").html('Guardar');
                                }
                            });
                        }



                    });
                    $('body').on('click','.delete', function(){
                        var id = $(this).data("id");
                        if (confirm("Seguro que deseas borrar el empleado?")) {
                            $.ajax({
                                type:"DELETE",
                                url: "{{route('empleados.store')}}"+'/'+id,
                                success:function(data){
                                    table.ajax.reload();
                                    alert('Empleado Eliminado Exitosamente');
                                },
                                error:function(data){
                                    console.log('Error:', data)
                                }
                            })
                        }
                    });
                    $('body').on('click','.edit', function(){
                        var id = $(this).data("id");
                        $.get("{{route('empleados.index')}}"+"/"+id+"/edit",function(data){
                            console.log(data.roles);
                            //$('#ajaxModalLabel').html('Editar Empleado')
                            $('#id').val(data.empleado.id);
                            $('#nombre').val(data.empleado.nombre);
                            $('#email').val(data.empleado.email);
                            if(data.empleado.sexo == 'M'){
                                $('#masculino').prop("checked", true);
                            }
                            if(data.empleado.sexo == 'F'){
                                $('#femenino').prop("checked", true);
                            }
                            $('#area_id').val(data.empleado.area_id);

                            if(data.empleado.boletin == '1'){
                                $('#boletin').prop("checked", true);
                            }
                            $('#descripcion').val(data.empleado.descripcion);
                            if(data.empleado.boletin == '1'){
                                $('#boletin').prop("checked", true);
                            }
                            data.roles.forEach(element => {
                                //console.log(element.rol_id)
                                $('#rol-'+element.rol_id).prop("checked", true);
                            });
                            $('#ajaxModalLabel').html('Actualizar Empleado');
                            $('#ajaxModal').modal('show');
                        });
                    });
                    $('#ajaxModal').on('hidden.bs.modal', function (e) {
                        $('#empleadoForm').trigger("reset");
                    })
                })
            });
            </script>
        </footer>
    </body>
</html>
