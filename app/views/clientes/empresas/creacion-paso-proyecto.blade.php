@extends('menu')

@section('escritorio')

@include('clientes.empresas/pasos')

<div>
<br/>

@include('errores', array('errors' => $errors))
{{ Form::model($proyecto, $accion) }}


    {{Form::hidden('empresa_id', null)}}

<div class="row">
        @if(isset($imprimir))
            <div class="panel-heading">
                <a href="{{route('f1PDF', $proyecto->empresa_id)}}" target="_blank">Imprimir F1</a>
            </div>
        @endif
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            {{ Form::label('nombre', 'Nombre de Proyecto:', array('class' => 'control-label col-md-4')) }}
                            <div class="col-md-8">
                                {{Form::text('nombre', null, array('class' => 'form-control'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('descripcion', 'Impacto:', array('class' => 'control-label col-md-4')) }}
                            <div class="col-md-8">
                                {{Form::textarea('descripcion', null, array('class' => 'form-control', 'rows' => '4'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('fechaInicio', 'Fecha Inicio:', array('class' => 'control-label col-md-4')) }}
                            <div class="col-md-8">
                                <input type="date" name="fechaInicio" class="form-control"  value="{{$proyecto->fechaInicio}}">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('fechaFin', 'Fecha Fin:', array('class' => 'control-label col-md-4')) }}
                            <div class="col-md-8">
                                <input type="date" name="fechaFin" class="form-control"  value="{{$proyecto->fechaFin}}">
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            {{ Form::label('indicadores', 'Indicadores del Proyecto:', array('class' => 'control-label col-md-3')) }}
                            <div class="col-md-9">
                            {{ Form::select('indicadores[]', $indicadores, $proyecto->indicator, array('class' => 'chosen-select form-control ', 'multiple' => 'true', 'data-placeholder' => 'Indicadores Proyecto' )) }}
                            </div>
                        </div>        
                        <div class="form-group">
                            {{ Form::label('meta', 'Meta:', array('class' => 'control-label col-md-3')) }}
                            <div class="col-md-9">
                                {{Form::textarea('meta', null, array('class' => 'form-control', 'rows' => '3'))}}
                            </div>
                        </div>             
                        <div class="form-group">
                            {{ Form::label('actividades', 'Actividades:', array('class' => 'control-label col-md-3')) }} 
                            <a id="addActividad" class="btn btn-primary pull-left"> + </a>
                            <div class="col-md-12 productos">
                                @foreach($proyecto->actividades as $actividad)
                                    <div class="row">
                                        <div class="col-md-5">
                                            {{ Form::text('activities[]', $actividad->nombre,  array('class' => 'form-control ', 'placeholder' => 'Actividad' )) }}
                                        </div>
                                        <div class="col-md-3">
                                            {{Form::select('encargado[]', array( 
                                                                            1 => 'Asesor', 
                                                                            2 => 'Cliente', 
                                                                            3 => 'Consultor', 
                                                                            4 => 'Docente', 
                                                                            5 => 'Alumnos'), 
                                                            $actividad->encargado, array('class' => 'form-control'))}}
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" name="fecha[]" class="form-control" value="{{$actividad->fecha}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div
        <br>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <center>
                        <a href="javascript:history.back()">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                         Anterior
                        </a>
                        </center>
                    </div>
                    <div class="col-xs-6">
                        <center>
                        <button type="submit" tabindex="11" class="btn btn-primary ladda-button" data-style="expand-right">
                        Siguiente
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="ladda-spinner"></span><span class="ladda-spinner"></span>
                        </button>
                        </center>
                    </div>          
            </div>
        </div>
    </div>
</div>


{{Form::close()}}
@stop


@section('script')

<script type="text/javascript">
	
	var num=1;
    $('#addActividad').on('click', function(){
        caja();
    })

    function caja(){
       // rn 1;
        var caja = "<div class='row'> <div class='col-md-5'>"
        //caja += " {{ Form::text('actividades[]', null,  array('class' => 'form-control ', 'placeholder' => 'Actividad a desarrollar' )) }}"
        caja += "<input type='text' name='activities[]' class='form-control' placeholder='Actividad a desarrollar'> "
        caja += "</div>"
        caja += "<div class='col-md-3'>"
        //caja += " {{Form::select('encargado', array('', 'Asesor', 'Cliente', 'Consultor', 'Docente', 'Alumnos'), 'Asesor', array('class' => 'form-control'))}}"
        caja += "<select class='form-control' name='encargado[]'><option value='1'>Asesor</option><option value='2'>Cliente</option><option value='3'>Consultor</option><option value='4'>Docente</option><option value='5'>Alumnos</option></select>"
        caja += "</div>"
        caja += "<div class='col-md-4'>"
        caja += "   <input type='date' name='fecha[]' class='form-control'>"
            caja += "</div>"
        caja += "</div>"
        $('.productos').appendPolyfill(caja)
        num++;
    }

   caja()

</script>

@stop