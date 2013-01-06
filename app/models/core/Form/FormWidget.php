<?php

namespace app\models\core\Form;

class FormWidget
{

    /**
     * render the field label
     *
     * @param array $item
     * @return html formatted string
     */
    public static function form_label(array $item)
    {
        $label =  isset($item['widget']['label'])?$item['widget']['label']:$item['field'];

        return '<label class="control-label span2" for="input'.ucfirst($item['field']).'">'.ucfirst($label).'</label>';
    }

    /**
     * render the input field type corresponding as the info passed in $item
     *
     * @param array $item
     * @param array $value
     * @return html formatted string
     */
    public static function form_field($item, $value)
    {
        $result = '<div class="controls">';
        $field  = $item['field'];
        $placeH = isset($item['placeholder'])?$item['placeholder']:'';
        $type   = strtolower($item['type']);
        $val    = $value->get($field);
        $ro     = isset($item['widget']['readonly'])?
                    ( $item['widget']['readonly'] ? 'readonly="readonly"' : '')
                  :'';
        $class  = isset($item['widget']['attr']['class']) ? $item['widget']['attr']['class']  : 'span10';
        $class  = 'class="'.$class.'"';

        if (in_array($type,array('text','text','number','hidden','button'))) {
            $result .= '<input name="'.$field.'" '.$class.' id="input'.ucfirst($field).'"';
            $result .= 'placeholder="'.$placeH.'" '.$ro.' type="'.$type.'" value="'.$val.'"/>';
        } else {

            if ($type=='textarea') {
                $result .= sprintf('<textarea name="%s" %s>%s</textarea>',$field,$class,$val);
            }

            if ($type=='p') {
                $result .= sprintf('<p %s>%s</p>',$class,$val);
            }
        }

        $result .= '</div>';

        return $result;
    }

    /**
     * render the error info of field passed
     * @param array $item
     * @param array $errors
     * @return html formatted string
     */
    public static function form_error($item,array $errors)
    {
        $result = '';
        $error  = isset($errors[$item['field']]) ? $errors[$item['field']] : '';
        if ($error) {
            $result = sprintf('<span class="text-error">%s</span>',$error);
        }

        return $result;
    }


    /**
     * render the field search label
     *
     * @param array $item
     * @return html formatted string
     */
    public static function form_search_label(array $item, $fieldL)
    {
        $label =  isset($item['widget']['label']) ? $item['widget']['label'] : $fieldL;

        return sprintf('<label class="control-label span2" for="inputSearch_%s">%s</label>',
                       $fieldL,ucfirst($label));
    }

    /**
     * render the input search field type corresponding as the info passed in $item
     *
     * @param array $item
     * @param array $value
     * @return html formatted string
     */
    public static function form_search_field($item, $value)
    {
        $result = '<div class="controls">';
        $field  = !is_array($item['field']) ? array($item['field']) : $item['field'];
        $fieldL = implode("_",$field);
        $fieldN = sprintf('search[%s]',$fieldL);
        $placeH = isset($item['placeholder'])?$item['placeholder']:'Buscar por '.implode(" o ",$field).'...';
        $type   = strtolower($item['type']);
        $val    = isset($value[$fieldL]) ? $value[$fieldL] : '';
        $ro     = isset($item['widget']['readonly'])?
                  ( $item['widget']['readonly'] ? 'readonly="readonly"' : '')  : '';
        $class  = isset($item['widget']['attr']['class']) ? $item['widget']['attr']['class']  : 'span10';
        $class  = 'class="'.$class.'"';

        if (in_array($type,array('text','number'))) {
            $result .= '<input name="'.$fieldN.'" '.$class.' id="inputSearch_'.$fieldL.'"';
            $result .= 'placeholder="'.$placeH.'" '.$ro.' type="search" value="'.$val.'"/>';
        } else {

            if ($type=='text:from-to') {
                $valFrom = isset($val['from']) ? $val['from'] : '';
                $valTo   = isset($val['to']) ? $val['to'] : '';
                $result .= 'de <input name="'.$fieldN.'[from]" '.$class.' id="inputSearch_'.$fieldL.'_from"';
                $result .= 'placeholder="'.$placeH.'" '.$ro.' type="text" value="'.$valFrom.'"/>';
                $result .= '&nbsp; a <input name="'.$fieldN.'[to]" '  .$class.' id="inputSearch_'.$fieldL.'_to"';
                $result .= 'placeholder="'.$placeH.'" '.$ro.' type="text" value="'.$valTo.'"/>';
            }
            if ($type=='textarea') {
                $result .= '<textarea '.$class.'>'.$val.'</textarea>';
            }

            if ($type=='p') {
                $result .= '<p '.$class.'>'.$val.'</p>';
            }
        }

        $result .= '</div>';

        return $result;
    }

    /**
     * render the complete widget for a field, that is:  label + input + errors
     *
     * @param array $item
     * @param array $value
     * @param array $errors
     * @return html formatted string
     */
    public static function form_widget(array $item, $value, array $errors)
    {
        return self::form_label($item).
               self::form_field($item, $value).
               self::form_error($item, $errors);
    }

    /**
     * render the complete widget for a search field, that is:  label + input + errors
     *
     * @param array $item
     * @param array $value
     * @param array $errors
     * @return html formatted string
     */
    public static function form_search_widget($item, $value, $errors)
    {

        return self::form_search_label($item, '').
               self::form_search_field($item, $value)/*.
               self::form_error($item, $errors)*/;
    }

    public static function form_row_show(FormListBase $form)
    {
        $result = '';
        foreach ($form as $item) {
            //$result .= self::form_widget($item);
        }

        return $result;

    }

    /**
     * renders the table head of a list of records
     *
     * @param array $form
     * @return html formatted string
     */
    public static function form_table_head(array $form)
    {
        $result = '';
        foreach ($form as $item) {

            $label = isset($item['widget']['label'])?$item['widget']['label']:$item['field'];
            $type  = $item['type'];
            if ($type=='boolean') {
                $label = '<i class="icon-check"></i>&nbsp;'.$label;
            }
            $result .= sprintf('<th><span>%s</span></th>',$label);
        }

        return $result;
    }

    /**
     * renders the table row of $values record specified
     *
     * @param array $form
     * @param array $values
     * @return html formatted string
     */
    public static function form_table_row(array $form, $values)
    {
        $result = '';
        foreach ($form as $item) {
            $class = isset($item['widget']['attr']['class']) ? $item['widget']['attr']['class'] : '';
            $type  = $item['type'];
            $field = $item['field'];
            $value = $values->get($field);
            if ($type=="date" || $type=="date-time") {
                $date  = \DateTime::createFromFormat("Y-m-d h:i:s",$value);
                $value = $date->format('d/m/Y'.($type=='date-time'?' h:i:s':''));
            }
            if ($type=='boolean' && $value) {
                $class = "span12 center";
                $value = '<i class="icon-check"></i>';
            }
            if($value==='') $value="&nbsp;";
            $result .= sprintf('<td><span class="%s">%s</span></td>',$class,$value);
        }

        return $result;
    }




}
