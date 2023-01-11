<?php
ini_set("memory_limit", '5120m');
include_once MODX_CORE_PATH.'classes/ymlYandex.php';
/**
 * Запись новых слов в словари
 */
class CrontabControllerturbopagesyml extends modCrontabController
{
    public function initialize()
    {
        return parent::initialize(); // TODO: Change the autogenerated stub
    }


    public function process()
    {
        $limit = 50000;

        $site_url = $this->modx->getOption('site_url');
        $content = ['web'];
        $root_id = 2;
        $size_images = 'medium';

        $categories = [];
        $q = $this->modx->newQuery('msCategory');
        $q->select('id,pagetitle');
        $q->where(array(
            array('context_key:IN' => $content, 'published' => 1, 'deleted' => 0, 'class_key' => 'msCategory'),
        ));
        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $categories[$row['id']] = $row['pagetitle'];
            }
        }


        $products = array();
        $q = $this->modx->newQuery('msProduct');
        $q->select($this->modx->getSelectColumns('msProduct', 'msProduct', '', []));
        $q->select($this->modx->getSelectColumns('msProductData', 'Data'));
        $q->select('Vendor.name as vendor_name');
        $q->where(array(
            array('context_key:IN' => $content, 'published' => 1, 'deleted' => 0, 'class_key' => 'msProduct', 'parent:IN' => array_keys($categories)),
        ));
        $q->innerJoin('msProductData', 'Data', 'Data.id = msProduct.id');
        $q->leftJoin('msVendor', 'Vendor', 'Vendor.id = Data.vendor');
        $q->limit($limit);
        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['pictures'] = [];
                $products[$row['id']] = $row;
            }
        }

        if (!empty($products)) {
            $q = $this->modx->newQuery('msProductFile');
            $q->select('product_id,url,rank');
            $q->where(array(
                'product_id:IN' => array_column($products, 'id'),
                'path:LIKE' => "%{$size_images}%",
            ));
            $q->sortby('rank');
            if ($q->prepare() && $q->stmt->execute()) {
                while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $products[$row['product_id']]['pictures'][$row['rank']] = $site_url . $row['url'];
                }
            }
        }


        $fields = [
            'volume' => 'Объем',
            'weight_netto' => 'Вес нетто',
            'width' => 'Длина',
            'power' => 'Мощность',
            'voltage' => 'Вольтаж',
            'box_height' => 'Высота коробки',
            'box_length' => 'Длина коробки',
            'box_width' => 'Ширина коробки',
            'ploshad_osvesheniya' => 'Площадь освещения',
            'country_orig' => 'Страна происхождения',
        ];
        $units = [
            'weight_netto' => 'кг',
            'width' => 'см',
            'box_length' => 'см',
            'box_width' => 'см',
            'box_height' => 'см',
            'power' => 'W',
            'voltage' => 'W',
            'ploshad_osvesheniya' => 'м2',
        ];
        $ymlYandex = new ymlYandex($this->modx);
        $response = $ymlYandex->newYml(MODX_BASE_PATH . 'media/yandex.xml')
            ->setShop($this->modx->getOption('site_name'), 'Fandeco', $this->modx->getOption('site_url'))
            ->setCurrency('RUB')
            ->setCategory($categories)
            ->setProducts($products, function ($offer, $product = []) use (& $fields, &$ymlYandex, &$units) {
                /* @var Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple $offer */
                /* @var ymlYandex $ymlYandex */


                foreach ($fields as $field => $caption) {
                    if (!empty($product[$field]) and $product[$field] != '0.00') {


                        $unit = '';
                        if (is_array($units) and array_key_exists($field, $units)) {
                            $unit = $units[$field];
                        }

                        $offer->addParam($ymlYandex->addParam($caption, $product[$field], $unit));
                    }
                }

                return $offer;
            })
            ->generate();


        if ($response !== true) {
            echo '<pre>';
            print_r($response);
            die;
        } else {
            $filename = $ymlYandex->getOutputFile();
        }

        $value = str_ireplace(MODX_BASE_PATH, $this->modx->getOption('site_url'), $filename);
        $this->print_msg('URL: '.$value);
    }

}