<?php
	namespace App\Http\Controllers;

	use App\Curso;
	use App\Estudiante;

	class CursoEstudianteController extends Controller{

		public function __construct(){
			$this->middleware('oauth', ['except'=>['index']]);
		}

		public function index( $curso_id ){
			$curso = Curso::find( $curso_id );

			if( $curso ){
				$estudiantes = $curso->estudiantes;

				return $this->crearRespuesta( $estudiantes, 200);
			}

			return $this->crearRespuestaError("No se eocntró el curso con id $curso_id", 404);
		}

		/*
			*** Function to add course to a student (** USE PIVOT TABLE ** )
		*/
		public function store($curso_id, $estudiante_id){
			$curso = Curso::find( $curso_id );
			if( $curso ){
				$estudiante = Estudiante::find( $estudiante_id );

				if( $estudiante ){

					//-> Check that the current student isn't already assigned to the course
					$estudiantes = $curso->estudiantes()->find( $estudiante_id );
					if( !$estudiantes ){
						//-> Add new student
						$curso->estudiantes()->attach( $estudiante_id );
						
						return $this->crearRespuesta( "Se ha agregado el estudiante", 201);
					}else{
						//-> Already assigned to the course
						return $this->crearRespuestaError("No se eocntró el estudiante con id $estudiante_id", 409);
					}

				}

				return $this->crearRespuestaError("No se eocntró el estudiante con id $estudiante_id", 404);
			}

			return $this->crearRespuestaError("No se eocntró el curso con id $curso_id", 404);
		}


		/*** ELiminar un curso de un estudiante
		*/
		public function destroy($curso_id; $estudiante_id){
			$curso = Curso::find( $curso_id );
			if( $curso ){
				$estudiantes = $curso->estudiantes();

				if( $estudiantes->find($estudiante_id) ){
					$estudiantes->detach( $estudiante_id );

					return $this->crearRespuesta( "El estudiante se eliminó", 200);
				}

				return $this->crearRespuestaError("No se eocntró el estudiante con id $estudiante_id", 404);
			}

			return $this->crearRespuestaError("No se eocntró el curso con id $curso_id", 404);
		}
	}