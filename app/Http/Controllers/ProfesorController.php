<?php
	namespace App\Http\Controllers;

	use App\Profesor;
	use Illuminate\Http\Request;

	class ProfesorController extends Controller{
		
		public function index(){
			$cursos = Profesor::all();
			// return response()->json(['data'=>$cursos], 200);

			return $this->crearRespuesta( $cursos, 200);

		}

		public function show( $id ){
			$curso = Profesor::find( $id );
			if( $curso ){
				return $this->crearRespuesta( $curso, 200);
			}

			return $this->crearRespuestaError('Profesor no encontrado', 404);
		}

		public function store(Request $request){
			/*$reglas = [
				'nombre' => 'required',
				'direccion' => 'required',
				'telefono' => 'required|numeric',
				'profesion' => 'required|in:ingeniería,matemática,física'
			];

			$this->validate($request, $reglas);*/

			//-> This replaced the code before
			$this->validacion($request);

			Profesor::create( $request->all() );

			return $this->crearRespuesta('El profesor ha sido creado', 201);

		}

		public function update(Request $request, $profesor_id){
			$profesor = Profesor::find( $profesor_id );
			if( $profesor ){
				$this->validacion($request);

				$nombre = $request->get('nombre');
				$direccion = $request->get('direccion');
				$telefono = $request->get('telefono');
				$profesion = $request->get('profesion');

				//-> Update current model
				$profesor->nombre = $nombre;
				$profesor->direccion = $direccion;
				$profesor->telefono = $telefono;
				$profesor->profesion = $profesion;

				$profesor->save();

				return $this->crearRespuesta("El profesor $profesor->id ha sido actualizado", 200);
			}

			return $this->crearRespuestaError('El id especificado no s enecuentra', 404);

		}


		public function destroy( $profesor_id ){
			$profesor = Profesor::find( $profesor_id );
			if( $profesor ){
				//-> Sync model to be able to delete "foreign keys"
				//$profesor->cursos()->sync([]);

				if( $profesor->cursos()>0 ){
					//-> Can't delete profesor's if there're courses related to him (MUST DELETE FIRST THE COURSES)
					$this->crearRespuestaError("El profesor tiene cursos asociados. Se deben eliminar primero los cursos", 409);
				}

				$profesor->delete();

				return $this->crearRespuesta("El profesor ha sido eliminado", 200);
			}

			return $this->crearRespuestaError("No se eocntró el profesor con id $profesor_id", 404);
		}


		//-> *** Common function to validate Request parameters
		public function validacion($request)
		{
			$reglas = 
			[
				'nombre' => 'required',
				'direccion' => 'required',
				'telefono' => 'required|numeric',
				'profesion' => 'required|in:ingeniería,matemática,física',
			];
			$this->validate($request, $reglas);
		}


	}