<?php
namespace App\Controllers;

	/**
	 * Class AppController
	 *
	 * AppController provides a convenient place for loading components
	 * and performing functions that are needed by all your controllers.
	 * Extend this class in any new controllers:
	 *     class Home extends AppController
	 *
	 * For security be sure to declare any new methods as protected or private.
	 *
	 * @package CodeIgniter
	 */

	use CodeIgniter\Controller;

	class AppController extends Controller {

		/**
		 * An array of helpers to be loaded automatically upon
		 * class instantiation. These helpers will be available
		 * to all other controllers that extend AppController.
		 *
		 * @var array
		 */
		protected $helpers = [];

		/**
		 * Constructor.
		 */
		public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
		{
			// Do Not Edit This Line
			parent :: initController($request, $response, $logger);

			//--------------------------------------------------------------------
			// Preload any models, libraries, etc, here.
			//--------------------------------------------------------------------

			$this -> session = \Config\Services :: session();
			$this -> uri = \Config\Services :: uri(current_url());

			// $this -> cachePage (10000);

			if (isset($_SERVER['HTTP_ORIGIN'])) {
				header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
				header('Access-Control-Allow-Credentials: true');
				header('Access-Control-Max-Age: 86400');    // cache for 1 day
			}

			// Access-Control headers are received during OPTIONS requests
			if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

				if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
					header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

				if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
					header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

				exit(0);
			}


		}

		public function view($view, $dados = null)
		{

			$dados['view'] = $view;
			$dados['dados'] = $dados;
			//include($this->renderVars['file']); // PHP will be processed
			// alterado para exibir a view diretamente na página Views\Templates\html.phtml
			return view($view, $dados);

		}

	}
