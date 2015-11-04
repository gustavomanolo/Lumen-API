<?php
	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Profesor extends Model{
		//-> ** Set manual name to table
		protected $table = "profesores";

		protected $fillable = ['nombre', 'direccion', 'telefono', 'profesion'];

		protected $hidden = ['id', 'created_at', 'updated_at'];


		public function cursos(){
			return $this->hasMany('App\Curso');
		}
	}