<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database/factories',
        __DIR__ . '/database/seeders',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => true,
        'cast_spaces' => ['space' => 'single'],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one'
            ]
        ],
        'compact_nullable_typehint' => true,
        'concat_space' => ['spacing' => 'none'],
        'constant_case' => ['case' => 'lower'],
        'declare_strict_types' => true,
        'explicit_string_variable' => true,
        'function_declaration' => ['closure_function_spacing' => 'one'],
        'function_typehint_space' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'indentation_type' => true,
        'lowercase_cast' => true,
        'linebreak_after_opening_tag' => false,
        'method_chaining_indentation' => true,
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'native_function_type_declaration_casing' => true,
        'new_with_braces' => true,
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => true],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_extra_blank_lines' => ['tokens' => ['extra']],
        'no_spaces_after_function_name' => true,
        'no_superfluous_phpdoc_tags' => false,
        'no_useless_else' => true,
        'no_whitespace_before_comma_in_array' => ['after_heredoc' => false],
        'not_operator_with_successor_space' => true,
        'object_operator_without_whitespace' => true,
        'ordered_traits' => true,
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this'
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'phpdoc_order' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_trim' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'single_blank_line_before_namespace' => true,
        'strict_comparison' => true,
        'ternary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);
