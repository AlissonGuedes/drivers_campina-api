<?php

namespace App\Controllers
{

	// Models
	// use \App\Models\ParceiroTipoModel;
	use \App\Models\ParceiroModel;
	use \App\Models\UserModel;
	use \App\Models\CidadeModel;

	use \App\Models\CategoriaModel;

	// Entities
	use \App\Entities\Parceiro;

	/**
	 * Controlador que gerencia a página {parceiros} na área
	 * Administrativa
	 *
	 * @author Alisson Guedes <alissonguedes87@gmail.com>
	 * @version 2
	 * @access public
	 * @package PJM Telecom
	 * @example classe Parceiros
	 */
	class Parceiros extends AppController {

		/**
		 * Instância do banco de dados
		 *
		 * @var \App\Models\ParceiroModel
		 */
		private $parceiro_model;

		//--------------------------------------------------------------------

		/**
		 * Método construtor da classe
		 *
		 * @method __construct()
		 */
		public function __construct()
		{

			// Models
			$this -> user_model = new UserModel();
			// $this -> tipo_parceiro_model = new ParceiroTipoModel();
			$this -> parceiro_model = new ParceiroModel();
			$this -> cidade_model = new CidadeModel();
			$this -> categoria_model = new CategoriaModel();

			// Entities
			$this -> parceiro = new Parceiro();

		}

		//--------------------------------------------------------------------

		/**
		 * @name Index
		 *
		 * exibir a Página principal do controlador
		 *
		 * @method index()
		 * @return view_path = /Views/parceiros/index.phtml
		 */
		public function index()
		{

			$dados['titulo'] = 'Admin';
			$dados['filtro'] = null;
			$dados['parceiros'] = $this -> parceiro_model -> getById();
			$dados['categorias'] = $this -> categoria_model -> getCategoria();
			return $this -> view('parceiros/index', $dados);

		}

		public function search(){
			$dados['filtro'] = $this -> uri -> getSegment(3) === 'filtro' ? urldecode($this -> uri -> getSegment(4)) : null;
			$dados['parceiros'] = $this -> parceiro_model -> getSearch();
			$dados['categorias'] = $this -> categoria_model -> getCategoria();
			return $this -> view('parceiros/index', $dados);
		}

		public function getByCategoria(){
			$dados['filtro'] = $this -> uri -> getSegment(3) === 'filtro' ? urldecode($this -> uri -> getSegment(4)) : null;
			$dados['parceiros'] = $this -> parceiro_model -> getByCategoria();
			$dados['categorias'] = $this -> categoria_model -> getCategoria();
			return $this -> view ('parceiros/index', $dados);
		}

		//--------------------------------------------------------------------

		/**
		 * @name Datatable
		 *
		 * Lista na tabela html de todos os registros cadastrados no
		 * banco de dados
		 *
		 * @method datatable()
		 * @return view_path = /Views/parceiros/datatable.phtml
		 */
		public function datatable()
		{
			$dados['recordsTotal'] = $this -> parceiro_model -> countAll();
			$dados['query'] = $this -> parceiro_model -> getParceiro();
			$dados['recordsFiltered'] = $this -> parceiro_model -> numRows();
			return $this -> view('parceiros/datatable', $dados);
		}

		//--------------------------------------------------------------------

		/**
		 * @name Show Form
		 *
		 * Exibe o formulário para cadastrar ou alterar um registro.
		 * Se o parâmetro 3 da url for um número, exibe os dados para
		 * alteração
		 *
		 * @method show_form()
		 * @return view_path = /Views/parceiros/formulario.phtml
		 */
		public function show_form()
		{

			$id = $this -> uri -> getSegment(3);

			$dados['parceiros']  = $this -> parceiro_model;
			// $dados['tipos']   = $this -> tipo_parceiro_model -> getTipoParceiro() -> getAll();

			// Listar cidades e bairros para os selects do formulário cidades e bairros
			// $dados['cidades'] = $this -> cidade_model -> getCidadeUsuario() -> getAll();
			// $dados['bairros'] = $this -> cidade_model;

			if ( is_numeric($id) )
			{

				$dados['method'] = 'put';
				$dados['row'] = $this -> parceiro -> fill($this -> parceiro_model -> getParceiro(['id' => $id]) -> getRow());

				return $this -> view('parceiros/formulario', $dados);

			}

			$dados['method'] = 'post';
			return $this -> view('parceiros/formulario', $dados);

		}

