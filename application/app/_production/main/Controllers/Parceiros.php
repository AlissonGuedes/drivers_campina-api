<?php

namespace App\Controllers
{

	class Parceiros extends AppController {

		public function __construct()
		{
			$this -> parceiro_model = new \App\Models\ParceiroModel();
		}

		public function index(){

			$data = [];
			$parceiros = $this -> parceiro_model -> getParceiro() -> getAll();

			if ( isset($parceiros) )
			{
				foreach($parceiros as $row)
				{
					$data[] = array(
						'id' => $row -> id,
						'categoria' => $row -> categoria,
						'nome' => $row -> nome,
						'imagem' => $row -> imagem,
						'logradouro' => $row -> logradouro,
						'numero' => $row -> numero,
						'complemento' => $row -> complemento,
						'cep' => $row -> cep,
						'bairro' => $row -> bairro,
						'cidade' => $row -> cidade,
						'uf' => $row -> uf,
						'latitude' => (double) $row -> latitude,
						'longitude' => (double) $row -> longitude
					);
				}
			}

			echo json_encode($data);

		}

		public function categorias()
		{
			
			$data = [];
			$categorias = $this -> parceiro_model -> getCategoria() -> getAll();

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

		public function servicos()
		{

			$data = [];
			$servicos = $this -> parceiro_model -> getServicos() -> getAll();

			if ( isset($servicos) )
			{
				foreach ( $servicos as $row ) 
				{
					$data[] = array(
						'id' => $row -> id,
						'categoria' => $row -> id_categoria,
						'parceiro' => $row -> id_parceiro,
						'descricao' => $row -> descricao,
						'valor' => number_format($row -> valor, 2, ',', '.'),
						'imagem' => $row -> imagem
						// id, id_categoria AS categoria, id_parceiro AS parceiro, descricao, valor, imagem
					);
				}
			}

			echo json_encode($data);

		}

	}

}
