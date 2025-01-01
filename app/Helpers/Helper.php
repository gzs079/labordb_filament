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

if (! function_exists('generateHSLColor')) {
    function generateHSLColor($index, $total) {
        $hue = ($index / $total) * 360;  // 360 fokos színkör, elosztva az adatok számával
        return "hsl($hue, 70%, 50%)";  // Képletes HSL szín
    }
}

if (! function_exists('generateColor')) {
    function generateColor($index) {
        $colors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
            'rgb(100, 150, 200)',
            'rgb(255, 0, 255)',
            'rgb(0, 255, 0)',
            'rgb(0, 0, 255)',
            'rgb(255, 165, 0)',
            'rgb(128, 0, 128)',
            'rgb(0, 255, 255)',
            'rgb(255, 255, 0)',
            'rgb(0, 0, 0)',
        ];
        return [
            'color' => $colors[$index],
            'total' => count($colors),
        ];
    }
}
