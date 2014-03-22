<?php

namespace app\models\core\Pagination;

use app\models\core\Pagination\PaginationRenderInterface;
use app\models\core\Pagination\Paginable;

class PaginationRender implements PaginationRenderInterface
{

    private $options;

    private $paginator;

    public function __construct(Paginable $paginator)
    {
        $this->paginator = $paginator;
        $this->setOptions();
    }

    public function setOptions(array $options = array())
    {
        $this->options = array_merge(
            array(
                'proximity'           => 3,
                'prev_message'        => '&larr; Previous',
                'prev_disabled_href'  => '',
                'next_message'        => 'Next &rarr;',
                'next_disabled_href'  => '',
                'dots_message'        => '&hellip;',
                'dots_href'           => '',
                'css_container_class' => 'pagination spain8 pagination-right',
                'css_prev_class'      => 'prev',
                'css_next_class'      => 'next',
                'css_disabled_class'  => 'disabled',
                'css_dots_class'      => 'disabled',
                'css_active_class'    => 'active',
            ),
            $options
        );
    }


    public function render()
    {

        $page     = $this->paginator->getCurrentPage();
        $numpages = $this->paginator->getPages();

        $startPage = $page - $this->options['proximity'];
        $endPage   = $page + $this->options['proximity'];

        if ($startPage < 1) {
            $endPage = min($endPage + (1 - $startPage), $numpages);
            $startPage = 1;
        }
        if ($endPage > $numpages) {
            $startPage = max($startPage - ($endPage - $numpages), 1);
            $endPage = $numpages;
        }

        $pages  = array();

        // previous
        $class  = $this->options['css_prev_class'];
        $url    = $this->options['prev_disabled_href'];
        if (!$this->paginator->hasPreviousPage()) {
            $class .= ' '.$this->options['css_disabled_class'];
        } else {
            $url = $this->paginator->getRouteForPage($this->paginator->getPreviousPage());
        }

        $pages[] = sprintf('<li class="%s"><a href="%s">%s</a></li>', $class, $url, $this->options['prev_message']);


        // first
        if ($startPage > 1) {
            $pages[] = sprintf('<li><a href="%s">%s</a></li>', $this->paginator->getRouteForPage(1), 1);
            if (3 == $startPage) {
                $pages[] = sprintf('<li><a href="%s">%s</a></li>', $this->paginator->getRouteForPage(2), 2);
            } elseif (2 != $startPage) {
                $pages[] = sprintf('<li class="%s"><a href="%s">%s</a></li>', $this->options['css_dots_class'], $this->options['dots_href'], $this->options['dots_message']);
            }
        }

        // pages
        for ($i = $startPage; $i <= $endPage; $i++) {
            $class = '';
            if ($i == $page) {
                $class = sprintf(' class="%s"', $this->options['css_active_class']);
            }

            $pages[] = sprintf('<li%s><a href="%s">%s</a></li>', $class, $this->paginator->getRouteForPage($i), $i);
        }

        // last
        if ($numpages > $endPage) {
            if ($numpages > ($endPage + 1)) {
                if ($numpages > ($endPage + 2)) {
                    $pages[] = sprintf('<li class="%s"><a href="%s">%s</a></li>', $this->options['css_dots_class'], $this->options['dots_href'], $this->options['dots_message']);
                } else {
                    $pages[] = sprintf('<li><a href="%s">%s</a></li>', $this->paginator->getRouteForPage($endPage + 1), $endPage + 1);
                }
            }

            $pages[] = sprintf('<li><a href="%s">%s</a></li>', $this->paginator->getRouteForPage($this->pages), $this->pages);
        }

        // next
        $class  = $this->options['css_next_class'];
        $url    = $this->options['next_disabled_href'];
        if (!$this->paginator->hasNextPage()) {
            $class .= ' '.$this->options['css_disabled_class'];
        } else {
            $url = $this->paginator->getRouteForPage($this->paginator->getNextPage());
        }

        $pages[] = sprintf('<li class="%s"><a href="%s">%s</a></li>', $class, $url, $this->options['next_message']);

        return sprintf('<div class="%s"><ul>%s</ul></div>',$this->options['css_container_class'],implode('', $pages));
    }


}