<?php
	namespace App\Http\Controllers;

	use App\Estudiante;
	use Illuminate\Http\Request;

	class EstudianteController extends Controller{
		
		public function __construct(){
			$this->middleware('oauth', ['except'=>['index','show'] ]);
		}

		public function index(){
			$estudiante = Estudiante::all();

			return $this->crearRespuesta( $estudiante, 200);

		}

		public function show( $id ){
			$curso = Estudiante::find( $id );
			if( $curso ){
				return $this->crearRespuesta( $curso, 200);
			}

			return $this->crearRespuestaError('Estudiante no encontrado', 404);
		}


		public function store(Request $request){
			/*$reglas = [
				'nombre' => 'required',
				'direccion' => 'required',
				'telefono' => 'required|numeric',
				'carrera' => 'required|in:ingeniería,matemática,física'
			];
			$this->validate($request, $reglas);*/

			//-> This replaced the code before
			$this->validacion($request);

			Estudiante::create( $request->all() );

			return $this->crearRespuesta('El estudiante ha sido creado', 201);

		}



		public function update(Request $request, $estudiante_id){
			$estudiante = Estudiante::find( $estudiante_id );
			if( $estudiante ){
				$this->validacion($request);

				$nombre = $request->get('nombre');
				$direccion = $request->get('direccion');
				$telefono = $request->get('telefono');
				$carrera = $request->get('carrera');

				//-> Update current model
				$estudiante->nombre = $nombre;
				$estudiante->direccion = $direccion;
				$estudiante->telefono = $telefono;
				$estudiante->carrera = $carrera;

				$estudiante->save();

				return $this->crearRespuesta("El estudiante $estudiante->id ha sido actualizado", 200);
			}

			return $this->crearRespuestaError('El id especificado no s enecuentra', 404);

		}


		public function destroy( $estudiante_id ){
			$estudiante = Estudiante::find( $estudiante_id );
			if( $estudiante ){
				//-> Sync model to be able to delete "foreign keys"
				$estudiante->cursos()->sync([]);

				$estudiante->delete();

				return $this->crearRespuesta("El estudiante ha sido eliminado", 200);
			}

			return $this->crearRespuestaError("No se eocntró el estudiante con id $estudiante_id", 404);
		}



		//-> *** Common function to validate Request parameters
		public function validacion($request)
		{
			$reglas = 
			[
				'nombre' => 'required',
				'direccion' => 'required',
				'telefono' => 'required|numeric',
				'carrera' => 'required|in:ingeniería,matemática,física',
			];
			$this->validate($request, $reglas);
		}

	}