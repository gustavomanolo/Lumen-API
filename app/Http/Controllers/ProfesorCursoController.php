<?php
	namespace App\Http\Controllers;

	use App\Profesor;
	use App\Curso;

	class ProfesorCursoController extends Controller{
		public function __construct(){
			$this->middleware('oauth', ['except'=>['index']]);
		}
		
		public function index( $profesor_id ){
			$profesor = profesor::find( $profesor_id );

			if( $profesor ){
				$cursos = $profesor->cursos;

				return $this->crearRespuesta( $cursos, 200);
			}

			return $this->crearRespuestaError("No se eocntró el profesor con id $profesor_id", 404);
		}

		/*
			*** Function to add course to a teacher (** STORE IN "CURSOS" TABLE **)
		*/
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

		/*
			Update course to set a new profesor
		*/
		function update(Request $request, $profesor_id, $curso_id){
			$profesor = profesor::find( $profesor_id );

			if( $profesor ){
				//-> Validate if the course exists
				$curso = Curso::find( $curso_id );

				if( $curso ){
					$this->validacion( $request );

					$curso->titulo = $request->get('titulo');
					$curso->descripcion = $request->get('descripcion');
					$curso->valor = $request->get('valor');
					$curso->profesor_id = $profesor_id;

					$curso->save();

					return $this->crearRespuesta( "El curso se ha actualizado", 200);
				}

				return $this->crearRespuestaError("No se eocntró el curso con id $curso_id", 404);
			}

			return $this->crearRespuestaError("No se eocntró el profesor con id $profesor_id", 404);
		}

		/*** FUnciton to delete a course
		*/
		public function destroy( $profesor_id, $curso_id ){

			$profesor = Profesor::find( $profesor_id );
			
			if( $profesor ){
				$cursos = $profesor->cursos();

				if( $cursos->find( $curso_id ) ){
					$curso = Curso::find( $curso_id );

					//-> Remove this course from all students
					$curso->estudaintes()->detach();

					$curso->delete();

					return $this->crearRespuesta( "El curso se ha eliminado", 200);
				}

				return $this->crearRespuestaError("No se eocntró el curso con id $curso_id", 404);
			}

			return $this->crearRespuestaError("No se eocntró el profesor con id $profesor_id", 404);
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