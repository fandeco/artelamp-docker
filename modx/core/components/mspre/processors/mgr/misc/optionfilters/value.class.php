<?php

class msOptionGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'msProductOption';
    public $defaultSortField = 'key';
    public $defaultSortDirection = 'ASC';

    /* @var null|array $parents */
    public $parents = null;

    public function initialize()
    {
        $this->modx->getService('minishop2', 'miniShop2', MODX_CORE_PATH . 'components/minishop2/model/');
        return parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->select($this->modx->getSelectColumns('msProductOption', 'msProductOption', '', array('value'), false));
        $option_key = trim($this->getProperty('option_key'));
        $c->where(array(
            'key' => $option_key,
            'value:!=' => '',
        ));
        $c->groupby('value');
        if ($query = $this->getProperty('query')) {
            $c->where(array(
                'value:LIKE' => "%$query%",
            ));
        }
        return $c;
    }


    public function getData()
    {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));

        /* query for chunks */
        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey, $c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey, $this->getProperty('sortAlias', $sortClassKey), '', array($this->getProperty('sort')));
        if (empty($sortKey)) $sortKey = $this->getProperty('sort');
        $c->sortby($sortKey, $this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit, $start);
        }

        $rows = array(
            0 => array(
                'key' => 'option_values_empty',
                'value' => $this->modx->lexicon('mspre_filters_option_values_empty')
            )
        );
        if ($c->prepare() && $c->stmt->execute()) {
            while ($row = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['key'] = $row['value'];
                $rows[] = $row;
            }
        }
        $data['results'] = $rows;


        return $data;
    }

    /**
     * Iterate across the data
     *
     * @param array $data
     * @return array
     */
    public function iterate(array $data)
    {
        $list = array();
        $list = $this->beforeIteration($list);
        $this->currentIndex = 0;
        /** @var xPDOObject|modAccessibleObject $object */
        foreach ($data['results'] as $objectArray) {
            if (!empty($objectArray) && is_array($objectArray)) {
                $list[] = $objectArray;
                $this->currentIndex++;
            }
        }
        $list = $this->afterIteration($list);
        return $list;
    }

    public function afterIteration(array $list)
    {
        return parent::afterIteration($list); // TODO: Change the autogenerated stub
    }
}

return 'msOptionGetListProcessor';