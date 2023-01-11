<?php
include_once __DIR__ . '/_default.php';

/**
 * Демонстрация контроллера
 */
class CrontabControllerSyncUpdateStocks extends CrontabControllerSync
{
    protected $updateIsChange = [];
    protected $stocks = [];
    protected $dataUpdated = [];
    protected $dataIsChange = array();

    public function process()
    {
       # $this->modx->exec("UPDATE {$this->modx->getTableName('fdkPrepareStocks')} SET is_change = '0'");

        echo '<pre>';
        print_r(function_exists('cacheValuesSite'));
        die;


        $q = $this->modx->newQuery('fdkPrepareStocks');
        $q->select($this->modx->getSelectColumns('fdkPrepareStocks', 'fdkPrepareStocks'));
        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $key = $row['vendor_uuid'] . $row['shop_id'] . $row['article'];
                $this->stocks[$key] = [
                    'id' => $row['id'],
                    'stock' => $row['stock'],
                ];
            }
        }

        echo '<pre>';
        print_r($this->stocks);
        die;


        $data = array(
            'article' => 'OML-94513-06_omnilux',
            'shop_id' => '000000023',
            'stock' => '30',
            'vendor_uuid' => 'ad842cd2-eba3-11e7-8102-005056a968c7',
            'timestamp' => '2020-10-30 14:05:10',
            'update_error' => '0',
        );


        $response = null;


        $key = $data['vendor_uuid'] . $data['shop_id'] . $data['article'];
        if (!array_key_exists($key, $this->stocks)) {

            /* @var fdkPrepareStocks $object */
            $object = $this->modx->newObject('fdkPrepareStocks');
            $object->fromArray($data);
            $object->set('is_change', true);
            $object->save();

        } else {

            $old_stock = $this->stocks[$key]['stock'];
            $old_id = $this->stocks[$key]['id'];
            if ($old_stock == $data['stock']) {
                $this->updateIsChange[] = $old_id;
            } else {
                $this->dataUpdated[$old_id] = $data['stock'];
                $this->dataUpdated[2] = $data['stock'];
            }

        }

        if (count($this->dataUpdated) > 5000) {
            $this->updateBD('stock', $this->dataUpdated);
            $this->dataUpdated = [];
        }


        echo '<pre>';
        print_r($this->updateIsChange);
        die;

        if (!empty($this->dataUpdated)) {
            $this->updateBD('stock', $this->dataUpdated);
        }


        $table = $this->modx->getTableName('fdkPrepareStocks');
        $updateIsChange = implode(',', $this->updateIsChange);
        $SQL = "UPDATE {$table} SET `is_change` = '1' WHERE id IN ({$updateIsChange});";
        $this->modx->exec($SQL);


        $this->modx->exec("DELETE FROM {$tr} WHERE is_change = '0'");


        $cache = true;
        $modx = $this->modx;
        $response = $this->cache1CSite($modx, 'all_stock', function () use (& $modx) {
            $Fandeco1cSync = new Fandeco1cSync($modx, array('1c_username' => '212'));
            try {
                $response = $Fandeco1cSync->send('stocks', ['site' => 'fandeco.ru']);
            } catch (Exception $e) {
                $response = $Fandeco1cSync->getResponse();
            }
            return $response;
        }, $cache);


        echo '<pre>';
        print_r(12112);
        die;

        parent::process(); // TODO: Change the autogenerated stub
    }


    public function cache1CSite(modX $modx, $key, $callback, $cache = true)
    {
        $lifetime = 300; // Храним данные 5 минут так как процессы запускаются не чаще этого времени
        $optionsCache = array(
            xPDO::OPT_CACHE_KEY => 'default/1c_cache/',
            xPDO::OPT_CACHE_HANDLER => 'xPDOFileCache'
        );
        $newValues = null;
        if ($cache) {
            /* @var modCacheManager $cacheManager */
            $cacheManager = $modx->getCacheManager();
            $newValues = $cacheManager->get($key, $optionsCache);
        }
        if (empty($newValues)) {
            $newValues = $callback($modx);
            if (!is_null($newValues) and $cache) {
                if (!$response = $cacheManager->set($key, $newValues, $lifetime, $optionsCache)) {
                    $modx->log(modX::LOG_LEVEL_ERROR, "Error save " . $key, '', __METHOD__, __FILE__, __LINE__);
                }
            }
        }
        return $newValues;
    }


    /**
     * @param $field
     * @param $data
     * @return bool
     */
    private function updateBD($field, $data, $table = null)
    {
        if (!is_array($data) or count($data) == 0) {
            return false;
        }
        $response = false;
        switch ($field) {
            case 'stock':
                $tableData = $table ? $table : $this->modx->getTableName('fdkPrepareStocks');
                $ids = implode(',', array_keys($data));


                $then = array();

                foreach ($data as $product_id => $value) {
                    $then[] = "WHEN id = {$product_id} THEN {$value}";
                }

                $then = implode(PHP_EOL, $then);

                // Массовое обновление остатка
                $sql = "UPDATE {$tableData} SET `{$field}` = CASE {$then} ELSE `{$field}` END WHERE id in ({$ids})";

                echo '<pre>';
                print_r($sql);
                die;

                $stmt = $this->modx->prepare($sql);
                $response = $stmt->execute();

                break;
            default:
                break;
        }
        return $response;

    }
}