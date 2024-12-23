<?php

if (! function_exists('calculate_loq')) {
    function calculate_loq($value) {

        $value = str_replace(',','.',$value);

        if (substr($value, 0, 1) === '<') {
            return (float) substr($value, 1);
        }
        return null;
    }
}

if (! function_exists('calculate_maxrange')) {
    function calculate_maxrange($value) {

        $value = str_replace(',','.',$value);

        if (substr($value, 0, 1) === '>') {
            return (float) substr($value, 1);
        }
        return null;
    }
}

if (! function_exists('calculate_valueassigned')) {
    function calculate_valueassigned($value) {

        $value = str_replace(',','.',$value);

        if (substr($value, 0, 1) === '<') {
            return (float) substr($value, 1)/2.;
        }
        elseif (substr($value, 0, 1) === '>') {
            return (float) substr($value, 1);
        }
        else {
            if (is_numeric($value)) {
                return (float)$value;
            }
            else {
                return null;
            }
        }
    }
}
