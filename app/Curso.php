<?php
	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Curso extends Model{
		//-> ** Set manual name to table
		protected $table = "cursos";

		protected $fillable = ['titulo', 'descripcion', 'valor'];

		protected $hidden = ['id', 'created_at', 'updated_at'];

		//-> Relationship : a course is imparted by a Profesor
		public function profesor(){
			return $this->belongsTo('App\Profesor');
		}

		//-> N:N relation
		public function estudiantes()
		{
			return $this->belongsToMany('App\Estudiante');
		}
	}