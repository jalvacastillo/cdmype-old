<?php

/*
	utilizado para guardar las ofertas a los consultores
	Imprimir el contrato
	Imprimir el acta
	Dar por finalizada la at.	
*/

class pasoFinalController extends BaseController{
	
    public function oferta($id)
    {
        $id2 = Math::to_base_10($id, 62) - 100000;

        //return $id;
        $at = AtTermino::find($id2);
        $consultores =  $at
                        ->consultores()
                        ->paginate();


        $pasoActual = 4;
        $pasoReal = $at->pasoReal;
        return View::make('asistencia-tecnica/creacion-paso-4', 
                compact('consultores', 'id', 'pasoActual', 'id', 'pasoReal'));
    }

    public function ofertasGuardar($id){
        $id2 = Math::to_base_10($id, 62) - 100000;
        $ofertas = Input::file('ofertas');

        //return $ofertas;

        $consultores = Input::get('consultores');

        //return $consultores;
       // $fil = "";
        $file = 0;
        $ofertantes = 0;
        foreach ($consultores as $consultor) {
            if($ofertas[$file]){
                $atConsultor = atConsultor::find($consultor);
                $atConsultor->doc_oferta = $this->guardarOferta($ofertas[$file]);
                $atConsultor->save();
                $ofertantes++;
            }
            $file++;
        }

        if($ofertantes > 0){
            $at = AtTermino::find($id2);
            $at->estado = 3;
            $at->save();
            return Redirect::route('atPaso', $id2);
        }
        
        return Redirect::route('atPasoOferta', $id);
    }


    private function guardarOferta($file){
        $destinationPath = 'assets/ofertas/';
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
        return $fileName;
    }
 

    public function consultor($id){

        $id2 = Math::to_base_10($id, 62) - 100000;
        $at = AtTermino::find($id2);

        $consultores = $at
                        ->ofertantes;
        //return $consultores;
        $pasoActual = 5;
        $pasoReal = $at->pasoReal;
        return View::make('asistencia-tecnica/creacion-paso-5', 
            compact('consultores', 'id', 'pasoActual', 'pasoReal'));

    }

    public function consultorSeleccionar($id){
        $consultorID = Input::get('consultor');

        if($consultorID){
            $consultor = atConsultor::find($consultorID);
            $consultor->estado = 2;
            $consultor->save();
        
            $id2 = Math::to_base_10($id, 62) - 100000;
            

            $at = AtTermino::find($id2);
            $at->estado = 4;
            $at->save();
            return Redirect::route('atPaso', $id2);
        }
        return Redirect::route('atPasoSeleccionarConsultor', $id);
    }


    public function contrato($id){
        $id2 = Math::to_base_10($id) - 100000;
        
        $at = AtTermino::find($id2);
        

        if($at->contrato){
            $at->estado = 5;
            $at->save();
            return Redirect::route('atPasoContratada', $id);
        }


        $atcontrato = new AtContrato;
        $atcontrato->attermino_id = $id2;


        $oculto = 'oculto';
        $visible = 'visible';
        $pasoActual = 6;
        $pasoReal = $at->pasoReal;
        $method = "post";
        $action = array('method' => 'PATH', 'class' => 'form-horizontal');
        return View::make('asistencia-tecnica/creacion-paso-7', 
                    compact('atcontrato', 'id', 'pasoActual', 'action', 'pasoReal', 'oculto', 'visible'));
    }


    public function contratoGuardar($id){

        $data = Input::all();
        $contrato = new AtContrato;
        if($contrato->guardar($data, 1)){
            $id2 = $id;
            $id = Math::to_base_10($id) - 100000;
            $at = AtTermino::find($id);
            $at->estado = 5;
            $at->save();
            return Redirect::route('atPasoContratada', $id2);
        }

        return Redirect::route('atPasoContrato', $id)
                        ->withErrors($contrato->errores)
                        ->withInput();
    }


    public function contratada($id){


        //return "hoal";
        $id2 = Math::to_base_10($id) - 100000;
           
        $at = AtTermino::find($id2);

       // return $at;
        $atcontrato = $at->contrato;
           //return $atcontrato;

        $oculto = 'visible';
        $visible = 'oculto';
        $pasoActual = 6;
        $pasoReal = $at->pasoReal;
        $action = array('method' => 'PATH', 'class' => 'form-horizontal');
        return View::make('asistencia-tecnica/creacion-paso-7', 
                    compact('atcontrato', 'id', 'pasoActual', 'action', 'pasoReal', 'oculto', 'visible'));

    }

    public function editContrato($id){
        $data = Input::all();
        $id = Math::to_base_10($id) - 100000;

        $at = AtTermino::find($id);
        $contrato = AtContrato::find($at->contrato->id);
        if($contrato->guardar($data, 1))
            return Redirect::route('atPaso', $id);
        

        return Redirect::route('atPasoContratada', $id)
                        ->withErrors($contrato->errores)
                        ->withInput();
    }

    public function pdfContrato($id){
        $contrato = AtContrato::find($id);
        $at =       $contrato->terminos;

        $consultor = $at->consultorSeleccionado->consultor;
        $empresa = $at->empresa;
        $empresario = $empresa->representante->empresarios;

        $pdf = App::make('dompdf');
        //$pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('pdf.contratoAt', 
                compact('at', 'consultor', 'empresa', 'empresario', 'contrato'));
        return $pdf->stream();
    
    }


    public function acta($id){

        $idAt = Math::to_base_10($id, 62) - 100000;

        $at = AtTermino::find($idAt);

        $oculto = 'oculto';
        $visible = 'visible';

        if($at->acta){
            $acta = $at->acta;
            $oculto = "visible";
            $visible = "oculto";
        }
        else{
            $acta = new acta;
            $acta->attermino_id = $idAt;
        }


        $pasoReal = $at->pasoReal;
        $pasoActual = 7;

        return View::make('asistencia-tecnica/creacion-paso-8',
            compact('acta', 'pasoActual', 'pasoReal', 'id', 'oculto', 'visible'));
    }


    public function actaGuardar($id){


        $idAt = Math::to_base_10($id, 62) - 100000;

        $at = AtTermino::find($idAt);

        $oculto = 'oculto';
        $visible = 'visible';

        if($at->acta){
            $acta = $at->acta;
        }
        else{
            $acta = new acta;
        }
        $data = Input::all();
//return $data;
        if($acta->guardar($data, 1))
        {
        $at->estado = 7;
        $at->save();
            return Redirect::route('atPaso', $acta->attermino_id);
        }

        return Redirect::back()
                        ->withErrors($acta->errores)
                        ->withInput();
    }

    public function actaPdf($id){
        $idAt = Math::to_base_10($id, 62) - 100000;
        $at = AtTermino::with('acta', 'contrato', 'empresa')
                        ->find($idAt);

//        return $at;
        if(!$at->acta)
            return app::abort(404);

        $empresa = $at->empresa;
        $consultor = $at->consultorSeleccionado;
        $empresario = $empresa->representante;
        $contrato = $at->contrato;
        $acta = $at->acta;



        //return $empresario;
        $pdf = App::make('dompdf');
        //$pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('pdf.atActa', 
                compact('at', 'consultor', 'empresa', 'empresario', 'contrato', 'acta'));
        return $pdf->stream();

    }








}