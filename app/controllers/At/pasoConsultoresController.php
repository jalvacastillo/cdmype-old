<?php 

class pasoConsultoresController extends BaseController
{

    public function consultores($id)
    {
        // $data = '/assets/ofertas/pdf.pdf';
        // $path = public_path() . $data;
        //return $path . $data;
        // return File::put($path , $data);
        $id2 = (Math::to_base_10($id, 62) ) - 100000;
        $at = AtTermino::find($id2);


        $pasoActual = 3;
        $pasoReal = $at->pasoReal;
        $consultores = ConsultorEspecialidad::Where('subespecialidad_id', '=', $at->especialidad_id)
                        ->with('especialidad', 'consultor')
                        ->paginate();
        return View::make('asistencia-tecnica/creacion-paso-3', 
                compact('consultores', 'id', 'pasoActual', 'pasoReal'));
    }

    public function consultoresGuardar()
    {
        
       
        $consultores =  Input::get('consultores');
        $id = Input::get('idEmpresa');

        $id  = Math::to_base_10($id,62) - 100000;
        $banderaConsultor = 0;
        $at = AtTermino::find($id);
        ///return $at;
        foreach ($consultores as $consultor) {
            $consul = $at->consultores()
                    ->where('consultor_id', '=', $consultor);
            if(!$consul->count() > 0)
            {
                $consultorAT = new AtConsultor;
                $consultorAT->attermino_id = $id;
                $consultorAT->consultor_id = $consultor;
                $consultorAT->save();
               
                $this->mailOferta('emails.asistenciaTecnica', 
                                    $id, 
                                    $consultorAT->consultor->correo, 
                                    $consultorAT->consultor->nombre
                                );
                
            }
            $banderaConsultor = 1;
        }
        if($banderaConsultor == 1)
        {
            $at->estado = 2;
            $at->save();
        }

        $id = Math::to_base($id + 100000, 62);
        return Redirect::route('atPasoOferta', $id);
    }


//fin de los pasos
    private function mailOferta($template, $id, $email, $nombreConsultor)
    {
        Mail::send($template,array('id' => $id),function($message) use ($id, $email, $nombreConsultor) {
           
            $message->to($email, $nombreConsultor)
                    ->subject('Términos de referencia - CDMYPE UNICAES');
        });
    }

}