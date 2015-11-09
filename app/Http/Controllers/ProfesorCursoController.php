<?php
	namespace App\Http\Controllers;

	use App\Profesor;
	use App\Curso;

	class ProfesorCursoController extends Controller{
		
		public function index( $profesor_id ){
			$profesor = profesor::find( $profesor_id );

			if( $profesor ){
				$cursos = $profesor->cursos;

				return $this->crearRespuesta( $cursos, 200);
			}

			return $this->crearRespuestaError("No se eocntró el profesor con id $profesor_id", 404);
		}

		public function store(Request $request, $profesor_id){
			$profesor = Profesor::find( $profesor_id );

			if( $profesor ){
				$this->validacion( $request );

				$campos = $request->all();
				//-> Add new property "profesor_id" to the request to save in DB
				$campos['profesor_id'] = $profesor_id;

				Curso::create( $campos );

				return $this->crearRespuesta( "El curso se ha creado satisfactoriamente", 200);
			}

			return $this->crearRespuestaError("No se eocntró el profesor con id $profesor_id", 404);
		}

		public function destroy(){
			
		}



		//-> *** Common function to validate Request parameters
		public function validacion($request)
		{
			$reglas = 
			[
				'titulo' => 'required',
				'descripcion' => 'required',
				'valor' => 'required|numeric',
			];
			$this->validate($request, $reglas);
		}
	}