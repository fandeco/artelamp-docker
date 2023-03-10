<?php

	/**
	 * Демонстрация контроллера
	 */
	abstract class CrontabControllerSync extends modCrontabController
	{
		/* @var Fandeco1cSync $sync */
		public $sync        = NULL;
		public $cache       = TRUE;
		public $cachePrefix = '_2';
		public $config      = [];

		public $sync_vendors
			= [
				'5a4947e5-b54b-11ea-81a8-005056a968c7', // ARTE LAMP
				'cabe6885-4097-11e7-8117-005056a9741d'// gauss
			];

		public function initialize()
		{
			include_once MODX_CORE_PATH . 'classes/fandeco1csync.class.php';
			$this->sync = new Fandeco1cSync($this->modx, $this->config);
			return parent::initialize(); // TODO: Change the autogenerated stub
		}


		/**
		 * ФОрматируем ключе чтобы исключить разные человеческие ошибки
		 * @param $search_key
		 * @return string|string[]
		 */
		public function keyProduct($search_key)
		{
			$search_key = mb_strtoupper($search_key);
			$search_key = str_ireplace('  ', ' ', $search_key);
			return $search_key;
		}

		/**
		 * @param $method
		 * @param $params
		 * @return mixed
		 * @throws Exception
		 */
		public function send($method, $params)
		{
			$response = NULL;
			try {
				$params['site_name'] = MODX_HTTP_HOST;
				$response            = $this->sync->send($method, $params);
			} catch (exchangeException $e) {
				$response = $this->sync->getResponse();
				print($e->getMessage());
				var_dump($method);
				var_dump($params);
				throw new Exception($response);
			}

			return $response;
		}


		/**
		 * Вернет список артикулов которые возможно обновить
		 * @return array|null
		 * @throws Exception
		 */
		public function propertyReference()
		{
			// Кэшируем по умолчанию
			$articles = cacheValuesSite($this->modx, 'property_reference_artelamp_it2' . $this->cachePrefix, function (modX $modx) {
				$response = $this->send('property_reference', []);
				return $response['array'];
			},                          $this->cache);
			return $articles;
		}

		/**
		 * Вернет список артикулов которые возможно обновить
		 * @return array|null
		 * @throws Exception
		 *
		 * public function OLDsubmitToSite()
		 * {
		 * // Кэшируем по умолчанию
		 * $articles = cacheValuesSite($this->modx, 'submit_to_site_artelamp_it2' . $this->cachePrefix, function (modX $modx) {
		 * $response = $this->send('submit_to_site', [
		 * "site" => "fandeco.ru",
		 * "mode" => "submit"
		 * ]);
		 * $articles = null;
		 * if (count($response['response']['array']) > 0) {
		 * $products = $response['response']['array'];
		 * foreach ($products as $article => $enable) {
		 * if ($enable) {
		 * $articles[] = $article;
		 * }
		 * }
		 * }
		 *
		 *
		 * $allowedArticle = [];
		 * $q = $this->modx->newQuery('fdkPreparePrices');
		 * $q->select('article');
		 * if ($q->prepare() && $q->stmt->execute()) {
		 * while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
		 * $allowedArticle[$row['article']] = true;
		 * }
		 * }
		 * $results = [];
		 * foreach ($articles as $article) {
		 * if (array_key_exists($article, $allowedArticle)) {
		 * $results[] = $article;
		 * }
		 * }
		 * return $results;
		 * }, $this->cache);
		 * return $articles;
		 * }  */

		public function submitToSite($cache = TRUE)
		{
			// Кэшируем по умолчанию
			$articles = cacheValuesSite($this->modx, 'submit_to_site_artelamp_it2' . $this->cachePrefix, function (modX $modx) {
				$response = $this->send('submit_to_site', [
					"site" => "artelamp.it",
					"mode" => "submit",
				]);
				$articles = NULL;
				if (count($response['response']['array']) > 0) {
					$products = $response['response']['array'];
					foreach ($products as $article => $enable) {
						if ($enable) {
							$articles[] = $article;
						}
					}
				}
				return $articles;
			},                          $cache);
			return $articles;
		}

	}
