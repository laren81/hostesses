<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute трябва да бъде приет.',
    'active_url'           => ':attribute не е валиден URL адрес.',
    'after'                => ':attribute трябва да бъде дата след :date.',
    'after_or_equal'       => ':attribute трябва да бъде дата след или равна на :date.',
    'alpha'                => ':attribute може да съдържа само букви.',
    'alpha_dash'           => ':attribute може да съдържа само букви, цифри и тирета.',
    'alpha_num'            => ':attribute може да съдържа само букви и цифри.',
    'array'                => ':attribute трябва да бъде масив.',
    'before'               => ':attribute трябва да бъде дата преди :date.',
    'before_or_equal'      => ':attribute трябва да бъде дата преди или равна на :date.',
    'between'              => [
        'numeric' => ':attribute трябва да бъде между :min и :max.',
        'file'    => ':attribute трябва да бъде между :min и :max килобайта.',
        'string'  => ':attribute трябва да бъде между :min и :max знака.',
        'array'   => ':attribute трябва да бъде между :min и :max елемента.',
    ],
    'boolean'              => 'Полето :attribute трябва да е вярно или невярно.',
    'confirmed'            => 'Полето :attribute за потвърждение не съвпада.',
    'date'                 => ':attribute не е валидна дата.',
    'date_format'          => ':attribute не съответства на формата :format.',
    'different'            => ':attribute и :other трябва да бъдат различни.',
    'digits'               => ':attribute трябва да бъде :digits цифри.',
    'digits_between'       => ':attribute трябва да бъде между :min и :max цифри.',
    'dimensions'           => ':attribute има невалидни размери на изображението.',
    'distinct'             => 'Полето :attribute има дублирана стойност.',
    'email'                => ':attribute трябва да е валиден email адрес.',
    'exists'               => 'Избраният :attribute е невалиден.',
    'file'                 => ':attribute трябва да е файл.',
    'filled'               => 'Полето :attribute трябва да има стойност.',
    'image'                => 'Качния файл трябва да е изображение.',
    'in'                   => 'Избраният :attribute е невалиден.',
    'in_array'             => 'Полето :attribute не съществува в :other.',
    'integer'              => 'Полето :attribute трябва да е цяло число.',
    'ip'                   => ':attribute трябва да е валиден IP адрес.',
    'json'                 => ':трябва да бъде валиден JSON низ.',
    'max'                  => [
        'numeric' => ':attribute не може да бъде по-голям от :max.',
        'file'    => ':attribute не може да бъде по-голям от :max килобайта.',
        'string'  => ':attribute не може да бъде по-голям от :max знака.',
        'array'   => ':attribute не може да бъде по-голям от :max елемента.',
    ],
    'mimes'                => ':attribute трябва да бъде файл от тип: :values.',
    'mimetypes'            => ':attribute трябва да бъде файл от тип: :values.',
    'min'                  => [
        'numeric' => ':attribute трябва да бъде най-малко :min.',
        'file'    => ':attribute трябва да бъде най-малко :min килобайта.',
        'string'  => ':attribute трябва да бъде най-малко :min знака.',
        'array'   => ':attribute трябва да бъде най-малко :min елемента.',
    ],
    'not_in'               => 'Избраният :attribute е невалиден.',
    'numeric'              => 'Полето :attribute трябва да е число.',
    'present'              => ':attribute полето трябва да присъства.',
    'regex'                => ':attribute формат е невалиден.',
    'required'             => 'Полето :attribute е задължително.',
    'required_if'          => 'Полето :attribute е задължително когато :other е :value.',
    'required_unless'      => 'Полето :attribute е задължително.',
    'required_with'        => 'Полето :attribute е задължително когато :values e налице.',
    'required_with_all'    => 'Полето :attribute е задължително когато :values e налице.',
    'required_without'     => 'Полето :attribute е задължително когато :values не e налице.',
    'required_without_all' => 'Полето :attribute е задължително когато нито една от :values са налице.',
    'same'                 => ':attribute и :other трябва да съвпадат.',
    'size'                 =>   [
                                    'numeric' => ':attribute трябва да бъде :size.',
                                    'file'    => ':attribute трябва да бъде :size килобайта.',
                                    'string'  => ':attribute трябва да бъде :size знака.',
                                    'array'   => ':attribute трябва да съдържа :size елемента.',
                                ],
    'string'               => ':attribute трябва да бъде низ.',
    'timezone'             => ':attribute трябва да бъде валидна времева зона.',
    'unique'               => ':attribute вече е зает.',
    'uploaded'             => ':attribute не успя да качи.',
    'url'                  => ':attribute форматът е невалиден.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Име',        
    ],

];
