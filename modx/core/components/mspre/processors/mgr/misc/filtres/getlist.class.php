<?php


class modmspreFiltersGetListProcessor extends modObjectProcessor
{
    /* @var mspre|null $mspre */
    public $mspre = null;
    public $languageTopics = array('mspre', 'mspre:combo');

    public function initialize()
    {
        $controller = $this->getProperty('controller');
        if (empty($controller)) {
            $msg = $this->modx->lexicon('mspre_filtres_err_controller');
            $this->modx->log(modX::LOG_LEVEL_ERROR, $msg, '', __METHOD__, __FILE__, __LINE__);
            return $msg;
        }

        /* @var mspre $mspre */
        $this->mspre = $this->modx->getService('mspre', 'mspre', MODX_CORE_PATH . 'components/mspre/model/');

        if (!$this->mspre->allowedController($controller)) {
            $msg = $this->modx->lexicon('mspre_filtres_err_controller_allowed', array('controller' => $controller));
            $this->modx->log(modX::LOG_LEVEL_ERROR, $msg, '', __METHOD__, __FILE__, __LINE__);
            return $msg;
        }

        return parent::initialize(); // TODO: Change the autogenerated stub
    }

    /** {@inheritDoc} */
    public function process()
    {

        $controller = $this->getProperty('controller');
        $fields = null;
        switch ($controller) {
            case 'product':
                $product = $this->modx->newObject('msProduct');
                $fields = $product->getAllFieldsNames();
                break;
            case 'resource':
                $fields = array_keys($this->modx->getFields('modResource'));
                break;
            default:
                break;
        }

        if (empty($fields)) {
            $msg = $this->modx->lexicon('mspre_filtres_err_controller_fields');
            $this->modx->log(modX::LOG_LEVEL_ERROR, $msg, '', __METHOD__, __FILE__, __LINE__);
            return $this->failure($msg);
        }

        $array = array();
        foreach ($fields as $field) {
            $array[] = array(
                'value' => $field,
                'key' => $field
            );
        }
        $query = $this->getProperty('query');
        if (!empty($query)) {
            foreach ($array as $k => $format) {
                if (stripos($format['value'], $query) === false) {
                    unset($array[$k]);
                }
            }
            sort($array);
        }
        return $this->outputArray($array);
    }

    /** {@inheritDoc} */
    public function outputArray(array $array, $count = false)
    {
        if ($this->getProperty('addall')) {
            $array = array_merge_recursive(array(
                array(
                    'name' => $this->modx->lexicon('mspre_status_all'),
                    'value' => ''
                )
            ), $array);
        }

        return parent::outputArray($array, $count);
    }

}

return 'modmspreFiltersGetListProcessor';