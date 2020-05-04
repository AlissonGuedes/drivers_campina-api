<?php
namespace App\Models
{

	/**
	 * Classe FaqModel
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
		protected $returnType; // = 'App\Entities\Parceiro';

		/**
		 * Especificar por quais colunas da tabela
		 * poderão ser ordenados os dados.
		 *
		 * @var array
		 */
		protected $order = array(
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

		public function getParceiro()
		{
			$tipo = $this -> uri -> getSegment(2);
			return $this -> select('P.*, C.categoria')
						 -> from('tb_parceiro AS P,tb_categoria AS C', true)
						 -> where('P.id_categoria = C.id')
						 -> where('P.status', '1')
						 -> where('C.status', '1')
						 -> where('C.slug', $tipo)
						 -> orderBy('nome');
		}

		public function getServicos()
		{
			$categoria = $this -> uri -> getSegment(2);
			$parceiro  = $this -> uri -> getSegment(3);
			return $this -> select('S.id, S.id_categoria, S.id_parceiro, S.descricao, S.valor, S.imagem, P.nome nomeParceiro')
						 -> from('tb_servico S,tb_categoria C, tb_parceiro P', true)
						 -> where('S.id_parceiro', $parceiro)
						 -> where('C.slug', $categoria)
						 -> where('C.id = S.id_categoria')
						 -> where('P.id = S.id_parceiro')
						 -> where('P.id_categoria = C.id')
						 -> orderBy('S.valor ASC');
		}

		//--------------------------------------------------------------------

	}

}
