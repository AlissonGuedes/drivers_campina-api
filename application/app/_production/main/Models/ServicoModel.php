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
		protected $returnType;// = 'App\Entities\Servico';

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
		 * Cadastra o agendamento de um serviço
		 *
		 * @return boolean		true	Caso o registro seja cadastrado normalmente
		 * 						false	Caso haja algum erro ao cadastrar
		 */
		public function agendarServico(){

			$msg = null;
			$status = false;
			$json = [];
			$post = file_get_contents('php://input');
			$post = json_decode($post);

			$id   = isset($post -> id) ? $post -> id : null;
			$data = isset($post -> data) && !empty($post -> data) ? date('Y-m-d', strtotime(str_replace('/', '-', $post -> data))) : null;
			$hora = isset($post -> hora) && !empty($post -> hora) ? $post -> hora : null;
			$servico = isset($post -> servico) ? $post -> servico : null;
			$associado = isset($post -> associado) ? $post -> associado : null;

			if ( empty($data) ) {
				$msg[] = ['data' => 'Informe uma data válida.']; 
			}

			if ( empty($hora) ) {
				$msg[] = ['hora' => 'Informe uma hora válida.'];
			}

			if ( empty($data) || empty($hora) ) {
				$json = ['status' => 'error', 'msg' => $msg];
				echo json_encode($json);
				return false;
			}

			$columns = array(
				'data' => $data,
				'hora' => $hora . ':00',
				'id_servico' => $servico,
				'id_associado' => $associado
			);

			$agenda_completa = $this -> select('id, id_servico, id_associado, data, hora, status')
				  -> from('tb_servico_agenda', true)
				  -> where('id_servico', $servico)
				  -> where('id_associado', $associado)
				  -> where('status', 'S')
				  -> getRow();

			if ( $agenda_completa )
			{

				// O associado só pode agendar um mesmo serviço por dia.
				if ( $agenda_completa -> data === $data )
				{

					$json = array(
						'status' => 'error',
						'title'  => 'Erro',
						'msg'    => 'Você não pode agendar mais de um serviço por dia com este parceiro.'
					);

				// Só pode reagendar o mesmo serviço se ainda o status estiver agendado (S)
				} elseif ( $agenda_completa -> data !== $data ) {
					
					$json = array(
						'status' => 'confirm',
						'title'  => 'Confirme',
						'msg'    => 'Você deseja realizar o reagendamento do seu serviço para o dia ' . date('d/m/Y', strtotime($data)) . '?',
						'fields' => [ 'id' => $agenda_completa -> id, 'data' => $data ]
					);

				}
			}
			else
			{

				if ( $this -> builder -> insert($columns) )
				{
					$json = array(
						'status'=>'success',
						'title'  => 'Sucesso!',
						'msg' => 'Agendamento realizado com sucesso! Por favor, aguarde confirmação.'
					);
				}
				else
				{
					$json = array(
						'status'=>'error',
						'title'  => 'Erro',
						'msg' => 'Não foi possível realizar o agendamento. Por favor, tente novamente mais tarde.'
					);
				}
			}

			echo json_encode($json);

		}

		//--------------------------------------------------------------------
		public function reagendarServico(){
			
			$status = false;
			$json = [];
			$post = file_get_contents('php://input');
			$post = json_decode($post);
			
			$columns = ['data' => $post -> data];
			$id = $post -> id;
	
			$this -> where('id', $id);

			if ( $this -> builder -> from('tb_servico_agenda', true) -> update($columns) )
			{
				$json = array(
					'status' => 'success',
					'title'  => 'Sucesso!',
					'msg'    => 'Você reagendou seu serviço para o dia ' . date('d/m/Y', strtotime($columns['data'])) . '. Por favor, aguarde a confirmação.',
				);
			}
			echo json_encode($json);
		}

	}

}
