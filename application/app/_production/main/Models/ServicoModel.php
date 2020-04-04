<?php
namespace App\Models
{

	/**
	 * Classe FaqModel
	 *
	 * @package App
	 */
	class ServicoModel extends AppModel {

		/**
		 * Nome da tabela do banco de dados a ser
		 * utilizada pela classe.
		 *
		 * @var string
		 */
		protected $table = 'tb_servico';

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
		protected $returnType = 'App\Entities\Faq';

		/**
		 * Especificar por quais colunas da tabela
		 * poderão ser ordenados os dados.
		 *
		 * @var array
		 */
		private $order = array(
			NULL,
			'B.id',
			'B.descricao',
			'B.velocidade_download',
			'B.velocidade_upload',
			'B.wifi_incluso',
			'(SELECT tipo FROM tb_faq_tipo WHERE tb_faq_tipo.id = B.id_tipo)',
			'B.valor_real',
			'B.status',
			NULL
		);

		/**
		 * Um array de nomes de campos que podem ser
		 * alterados pelo usuário em inserts/updates.
		 *
		 * @var array
		 */
		protected $allowedFields = array(
			'id_tipo',
			'id_bairro',
			'id_cidade',
			'descricao',
			'velocidade_upload',
			'velocidade_download',
			'wifi_incluso',
			'cesta_servicos',
			'fibra_optica',
			'nivel',
			'valor_real',
			'valor_prom',
			'data_validade',
			'data_validade_promocao',
			'status'
		);

		/**
		 * Regras usadas para validar um dado nos métodos
		 * insert, update e save.
		 * O array deve conter o formato de dados passado
		 * para a biblioteca de validação.
		 *
		 * @var array
		 */
		protected $validationRules = array(
			'tipo' => 'trim|required',
			'bairro' => 'trim|required',
			'cidade' => 'trim|required',
			'descricao' => 'trim|required',
			'velocidade_upload' => 'trim|required',
			'velocidade_download' => 'trim|required',
			'wifi_incluso' => 'trim',
			'cesta_servicos' => 'trim',
			'fibra_optica' => 'trim',
			'nivel' => 'trim',
			'valor_real' => 'trim',
			'valor_prom' => 'trim',
			'data_validade' => 'trim',
			'data_validade_promocao' => 'trim',
			'status' => 'trim'
		);

		public function __construct()
		{

			parent :: __construct();

			/**
			 * @class $this -> faq = new \App\Entities\Faq;
			 * Retorna uma instância da Entidade Faq (\App\Admin\Entities\Faq)
			 */
			// $this -> faq = new \App\Entities\Faq;

		}

		//--------------------------------------------------------------------

		public function getCategoria(){
			return $this -> select('*') -> from('tb_categoria', true) -> where('status', '1') -> orderBy('categoria');
		}

		public function getAgenda()
		{
			$tipo = $this -> uri -> getSegment(4);
			return $this -> select('*')
						 -> from('tb_servico', true)
						//  -> where('status', '1')
						 -> where('id', $tipo)
						 -> orderBy('descricao');
		}

		public function getServicos()
		{
			$servico = $this -> uri -> getSegment(2);
			return $this -> select('*') -> from('tb_servico', true) -> where('id_servico', $servico);
		}

		//--------------------------------------------------------------------

		/**
		 * Cadastra novo registro na tabela
		 *
		 * @return boolean		true	Caso o registro seja cadastrado normalmente
		 * 						false	Caso haja algum erro ao cadastrar
		 */
		public function create()
		{

			$post = $this -> request -> getPost();

			if ( $this -> validate($post) === FALSE )
				return FALSE;

			$this -> faq -> fill($post);

			$this -> insert($this -> faq);

			if ( $this -> affectedRows() )
				return true;
			else
				return false;

		}

		/**
		 * Agendar serviço
		 */
		public function agendarServico(){

			$data = [];
			$post = file_get_contents('php://input');
			$post = json_decode($post);

			$data = isset($post -> data) ? date('Y-m-d', strtotime(str_replace('/', '-', $post -> data))) : null;
			$hora = isset($post -> hora) ? $post -> hora . ':00' : null;
			$servico = isset($post -> servico) ? $post -> servico : null;
			$associado = isset($post -> associado) ? $post -> associado : null;

			$agenda_completa = $this -> select('id, id_servico, id_associado, data, hora, status')
				  -> from('tb_servico_agenda', true)
				  -> where('data', $data)
				  -> where('hora', $hora)
				  -> where('id_servico', $servico)
				  -> getAll();

			if ( isset($agenda_completa) )
			{
				foreach ($agenda_completa as $agenda)
				{
					if ( $agenda -> id_associado === $associado ) {
						return false;
					}
					else {
						return true;
					}
				}
			}

		}

		//--------------------------------------------------------------------

		/**
		 * Editar registros na tabela
		 *
		 * @return boolean		true	Caso o registro seja editado normalmente
		 * 						false	Caso haja algum erro ao remover
		 *
		 *   // Defined as a model property
		 *   $primaryKey = 'id';
		 *
		 *   // Does an insert()
		 *   $data = [
		 *           'username' => 'darth',
		 *           'email'    => 'd.vader@theempire.com'
		 *   ];
		 *
		 *   $userModel->save($data);
		 *
		 *   // Performs an update, since the primary key, 'id', is found.
		 *   $data = [
		 *           'id'       => 3,
		 *           'username' => 'darth',
		 *           'email'    => 'd.vader@theempire.com'
		 *   ];
		 *   $userModel->save($data);
		 *
		 *   $data = [
		 *        'username' => 'darth',
		 *        'email'    => 'd.vader@theempire.com'
		 *    ];
		 *
		 *    $userModel->update($id, $data);
		 *    $data = [
		 *        'active' => 1
		 *    ];
		 *    $userModel->update([1, 2, 3], $data);
		 *
		 *    $userModel
		 *        ->whereIn('id', [1,2,3])
		 *        ->set(['active' => 1]
		 *        ->update();
		 *
		 */
		public function edit()
		{

			$post = getPut();

			if ( $this -> validate($post) === FALSE )
				return FALSE;

			$this -> faq -> fill($post);

			$this -> update(['id' => $post['id']], $this -> faq);

			if ( $this -> affectedRows() )
				return true;
			else
				return false;

		}

		//--------------------------------------------------------------------

		/**
		 * Remove registros na tabela
		 *
		 * @return boolean		true	Caso o registro seja excluído normalmente
		 * 						false	Caso haja algum erro ao remover
		 */
		public function remove()
		{

			$post = getDelete();

			if ( $this -> validate($post) === FALSE )
				return FALSE;

			$fields = $post['fields'];
			$this -> delete($fields);

			if ( $this -> affectedRows() )
				return true;
			else
				return false;
		}

		//--------------------------------------------------------------------

	}

}
