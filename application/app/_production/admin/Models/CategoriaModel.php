<?php
namespace App\Models
{

	/**
	 * Classe PlanoModel
	 *
	 * @package App
	 */
	class CategoriaModel extends AppModel {

		/**
		 * Nome da tabela do banco de dados a ser
		 * utilizada pela classe.
		 *
		 * @var string
		 */
		protected $table = 'tb_categoria';

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
		protected $returnType = null; //'App\Entities\Plano';

		/**
		 * Validação para os formulários.
		 *
		 * @var array
		 */
		protected $formValidation = null;// 'App\Validations\PlanoValidation';

		/**
		 * Especificar por quais colunas da tabela
		 * poderão ser ordenados os dados.
		 *
		 * @var array
		 */
		protected $order = array( );

		//--------------------------------------------------------------------

		/**
		 * Lista registros da tabela
		 *
		 * @param string|array|boolean		$where
		 * @param string|array				$fields
		 *
		 * @return array Model()
		 */
		public function getCategoria($where = false, $fields = '*')
		{

			$this -> select('id, categoria', true);
			$this -> from('tb_categoria', true);
			$this -> where('status', '1');
			return $this;

		}

		//------------------------------------------------------------------------------

	}

}