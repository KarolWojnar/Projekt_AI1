<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Poniżej znajdują się domyślne wiadomości błędów używane przez klasę walidatora.
    | Niektóre z tych reguł mają wiele wersji, takich jak reguły dotyczące wielkości.
    | Możesz dowolnie dostosować każdą z tych wiadomości tutaj.
    |
    */

    'accepted' => ':attribute musi zostać zaakceptowany.',
    'accepted_if' => ':attribute musi zostać zaakceptowany, jeśli :other jest :value.',
    'active_url' => ':attribute nie jest poprawnym adresem URL.',
    'after' => ':attribute musi być datą późniejszą niż :date.',
    'after_or_equal' => ':attribute musi być datą późniejszą lub równą :date.',
    'alpha' => ':attribute może zawierać tylko litery.',
    'alpha_dash' => ':attribute może zawierać tylko litery, cyfry, myślniki i podkreślenia.',
    'alpha_num' => ':attribute może zawierać tylko litery i cyfry.',
    'array' => ':attribute musi być tablicą.',
    'ascii' => ':attribute może zawierać tylko jednobajtowe znaki alfanumeryczne i symbole.',
    'before' => ':attribute musi być datą wcześniejszą niż :date.',
    'before_or_equal' => ':attribute musi być datą wcześniejszą lub równą :date.',
    'between' => [
        'array' => ':attribute musi mieć od :min do :max elementów.',
        'file' => ':attribute musi mieć od :min do :max kilobajtów.',
        'numeric' => ':attribute musi mieć wartość między :min a :max.',
        'string' => ':attribute musi mieć od :min do :max znaków.',
    ],
    'boolean' => ':attribute musi mieć wartość true lub false.',
    'confirmed' => 'Potwierdzenie dla :attribute nie pasuje.',
    'current_password' => 'Hasło jest nieprawidłowe.',
    'date' => ':attribute nie jest poprawną datą.',
    'date_equals' => ':attribute musi być datą równą :date.',
    'date_format' => ':attribute nie pasuje do formatu :format.',
    'decimal' => ':attribute musi mieć :decimal miejsc po przecinku.',
    'declined' => ':attribute musi być odrzucony.',
    'declined_if' => ':attribute musi być odrzucony, jeśli :other jest :value.',
    'different' => ':attribute i :other muszą być różne.',
    'digits' => ':attribute musi składać się z :digits cyfr.',
    'digits_between' => ':attribute musi mieć od :min do :max cyfr.',
    'dimensions' => ':attribute ma nieprawidłowe wymiary obrazu.',
    'distinct' => ':attribute ma zduplikowaną wartość.',
    'doesnt_end_with' => ':attribute nie może kończyć się żadnym z następujących: :values.',
    'doesnt_start_with' => ':attribute nie może zaczynać się żadnym z następujących: :values.',
    'email' => ':attribute musi być poprawnym adresem email.',
    'ends_with' => ':attribute musi kończyć się jednym z następujących: :values.',
    'enum' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'exists' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'file' => ':attribute musi być plikiem.',
    'filled' => ':attribute musi mieć wartość.',
    'gt' => [
        'array' => ':attribute musi mieć więcej niż :value elementów.',
        'file' => ':attribute musi być większy niż :value kilobajtów.',
        'numeric' => ':attribute musi być większy niż :value.',
        'string' => ':attribute musi być dłuższy niż :value znaków.',
    ],
    'gte' => [
        'array' => ':attribute musi mieć :value elementów lub więcej.',
        'file' => ':attribute musi być większy lub równy :value kilobajtów.',
        'numeric' => ':attribute musi być większy lub równy :value.',
        'string' => ':attribute musi być dłuższy lub równy :value znaków.',
    ],
    'image' => ':attribute musi być obrazem.',
    'in' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'in_array' => ':attribute musi być jednym z elementów :other.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => ':attribute musi być poprawnym adresem IP.',
    'ipv4' => ':attribute musi być poprawnym adresem IPv4.',
    'ipv6' => ':attribute musi być poprawnym adresem IPv6.',
    'json' => ':attribute musi być poprawnym ciągiem JSON.',
    'lowercase' => ':attribute musi być pisane małymi literami.',
    'lt' => [
        'array' => ':attribute musi mieć mniej niż :value elementów.',
        'file' => ':attribute musi być mniejszy niż :value kilobajtów.',
        'numeric' => ':attribute musi być mniejszy niż :value.',
        'string' => ':attribute musi być krótszy niż :value znaków.',
    ],
    'lte' => [
        'array' => ':attribute nie może mieć więcej niż :value elementów.',
        'file' => ':attribute musi być mniejszy lub równy :value kilobajtów.',
        'numeric' => ':attribute musi być mniejszy lub równy :value.',
        'string' => ':attribute musi być krótszy lub równy :value znaków.',
    ],
    'mac_address' => ':attribute musi być poprawnym adresem MAC.',
    'max' => [
        'array' => ':attribute nie może mieć więcej niż :max elementów.',
        'file' => ':attribute nie może być większy niż :max kilobajtów.',
        'numeric' => ':attribute nie może być większy niż :max.',
        'string' => ':attribute nie może być dłuższy niż :max znaków.',
    ],
    'max_digits' => ':attribute nie może mieć więcej niż :max cyfr.',
    'mimes' => ':attribute musi być plikiem typu: :values.',
    'mimetypes' => ':attribute musi być plikiem typu: :values.',
    'min' => [
        'array' => ':attribute musi mieć przynajmniej :min elementów.',
        'file' => ':attribute musi mieć przynajmniej :min kilobajtów.',
        'numeric' => ':attribute musi być co najmniej :min.',
        'string' => ':attribute musi być co najmniej :min znaków.',
    ],
    'min_digits' => ':attribute musi mieć przynajmniej :min cyfr.',
    'missing' => ':attribute musi być puste.',
    'missing_if' => ':attribute musi być puste, jeśli :other ma wartość :value.',
    'missing_unless' => ':attribute musi być puste, chyba że :other ma wartość :value.',
    'missing_with' => ':attribute musi być puste, jeśli :values jest obecne.',
    'missing_with_all' => ':attribute musi być puste, jeśli :values są obecne.',
    'multiple_of' => ':attribute musi być wielokrotnością :value.',
    'not_in' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'not_regex' => 'Format :attribute jest nieprawidłowy.',
    'numeric' => ':attribute musi być liczbą.',
    'password' => [
        'letters' => ':attribute musi zawierać przynajmniej jedną literę.',
        'mixed' => ':attribute musi zawierać przynajmniej jedną dużą literę i jedną małą literę.',
        'numbers' => ':attribute musi zawierać przynajmniej jedną liczbę.',
        'symbols' => ':attribute musi zawierać przynajmniej jeden symbol.',
        'uncompromised' => ':attribute pojawia się w wycieku danych. Proszę wybrać inne :attribute.',
    ],
    'present' => ':attribute musi być obecny.',
    'prohibited' => ':attribute jest zabroniony.',
    'prohibited_if' => ':attribute jest zabroniony, gdy :other ma wartość :value.',
    'prohibited_unless' => ':attribute jest zabroniony, chyba że :other znajduje się w :values.',
    'prohibits' => ':attribute zabrania obecności :other.',
    'regex' => 'Format :attribute jest nieprawidłowy.',
    'required' => 'To pole jest wymagane.',
    'required_array_keys' => ':attribute musi zawierać wpisy dla: :values.',
    'required_if' => ':attribute jest wymagane, gdy :other ma wartość :value.',
    'required_if_accepted' => ':attribute jest wymagane, gdy :other jest zaakceptowane.',
    'required_unless' => ':attribute jest wymagane, chyba że :other znajduje się w :values.',
    'required_with' => ':attribute jest wymagane, gdy :values jest obecny.',
    'required_with_all' => ':attribute jest wymagane, gdy :values są obecne.',
    'required_without' => ':attribute jest wymagane, gdy :values nie jest obecny.',
    'required_without_all' => ':attribute jest wymagane, gdy żadne z :values nie są obecne.',
    'same' => ':attribute i :other muszą być takie same.',
    'size' => [
        'array' => ':attribute musi zawierać :size elementów.',
        'file' => ':attribute musi mieć :size kilobajtów.',
        'numeric' => ':attribute musi mieć rozmiar :size.',
        'string' => ':attribute musi mieć :size znaków.',
    ],
    'starts_with' => ':attribute musi zaczynać się jednym z następujących: :values.',
    'string' => ':attribute musi być ciągiem znaków.',
    'timezone' => ':attribute musi być poprawną strefą czasową.',
    'unique' => ':attribute już istnieje.',
    'uploaded' => 'Nie udało się przesłać :attribute.',
    'url' => 'Format :attribute jest nieprawidłowy.',
    'uuid' => ':attribute musi być poprawnym identyfikatorem UUID.',

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

    'attributes' => [],

];
