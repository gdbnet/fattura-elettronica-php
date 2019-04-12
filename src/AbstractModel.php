<?php

namespace Manrix\FatturaElettronica;

abstract class AbstractModel
{
    /**
     * @param array $array
     * @return array
     */
    public function clean_array(array $array): array
    {
        foreach ($array as $key => $item) {
            is_array($item) && $array [$key] = $this->clean_array($item);
            if (empty ($array[$key])) {
                unset ($array[$key]);
            }
        }

        return $array;
    }
}