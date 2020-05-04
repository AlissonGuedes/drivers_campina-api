<?php

namespace App\Entities
{

	class Parceiro extends AppEntity {

		protected $id = null;
		protected $id_categoria;
		protected $nome = null;
		protected $logomarca = null;
		protected $logradouro = null;
		protected $numero = null;
		protected $complemento = null;
		protected $cep = null;
		protected $bairro = null;
		protected $cidade = null;
		protected $uf = null;
		protected $latitude = null;
		protected $longitude = null;
		protected $status = '0';

		protected $datamap = array();

		public function __construct(){
            parent::__construct();
            $this -> config = new \App\Entities\Configuracao();
		}

		public function setId($id = null)
		{
			$this -> id = $id;
			return $this;
		}

		public function getId()
		{
			return $this -> id;
		}

		public function setIdCategoria(int $int = null)
		{
			$this -> id_categoria = $int;
			return $this;
		}

		public function getIdCategoria()
		{
			return $this -> id_categoria;
		}

		public function setNome(string $str)
		{
			$this -> nome = $str;
			return $this;
		}

		public function getNome()
		{
			return $this -> nome;
		}

		public function setLogradouro(string $str = null)
		{
			$this -> logradouro = $str;
			return $this;
		}

		public function getLogradouro()
		{
			return $this -> logradouro;
		}

		public function setNumero(string $str = null) {
			$this -> numero = $str;
			return $this;
		}

		public function getNumero(){
			return $this -> numero;
		}

		public function setComplemento(string $str)
		{
			$this -> complemento = $str;
			return $this;
		}

		public function getComplemento()
		{
			return $this -> complemento;
		}

		public function setCep(string $str)
		{
			$this -> cep = $str;
			return $this;
		}

		public function getCep()
		{
			return $this -> cep;
		}

		public function setBairro(string $str = null)
		{
			$this -> bairro = $str;
			return $this;
		}

		public function getBairro()
		{
			return $this -> bairro;
		}

		public function setCidade(string $str = null)
		{
			$this -> id_cidade = $str;
			return $this;
		}

		public function getCidade()
		{
			return $this -> id_cidade;
		}

		public function setUf(string $str)
		{
			$this -> uf = $str;
			return $this;
		}

		public function getUf()
		{
			return $this -> uf;
		}

		public function setLatitude(string $str)
		{
			$this -> latitude = $str;
			return $this;
		}

		public function getLatitude()
		{
			return $this -> latitude;
		}

		public function setLongitude(string $str)
		{
			$this -> longitude = $str;
			return $this;
		}

		public function getLongitude()
		{
			return $this -> longitude;
		}

		/**
		 * Set Logomarca
		 *
		 * @param
		 *        	String
		 * @return String
		 */
		public function setLogomarca($str = null)
		{

			if ( ! isset($_SESSION[USERDATA]) )
				return FALSE;

			if ( empty($str) )
				return false;

			if ( ! is_null($str) && is_string($str) )
			{
				$this -> logomarca = $str;
				return $this;
			}
			else
			{

				if ( ! is_null($str) )
				{

					foreach ( $str as $ind => $val )
					{

						$path = $_SERVER['DOCUMENT_ROOT'] .  $this -> config -> getBasePath() . 'img/logo/';

						$file = $this -> request -> getFile($ind);

						if ( ! $file -> isValid() )
							return false;

						if ( ! is_dir($path) )
							mkdir($path, 0777, TRUE);

						$newName = $file -> getRandomName();
						$file -> move($path, $newName);

						$this -> logomarca = $file -> getName();

					}

					return $this;

				}

			}

		}

		/**
		 * Get Logomarca
		 *
		 * @return String
		 */
		public function getLogomarca(bool $realpath = false)
		{

			if ( $realpath )
				return base_path() . $this -> logomarca;

			return  $this -> config -> getBasePath() . 'img/logo/' . $this -> logomarca;

		}

		public function setStatus(string $str)
		{
			$this -> status = $str;
			return $this;
		}

		public function getStatus()
		{
			return $this -> status;
		}

	}

}