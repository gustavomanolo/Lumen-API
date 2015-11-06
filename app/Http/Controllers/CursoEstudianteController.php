<?php
	namespace App\Http\Controllers;

	use App\Curso;

	class CursoEstudianteController extends Controller{
		public function index( $curso_id ){
			$curso = Curso::find( $curso_id );

			if( $curso ){
				$estudiantes = $curso->estudiantes;

				return $this->crearRespuesta( $estudiantes, 200);
			}

			return $this->crearRespuestaError("No se eocntró el curso con id $curso_id", 404);
		}

		public function store(){

		}

		public function destroy(){

		}
	}