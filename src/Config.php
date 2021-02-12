<?php

namespace Petap\View;

/**
 * Class Config
 * @package Petap\View
 */
class Config
{
    /**
     * @var array
     */
    private array $options = [];

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * @param array $view
     * @return array
     */
    public function applyInheritance(array $view) : array
    {
        $inheritanceChain = $this->getInheritanceChain($view);
        array_unshift($inheritanceChain, $view);

        return call_user_func_array('array_replace_recursive', array_reverse($inheritanceChain));
    }

    /**
     * @param array $view
     * @return array
     */
    public function getInheritanceChain(array $view) : array
    {
        $chain = [];

        while (true) {
            if (!empty($view['extend'])) {
                $parent = $view['extend'];

                if (isset($chain[$parent])) {
                    throw new \UnexpectedValueException("Parent view '$parent' already exists in inheritance chain");
                }

                if (!isset($this->options[$parent])) {
                    throw new \UnexpectedValueException("Parent view '$parent' not found ");
                }

                $chain[$parent] = $this->options[$parent];
                $view = $chain[$parent];
            } else {
                break;
            }
        }

        return array_values($chain);
    }
}
