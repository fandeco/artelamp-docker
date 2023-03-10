<?php


	ini_set("memory_limit", '5120m');
	include_once MODX_CORE_PATH . 'classes/feeds/google.feed.php';

	/**
	 * Запись новых слов в словари
	 */
	class CrontabControllerFeedsGoogle extends modCrontabController
	{
		public function initialize()
		{
			return parent::initialize(); // TODO: Change the autogenerated stub
		}


		public function process()
		{

			$data = new FeedData($this->modx);
			$data->setShop($this->modx->getOption('site_name'), $this->modx->getOption('site_name'), $this->modx->getOption('site_url'));
			$data->config['products']['conditions'] = [
				[
					'page.published' => 1, 'page.deleted' => 0,
				],
			];
			//			$data->config['products']['limit'] = 5;
			$xml = new ymlGoogle($data);
			$xml->process();
			$xml->generate(MODX_BASE_PATH . 'media/google.xml');
			$x        = file_get_contents(MODX_BASE_PATH . 'media/google.xml');
			$x        = str_replace(['dev1.artelamp.massive.ru', 'http://artelamp.it', 'https://artelamp.it', 'http://artelamp.ru'], [
				'artelamp.ru', 'https://artelamp.ru', 'https://artelamp.ru', 'https://artelamp.ru'
			],                      $x);
			$filename = MODX_BASE_PATH . 'media/google.xml';
			file_put_contents($filename, $x);
			$this->feed2Json();

			$value = str_ireplace(MODX_BASE_PATH, $this->modx->getOption('site_url'), $filename);
			$this->print_msg('URL: ' . $value);
			return 'ok';
		}

		public function feed2Json()
		{
			try {
				$xx4 = $this->xml2array(MODX_BASE_PATH . 'media/google.xml', 'contents');
				file_put_contents(MODX_BASE_PATH . 'media/google.json', json_encode($xx4['channel']['item'], 256));
			} catch (exception $e) {
			}
		}

		public function xml2array($url, $get_attributes = 1, $priority = 'tag')
		{
			$contents = "";
			if (!function_exists('xml_parser_create')) {
				return [];
			}
			$parser = xml_parser_create('');
			if (!($fp = @fopen($url, 'rb'))) {
				return [];
			}
			while (!feof($fp)) {
				$contents .= fread($fp, 8192);
			}
			fclose($fp);
			xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
			xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
			xml_parse_into_struct($parser, trim($contents), $xml_values);
			xml_parser_free($parser);
			if (!$xml_values) {
				return FALSE;
			} //Hmm...
			$xml_array          = [];
			$parents            = [];
			$opened_tags        = [];
			$arr                = [];
			$current            = &$xml_array;
			$repeated_tag_index = [];
			foreach ($xml_values as $data) {
				unset($attributes, $value);
				extract($data);
				$result          = [];
				$attributes_data = [];
				if (isset($value)) {
					if ($priority === 'tag') {
						$result = $value;
					} else {
						$result['value'] = $value;
					}
				}
				if (isset($attributes) and $get_attributes) {
					foreach ($attributes as $attr => $val) {
						if ($priority === 'tag') {
							$attributes_data[$attr] = $val;
						} else {
							$result['attr'][$attr] = $val;
						} //Set all the attributes in a array called 'attr'
					}
				}
				if ($type === "open") {
					$parent[$level - 1] = &$current;
					if (!is_array($current) or (!in_array($tag, array_keys($current)))) {
						$current[$tag] = $result;
						if ($attributes_data) {
							$current[$tag . '_attr'] = $attributes_data;
						}
						$repeated_tag_index[$tag . '_' . $level] = 1;
						$current                                 = &$current[$tag];
					} else {
						if (isset($current[$tag][0])) {
							$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
							$repeated_tag_index[$tag . '_' . $level]++;
						} else {
							$current[$tag]                           = [
								$current[$tag],
								$result,
							];
							$repeated_tag_index[$tag . '_' . $level] = 2;
							if (isset($current[$tag . '_attr'])) {
								$current[$tag]['0_attr'] = $current[$tag . '_attr'];
								unset($current[$tag . '_attr']);
							}
						}
						$last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
						$current         = &$current[$tag][$last_item_index];
					}
				} elseif ($type === "complete") {
					if (!isset($current[$tag])) {
						$current[$tag]                           = $result;
						$repeated_tag_index[$tag . '_' . $level] = 1;
						if ($priority === 'tag' && $attributes_data) {
							$current[$tag . '_attr'] = $attributes_data;
						}
					} else {
						if (isset($current[$tag][0]) && is_array($current[$tag])) {
							$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
							if ($priority === 'tag' && $get_attributes && $attributes_data) {
								$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
							}
							$repeated_tag_index[$tag . '_' . $level]++;
						} else {
							$current[$tag]                           = [
								$current[$tag],
								$result,
							];
							$repeated_tag_index[$tag . '_' . $level] = 1;
							if ($priority === 'tag' && $get_attributes) {
								if (isset($current[$tag . '_attr'])) {
									$current[$tag]['0_attr'] = $current[$tag . '_attr'];
									unset($current[$tag . '_attr']);
								}
								if ($attributes_data) {
									$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
								}
							}
							$repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
						}
					}
				} elseif ($type === 'close') {
					$current = &$parent[$level - 1];
				}
			}
			return ($xml_array);
		}
	}
