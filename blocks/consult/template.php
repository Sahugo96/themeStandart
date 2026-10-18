<?php

defined('ABSPATH') || exit;

set_query_var('consult_data', [
    'subtitle'          => isset($attributes['subtitle']) ? $attributes['subtitle'] : '',
    'title'             => isset($attributes['title']) ? $attributes['title'] : '',
    'text'              => isset($attributes['text']) ? $attributes['text'] : '',
    'contact_label'     => isset($attributes['contact_label']) ? $attributes['contact_label'] : '',
    'phone'             => isset($attributes['phone']) ? $attributes['phone'] : '',
    'input_placeholder' => isset($attributes['input_placeholder']) ? $attributes['input_placeholder'] : '',
    'btn_text'          => isset($attributes['btn_text']) ? $attributes['btn_text'] : '',
    'consents'          => isset($attributes['consents']) && is_array($attributes['consents']) ? $attributes['consents'] : [],
    'image'             => isset($attributes['image']) && is_array($attributes['image']) ? $attributes['image'] : [],
]);

get_template_part('pages/sections/consult');
