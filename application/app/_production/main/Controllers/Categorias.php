<?php

namespace App\Controllers
{

	class Categorias extends AppController {

		public function __construct()
		{
			$this -> categoria_model = new \App\Models\CategoriaModel();
		}

		public function index(){

			$data = [];
			$categorias = $this -> categoria_model -> getCategoria() -> getAll();

			if ( isset($categorias) )
			{
				foreach($categorias as $row)
				{
					$data[] = array(
						'id' => $row -> id,
						'nome' => $row -> categoria,
						'imagem' => $row -> imagem
					);
				}
			}

			echo json_encode($data);

		}

	}

}
