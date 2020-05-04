<?php

namespace App\Models
{

	/**
	 * Classe ParceiroModel
	 *
	 * @package App
	 */
	class ParceiroModel extends AppModel {

		/**
		 * Nome da tabela do banco de dados a ser
		 * utilizada pela classe.
		 *
		 * @var string
		 */
		protected $table = 'tb_parceiro';

		/**
		 * A chave primária da tabela.
		 *
		 * @var string
		 */
		protected $primaryKey = 'id';

		/**
		 * O formato em que os resultados devem ser
		 * retornados.
		 *
		 * @var string
		 */
		protected $returnType = 'App\Entities\Parceiro';

		/**
		 * Validação para os formulários.
		 *
		 * @var array
		 */
		protected $formValidation = 'App\Validations\ParceiroValidation';

		/**
		 * Especificar por quais colunas da tabela
		 * poderão ser ordenados os dados.
		 *
		 * @var array
		 */
		protected $order = array(
			NULL,
			'id',
			'categoria',
			'status',
		);

		//--------------------------------------------------------------------

		/**
		 * Lista registros da tabela
		 *
		 * @param string|array|boolean		$where
		 * @param string|array				$fields
		 *
		 * @return array Model()
		 */
		public function getById($where = false, $fields = 'tb_parceiro.id, tb_parceiro.nome, tb_parceiro.logomarca, tb_parceiro.id_categoria, tb_parceiro.status')
		{
			
			// Select '*'
			$this -> select($fields);

			$this -> select('tb_categoria.categoria') 
				  -> from('tb_categoria')
				  -> where('tb_categoria.id = tb_parceiro.id_categoria');

			// Where
			if ( $where )
				$this -> where($where);

			/*
			 * Adicionar outras condições...
			 */
			// $this -> where('id_usuario', $_SESSION[USERDATA]['id']);

			// Like
			if ( ! empty($_POST['search']['value']) )
			{

				$or_like = array(
					'id' => $_POST['search']['value'],
					'descricao' => $_POST['search']['value'],
				);

				$this -> groupStart();
                $this -> orLike($or_like);
                $this -> groupEnd();

			}

			if ( count($this -> uri -> getSegments()) == 4 )
			{

				$column= $this -> uri -> getSegment(3);
				$direction = $this -> uri -> getSegment(4);
					
				$orderBy = $column;

			}
			else
			{
				$orderBy = $this -> order[1];
				$direction = 'asc';
			}

			$this -> orderBy($orderBy, $direction);

			// Limit
			$limit = isset($_POST['length']) ? $_POST['length'] : 50;

			// if ( ! is_null($limit) )
			$this -> limit($limit);

			// Offset
			$start = isset($_POST['start']) ? $_POST['start'] : NULL;

			if ( ! is_null($start) )
				$this -> offset($start);

			return $this;

		}

		//------------------------------------------------------------------------------
		public function getSearch($where = false, $fields = 'tb_parceiro.id, tb_parceiro.nome, tb_parceiro.logomarca, tb_parceiro.id_categoria, tb_parceiro.status')
		{
			// Select '*'
			$this -> select($fields);

			$this -> select('tb_categoria.categoria') 
				  -> from('tb_categoria')
				  -> where('tb_categoria.id = tb_parceiro.id_categoria');

			// Where
			if ( $where )
				$this -> where($where);

			/*
			 * Adicionar outras condições...
			 */
			// $this -> where('id_usuario', $_SESSION[USERDATA]['id']);

			// Like
			$filtro = $this -> uri -> getSegment(4);

			$or_like = array(
				'tb_parceiro.id' => urldecode($filtro),
				'tb_parceiro.nome' => urldecode($filtro),
				'tb_categoria.categoria' => urldecode($filtro)
			);

			$this -> groupStart();
			$this -> orLike($or_like);
			$this -> groupEnd();

			if ( count($this -> uri -> getSegments()) == 6 )
			{

				$column= $this -> uri -> getSegment(5);
				$direction = $this -> uri -> getSegment(6);
					
				$orderBy = $column;

			}
			else
			{
				$orderBy = $this -> order[1];
				$direction = 'asc';
			}

			$this -> orderBy($orderBy, $direction);

			// Limit
			$limit = isset($_POST['length']) ? $_POST['length'] : 50;

			// if ( ! is_null($limit) )
			$this -> limit($limit);

			// Offset
			$start = isset($_POST['start']) ? $_POST['start'] : NULL;

			if ( ! is_null($start) )
				$this -> offset($start);

			return $this;

		}

		//------------------------------------------------------------------------------
	
		public function getByCategoria($where = false, $fields = 'tb_parceiro.id, tb_parceiro.nome, tb_parceiro.logomarca, tb_parceiro.id_categoria, tb_parceiro.status, tb_categoria.categoria'){

			$id_categoria = $this -> uri -> getSegment(4);
			$filtro = $this -> uri -> getSegment(5) === 'filtro' ? $this -> uri -> getSegment(6) : null;
			// $order  = $this -> uri -> getSegment(5) === ''

			if ($this -> uri -> getSegments() === 8)
			{
				$order  =  $this -> uri -> getSegment(7);
				$order  = $this -> uri -> getSegment(8) ;
			}

			$this -> select($fields)
					 -> from ('tb_parceiro, tb_categoria', true)
					 -> where('tb_parceiro.id_categoria = tb_categoria.id');

			if (is_numeric($id_categoria))
				$this -> where('tb_categoria.id', $id_categoria);
			
			// // Like
			// if ( count($this -> uri -> getSegments()) >= 8){
			// 	$filtro = $this -> uri -> getSegment(4);

			// 	$or_like = array(
			// 		'tb_parceiro.id' => urldecode($filtro),
			// 		'tb_parceiro.nome' => urldecode($filtro),
			// 		'tb_categoria.categoria' => urldecode($filtro)
			// 	);

			// 	$this -> groupStart();
			// 	$this -> orLike($or_like);
			// 	$this -> groupEnd();

			// }

			// if ( count($this -> uri -> getSegments()) >= 8 )
			// {

			// 	$column= $this -> uri -> getSegment(7);
			// 	$direction = $this -> uri -> getSegment(8);
					
			// 	$orderBy = $column;

			// }
			// else
			// {
			// 	$orderBy = $this -> order[2];
			// 	$direction = 'asc';
			// }

			// $this -> orderBy($orderBy, $direction);

			return $this;
			
		}
	}

}