		//--------------------------------------------------------------------

		/**
		 * @name Create
		 *
		 * Insere/Salva um novo registro no banco de dados.
		 *
		 * @method create()
		 * @return boolean		true|false se a alteração foi realizada
		 * ou não
		 */
		public function create()
		{

			if ( $id = $this -> parceiro_model -> create() )
			{

				$this -> parceiro_model -> registraBairros($id);
				$type = 'success';
				$msg = 'Parceiro cadastrado com sucesso.';
			}
			else
			{
				$type = 'error';
				$msg = $this -> parceiro_model -> errors();
			}

			echo json_encode(array(
				'type'/*		*/ => $type,
				'msg'/*			*/ => $msg,
				'url'/*			*/ => base_url() . 'parceiros/index',
				'redirect'/*	*/ => 'refresh'
			));

		}

		//--------------------------------------------------------------------

		/**
		 * @name Update
		 *
		 * Edita um registro já existente no banco de dados.
		 *
		 * @method datatable()
		 * @return view_path = /Views/parceiros/formulario.phtml
		 */
		public function update()
		{

			if ( $this -> parceiro_model -> edit() )
			{

				$this -> parceiro_model -> registraBairros();

				$type = 'success';
				$msg = 'Parceiro atualizado com sucesso.';
			}
			else
			{
				if ( $this -> parceiro_model -> errors() === NULL )
				{
					$this -> parceiro_model -> registraBairros();

					$type = 'success';
					$msg = null;
				}
				else
				{
					$type = 'error';
					$msg = $this -> parceiro_model -> errors();
				}
			}

			echo json_encode(array(
				'type'/*		*/ => $type,
				'msg'/*			*/ => $msg,
				'url'/*			*/ => base_url() . 'parceiros/index',
				'redirect'/*	*/ => 'refresh'
			));

		}

		//--------------------------------------------------------------------

		/**
		 * @name Delete
		 *
		 * Exclui registro do banco de dados.
		 *
		 * @method delete()
		 * @return mixed		Apresenta a mensagem de confirmação da
		 * exclusão.
		 * 						Caso seja confirmada, o registro será excluído.
		 */
		public function delete()
		{

			$delete = isset($_POST['excluir']) ? $_POST['excluir'] : true;
			$parceiros = $_POST['id'];

			$type = 'warning';
			$msg = 'Tem certeza que deseja excluir ' . count($parceiros) . ' ' . ((count($parceiros) == 1) ? 'parceiro selecionado' : 'parceiros selecionados') . '?';
			$url = base_url() . 'parceiros';

			if ( $delete )
			{
				if ( $this -> parceiro_model -> remove($parceiros) -> getQuery('delete'))
				{
					$type = 'success';
					$msg = count($parceiros) . ' ' . ((count($parceiros) == 1) ? 'registro excluído' : 'registros excluídos') . ' com sucesso ';
					$url = base_url() . 'parceiros/index';
				}
				else
				{
					$type = 'error';
					$msg = 'Nenhum registro pôde ser excluído.';
				}
			}

			echo json_encode(array(
				'type'/*		*/ => $type,
				'msg'/*			*/ => $msg,
				'url'/*			*/ => $url,
				'fields'/*		*/ => $parceiros,
				'action'/*		*/ => 'excluir',
				'redirect'/*	*/ => 'refresh',
			));

		}

		//--------------------------------------------------------------------

	}

}