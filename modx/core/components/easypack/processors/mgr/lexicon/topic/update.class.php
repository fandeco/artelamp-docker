<?php

	/**
	 * Date: 10.06.2020
	 * Time: 21:10
	 */
	class EasypackLexiconTopicGetListProcessor extends modProcessor
	{
		public $classKey = 'EasypackExtras';

		public function process()
		{
			$response = $this->update();
			$c        = $this->modx->getCacheManager();
			$c->refresh([
							'lexicon_topics' => [],
						]);
			return $response;
		}

		public function update()
		{
			$id    = $this->getProperty('extras', $this->modx->getOption('easypack_lex_extras', $_COOKIE, NULL));
			$lang  = $this->getProperty('lang', $this->modx->getOption('easypack_lex_lang', $_COOKIE, NULL));
			$topic = $this->getProperty('topic', $this->modx->getOption('easypack_lex_topic', $_COOKIE, NULL));
			$key   = $this->getProperty('key', FALSE);
			$value = $this->getProperty('value', NULL);
			if ($id and $lang and $topic and $key) {
				$this->Easypack = $this->modx->getObject($this->classKey, $id);
				if (!$this->Easypack) {
					return $this->outputArray();
				}
				$core     = $this->Easypack->getProperty('core');
				$langPath = MODX_BASE_PATH . $core . '/lexicon/' . $lang . '/' . $topic;
				if (file_exists($langPath) and is_file($langPath)) {
					$_lang = [];
					include $langPath;
					if ($value) {
						$parser = $this->modx->getParser();
						if (array_key_exists('pdoTools', $parser)) {
							$_lang[$key] = $parser->pdoTools->getChunk('@INLINE ' . $value, []);
							if (!$_lang[$key]) {
								$_lang[$key] = (string)$value;
							}
						} else {
							$_lang[$key] = (string)$value;
						}
					} else {
						unset($_lang[$key]);
					}
					unset($_lang['']);
					ksort($_lang);
					$txt = $this->arrayToPhp($_lang);
					if (is_writable($langPath)) {
						$oldHash = md5_file($langPath);
						$midHash = md5($txt);
						if ($oldHash == $midHash) {
							return $this->success('has not change');
						}
						file_put_contents($langPath, $txt);
						$newHash = md5_file($langPath);
						if ($oldHash == $newHash) {
							return $this->failure('has not change');
						} else {
							return $this->success('ok');
						}
					} else {
						return $this->failure('is not writeble');
					}
					return $this->success($txt);
				}
				return $this->failure();
			}
			return $this->failure();
		}

		public function arrayToPhp(array $array = [])
		{
			$txt     = var_export($array, TRUE);
			$pattren = <<<EOT
<?php
	# generated by EasyPack
	/** @var array \$_lang */
	\$_lang = array_merge(
		$txt
		, \$_lang);
	
EOT;
			return $pattren;
		}
	}

	return "EasypackLexiconTopicGetListProcessor";
