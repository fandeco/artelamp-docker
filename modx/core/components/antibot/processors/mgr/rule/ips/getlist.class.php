<?php

class antiBotRuleGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'antiBotHits';
    public $classKey = 'antiBotHits';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    /* @var antiBotRule $Rule */
    public $Rule;
    public $languageTopics = ['antibot:manager'];

    //public $permission = 'list';
    public function initialize()
    {
        $rule_id = $this->getProperty('rule_id');


        if (!$this->Rule = $this->modx->getObject('antiBotRule', $rule_id)) {
            return 'Не удалось получить Правило';
        }


        if (!$this->Rule->get('active')) {
            return 'Правило отключено список IP адресов получить невозможно';
        }

        return parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {

        $c = $this->Rule->getCriteria($c);

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'antiBotHits.ip:LIKE' => "%{$query}%",
                'OR:antiBotHits.user_agent:LIKE' => "%{$query}%",
            ]);
        }


       # $c->prepare(); echo '<pre>'; print_r($c->toSQL()); die;
        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        /* @var antiBotRule $object */
        $array = $object->toArray();
        $array['actions'] = [];

        if ($array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('antibot_rule_collection'),
                'action' => 'colletionRule',
                'button' => true,
                'menu' => true,
            ];
            $array['actions'][] = '-';
        }
        return $array;
    }

}

return 'antiBotRuleGetListProcessor';
