<?php
	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Estudiante extends Model{
		//-> ** Set manual name to table
		protected $table = "estudiantes";

		protected $fillable = ['nombre', 'direccion', 'telefono', 'carrera'];

		protected $hidden = ['id', 'created_at', 'updated_at'];

		//-> ** Relations => An studen can have many courses
		public function cursos(){
			return $this->belongsToMany('App\Curso');
		}
	}