<?php

	class EasypackGetTablesProcessor extends modProcessor
	{

		public function process()
		{
			$query = $this->getProperty('key');
			$array = [];
			if ($query) {

				$array[] = [
					'key' => $query,
				];
				$q       = $this->modx->query('SHOW TABLES LIKE "%' . $query . '%"');
			} else {
				$q = $this->modx->query('SHOW TABLES');
			}
			while ($row = $q->fetch(PDO::FETCH_COLUMN)) {
				$array[] = [
					'key' => $row,
				];
			}
			return $this->outputArray($array);
		}

		public function outputArray(array $array, $count = FALSE)
		{
			if ($count === FALSE) {
				$count = count($array);
			}
			$output = json_encode([
									  'success' => TRUE,
									  'total'   => $count,
									  'results' => $array,
								  ]);
			if ($output === FALSE) {
				$this->modx->log(modX::LOG_LEVEL_ERROR, 'Processor failed creating output array due to JSON error ' . json_last_error());
				return json_encode(['success' => FALSE]);
			}
			return $output;
		}
	}

	return 'EasypackGetTablesProcessor';