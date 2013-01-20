<?php


namespace app\models\core\Search;

class SearchQueryBuilder implements SearchQueryBuilderInterface
{


    private $query;

    private $params;

    private $data;

    private $form;

    public function __construct(array $form, array $data)
    {
        $this->data   = $data;
        $this->form   = $form;
        $this->query  = null;
        $this->params = null;
    }

    public function buildQuery()
    {
        $query = array();
        foreach ($this->form as $item) {

            $field  = !is_array($item['field']) ? array($item['field']) : $item['field'];
            $fieldN = implode("_",$field);
            $type   = strtolower($item['type']);

            if (isset($this->data[$fieldN]) && ($data = $this->data[$fieldN])) {

                $qry  = array();
                if ($type=='text:from-to') {

                    if (isset($data['from']) && $data['from']) {
                        $qry[] = sprintf("( `%s` >= ? )",$field[0]);
                        $this->params[] = $data['from'];
                    }
                    if (isset($data['to']) && $data['to']) {
                        $qry[] = sprintf("( `%s` <= ? )",$field[0]);
                        $this->params[] = $data['to'];
                    }
                    if (count($qry)) {
                        $query[] = sprintf('( %s )',implode(' and ',$qry));
                    }
                }else{
                    $op = (($type == 'text') && isset($item['widget']['op'])) ? $item['widget']['op'] : '=';
                    if ($op == 'like')  $data = '%'.$data.'%' ;
                    foreach ($field as $fld) {
                        $qry[] = sprintf("( `%s` %s ? )",$fld,$op);
                        $this->params[] = $data;
                    }
                    if (count($qry)) {
                        $query[] = sprintf('( %s )',implode(' or ',$qry));
                    }
                }
            }


        }

        $this->query = implode(' and ',$query);
        return array('query' => $this->query, 'params' => $this->params);
    }


    public function getQuery()
    {
        return $this->query;
    }

    public function getParams()
    {
        return $this->params;
    }

}