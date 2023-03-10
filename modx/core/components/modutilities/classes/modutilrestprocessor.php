<?php
	/**
	 * Date: 12.06.2020
	 * Time: 17:29
	 */

	abstract class modUtilRestProcessor extends modProcessor
	{
		/* @var modX modx */
		public $modx;
		/* @var modutilitiesRest REST */
		public $REST;
		/**
		 * @var modUtilities
		 */
		public $util;
		/**
		 * @var array
		 */
		public $headers = [];
		/**
		 * @var array
		 */
		public $LanguageTopics = [];
		/**
		 * @var array
		 */
		public $GET;
		/**
		 * @var array
		 */
		public $POST;
		/**
		 * @var array
		 */
		public $PUT;
		/**
		 * query
		 * @var string
		 */
		public $url;
		/**
		 * query
		 * @var integer
		 */
		public $httpResponseCode = 0;

		final public function __construct(modX &$modx, array $properties = [], modutilitiesRest &$REST)
		{
			$this->REST = $REST;
			$this->util = $REST->util;
			$this->GET = &$properties['input']['GET'];
			$this->user = &$properties['user'];
			$this->httpResponseCode = $properties['httpResponseCode'];
			$_alias = $modx->context->getOption('request_param_alias', 'q');
			$this->url = $this->GET[$_alias];
			unset($this->GET[$_alias]);
			$this->POST = &$properties['input']['POST'];
			$this->PUT = &$properties['input']['PUT'];
			if (!empty($_FILES)) {
				$this->FILES = $this->util->files();
				if (get_class($this->FILES) == 'modutilitiesPostFiles') {
					$this->FILES = $this->FILES->FILES;
				}
			}

			parent::__construct($modx, $properties);
		}

		final public function run()
		{
			$initialized = $this->initialize();

			foreach ($this->headers as $key => $value) {
				header("$key: $value");
			}
			foreach ($this->LanguageTopics as $topic) {
				$this->modx->lexicon->load($topic);
			}

			if ($initialized !== TRUE) {
				$o = $this->failure($initialized);
			} else {
				$o = $this->process();
				if ($this->httpResponseCode) {
					http_response_code($this->httpResponseCode);
				}
			}
			if (is_array($o) or is_object($o)) {
				$this->util->headerJson();
				$o = json_encode($o, 256);
			}
			session_write_close();
			return (string)$o;
		}

		public function process()
		{
			switch ($_SERVER['REQUEST_METHOD']) {
				case 'GET':
					return $this->GET();
				case 'POST':
					return $this->POST();
				case 'PUT':
					return $this->PUT();
				case 'DELETE':
					return $this->DELETE();
				case 'PATH':
					return $this->PATH();
				case 'CONNECT':
					return $this->CONNECT();
				case 'HEAD':
					return $this->HEAD();
				case 'OPTIONS':
					return $this->OPTIONS();
				case 'TRACE':
					return $this->TRACE();
			}
		}

		public function GET()
		{
		}

		public function POST()
		{
		}

		public function PUT()
		{
		}

		public function DELETE()
		{
		}

		public function PATH()
		{
		}

		public function CONNECT()
		{
		}

		public function HEAD()
		{
		}

		public function OPTIONS()
		{
		}

		public function TRACE()
		{
		}

		public function success($msg = '', $object = NULL)
		{
			return [
				'success' => TRUE,
				'message' => $msg,
				'object' => $object,
				'code' => $this->httpResponseCode,
			];
		}

		public function failure($msg = '', $object = NULL, $error = [])
		{
			return [
				'success' => FALSE,
				'message' => $msg,
				'object' => $object,
				'errors' => $error,
				'code' => $this->httpResponseCode,
			];
		}
	}

	return 'modUtilRestProcessor';