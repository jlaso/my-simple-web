<?php


namespace app\models\core\Form;

/**
 * This filter extracts first characters of text passed same wordpress does
 *
 * Use: in EntityFormType sets this in filter option with limit, default 50
 *
 *   ->add('content', 'text', array( 'label' =>_('Content'),
 *                                   'filter'=> new MoreFormFilter(array(
 *                                                  'limit'=>50
 *                                 ))))
 *
 */
class MoreFormFilter extends BaseFormFilter
{

    /**
     * More filter that returns only first characters
     *
     * @param mixed $subject
     * @param mixed $options,  array(length)
     *
     * @return mixed
     */
    function filter($subject)
    {
        $this->setDefaultOptions(array(
            'limit' => 50,
        ));
        $limit = $this->options['limit'];
        $subject = strip_tags($subject);
        if (strlen($subject)<=$limit) {
            return $subject;
        }
        $pos = strpos($subject,' ', $limit - 5);
        if ($pos<$limit){
            $limit=$pos;
        }

        return substr($subject, 0, $limit).'...';
    }


}