<?php

// Load the original form helper manually
require_once SYSTEMPATH . 'Helpers/form_helper.php';

if(!function_exists('formFloatingInput'))
{
    function formFloatingInput(array $options = []): string
    {

        $field = get_options( $options ); 

        $output  = '<div class="' . esc($field['colClass']) . '">' . PHP_EOL;
        $output .= "\t<div class=\"form-floating\">" . PHP_EOL;
        $output .= $field['inputField'];
        $output .= "\t</div>" . PHP_EOL;
        $output .= "</div>" . PHP_EOL;

        return $output;

    }
}


function get_options(array $options = []): array
{

    // Defaults
    $options['name']           ??= '';
    $options['select_options'] ??= [];
    $options['value']          ??= '';
    $options['selected']       ??= '';
    $options['extra']          ??= [];
    $options['colClass']       ??= '';
    $options['label']          ??= null;
    $options['inputClass']     ??= 'form-control'; 
    $options['type']           ??= 'text';

    // Enhance 'extra' array
    $options['extra']['placeholder'] ??= $options['label'];
    $options['extra']['class']       ??= $options['inputClass'];
    $options['extra']['id']          ??= $options['name'];

    // Handle input type for text/password/etc. via attribute, not argument
    $options['extra']['type']        ??= $options['type'];

    // Normalize colClass
    $colClass = is_array($options['colClass']) ? $options['colClass'] : [$options['colClass']];
    $options['colClass'] = implode(' ', array_filter($colClass));

    $opt = ['0' => 'Select One' ]; 

    foreach($options['select_options'] as $option)
    {
         $opt[$option->id] = $option->name ?? $option->display_name; 
    }
    $options['select_options'] = $opt; 

  

    // Generate input field HTML
    $str = ''; 
    switch ($options['type']) {
        case 'textarea':
            $str .= "\t\t" .form_textarea($options['name'], $options['value'], $options['extra']) . PHP_EOL;
            $str .= "\t\t" .form_label($options['label'], $options['name']) . PHP_EOL;
            break;

        case 'password':
            $str .= "\t\t" .form_password($options['name'], $options['value'], $options['extra']) . PHP_EOL;
            $str .= "\t\t" .form_label($options['label'], $options['name']) . PHP_EOL;
            break;

        case 'select':
            $str .= "\t\t" .form_dropdown($options['name'], $options['select_options'], $options['selected'], $options['extra']) . PHP_EOL;
            $str .= "\t\t" .form_label($options['label'], $options['name']) . PHP_EOL;
            break;
        case 'multi-select':
            $str .= "\t\t" .form_multiselect($options['name'], $options['select_options'], $options['selected'], $options['extra']) . PHP_EOL;
            //$str .= "\t\t" .form_label($options['label'], $options['name']) . PHP_EOL;
            break;

        default:
            $str .= "\t\t" .form_input($options['name'], $options['value'], $options['extra']) . PHP_EOL;
            $str .= "\t\t" .form_label($options['label'], $options['name']) . PHP_EOL;
            break;
    }

    $options['inputField'] = $str;
    return $options;
}

