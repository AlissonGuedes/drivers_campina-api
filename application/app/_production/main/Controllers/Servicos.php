<?php

namespace App\Controllers
{

	class Servicos extends AppController {

		public function __construct()
		{
			$this -> servico_model = new \App\Models\ServicoModel();
		}

		public function index(){

			$data = [];
			$servicos = $this -> servico_model -> getServico() -> getAll();

			if ( isset($servicos) )
			{
				foreach($servicos as $row)
				{
					$data[] = array(
						'id' => $row -> id,
						'categoria' => $row -> id_categoria,
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

		public function agendamentos() {
			$data = [];
			$servicos = $this -> servico_model -> getAgenda() -> getAll();
			echo json_encode($servicos);
		}

		public function agendar(){
			$data = [];
			$servico = $this -> sevico_model -> agendarServico();

			if ( $servico ) {
				$data = array(
					'status'=>'success',
					'msg' => 'Agendamento realizado com sucesso!<br>Por favor, aguarde confirmação.'
				);
			} else {
				$data = array(
					'status'=>'error',
					'msg' => 'Não foi possível realizar o agendamento.'
				);
			}

			echo json_encode($data);
		}

		public function categorias()
		{
			$data = [];
			$categorias = $this -> servico_model -> getCategoria() -> getAll();

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
			$servicos = $this -> servico_model -> getServicos() -> getAll();

			if ( isset($servicos) )
			{
				foreach ( $servicos as $row ) 
				{
					$data[] = array(
						'id' => $row -> id,
						'categoria' => $row -> id_categoria,
						'servico' => $row -> id_servico,
						'descricao' => $row -> descricao,
						'valor' => number_format($row -> valor, 2, ',', '.'),
						'imagem' => $row -> imagem
						// id, id_categoria AS categoria, id_servico AS servico, descricao, valor, imagem
					);
				}
			}

			echo json_encode($data);

		}

	}

}
