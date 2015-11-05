<?php
	namespace App\Http\Controllers;

	use App\Curso;

	class CursoController extends Controller{
		
		public function index(){
			$cursos = Curso::all();
			// return response()->json(['data'=>$cursos], 200);

			return $this->crearRespuesta( $cursos, 200);

		}

		public function show( $id ){
			$curso = Curso::find( $id );
			if( $curso ){
				return $this->crearRespuesta( $curso, 200);
			}

			return $this->crearRespuestaError('Curso no encontrado', 404);
		}

		public function update(){

		}

		public function destroy(){

		}
	}