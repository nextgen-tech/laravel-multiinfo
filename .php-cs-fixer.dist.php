<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,

    // Import rules
    'fully_qualified_strict_types' => true,
    'global_namespace_import'      => [
        'import_constants' => true,
        'import_functions' => true,
        'import_classes'   => true,
    ],
    'group_import'            => false,
    'no_leading_import_slash' => true,
    'no_unused_imports'       => true,
    'ordered_imports'         => [
        'sort_algorithm' => 'alpha',
    ],
    'single_import_per_statement' => true,
    'single_line_after_imports'   => true,

    // Operator rules
    'binary_operator_spaces' => [
        'default'   => 'align_single_space',
        'operators' => [
            '=>' => 'align_single_space_minimal',
        ],
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
    'logical_operators'                  => true,
    'new_with_braces'                    => true,
    'not_operator_with_space'            => false,
    'not_operator_with_successor_space'  => false,
    'object_operator_without_whitespace' => true,
    'operator_linebreak'                 => [
        'only_booleans' => false,
        'position'      => 'beginning',
    ],
    'ternary_operator_spaces'    => true,
    'ternary_to_elvis_operator'  => true,
    'ternary_to_null_coalescing' => true,
    'unary_operator_spaces'      => true,

    // PHP Tag rules
    'blank_line_after_opening_tag' => true,
    'echo_tag_syntax'              => [
        'format'                         => 'long',
        'long_function'                  => 'echo',
        'shorten_simple_statements_only' => true,
    ],
    'full_opening_tag'            => true,
    'linebreak_after_opening_tag' => true,
    'no_closing_tag'              => true,

    // PHPDoc rules
    'align_multiline_comment' => [
        'comment_type' => 'phpdocs_only',
    ],
    'general_phpdoc_annotation_remove' => [
        'annotations' => [],
    ],
    'general_phpdoc_tag_rename' => [
        'fix_annotation' => true,
        'fix_inline'     => true,
        'replacements'   => [],
        'case_sensitive' => false,
    ],
    'no_blank_lines_after_phpdoc'         => true,
    'no_empty_phpdoc'                     => true,
    'phpdoc_add_missing_param_annotation' => [
        'only_untyped' => true,
    ],
    'phpdoc_align' => [
        'tags'  => ['param', 'property', 'property-read', 'property-write', 'return', 'throws', 'type', 'var', 'method'],
        'align' => 'vertical',
    ],
    'phpdoc_annotation_without_dot' => false,
    'phpdoc_indent'                 => true,
    'phpdoc_line_span'              => [
        'const'    => 'single',
        'property' => 'multi',
        'method'   => 'multi',
    ],
    'phpdoc_order_by_value' => [
        'annotations' => ['author', 'covers', 'coversNothing', 'dataProvider', 'depends', 'group', 'internal', 'method', 'property', 'property-read', 'property-write', 'requires', 'throws', 'uses'],
    ],
    'phpdoc_order'                 => true,
    'phpdoc_return_self_reference' => true,
    'phpdoc_scalar'                => [
        'types' => ['boolean', 'callback', 'double', 'integer', 'real', 'str'],
    ],
    'phpdoc_separation'              => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary'                 => true,
    'phpdoc_tag_casing'              => [
        'tags' => ['inheritDoc'],
    ],
    'phpdoc_tag_type' => [
        'tags' => ['api' => 'annotation', 'author' => 'annotation', 'copyright' => 'annotation', 'deprecated' => 'annotation', 'example' => 'annotation', 'global' => 'annotation', 'inheritDoc' => 'annotation', 'internal' => 'annotation', 'license' => 'annotation', 'method' => 'annotation', 'package' => 'annotation', 'param' => 'annotation', 'property' => 'annotation', 'return' => 'annotation', 'see' => 'annotation', 'since' => 'annotation', 'throws' => 'annotation', 'todo' => 'annotation', 'uses' => 'annotation', 'var' => 'annotation', 'version' => 'annotation'],
    ],
    'phpdoc_to_comment'                             => true,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_trim'                                   => true,
    'phpdoc_types'                                  => [
        'groups' => ['simple', 'alias', 'meta'],
    ],
    'phpdoc_types_order' => [
        'sort_algorithm'  => 'alpha',
        'null_adjustment' => 'always_last',
    ],
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_var_without_name'             => true,

    // Return Notation rules
    'no_useless_return'      => true,
    'return_assignment'      => true,
    'simplified_null_return' => false,

    // Semicolon rules
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'no_empty_statement'                         => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'semicolon_after_instruction'                => true,
    'space_after_semicolon'                      => [
        'remove_in_empty_for_expressions' => false,
    ],

    // Strict rules
    'declare_strict_types' => true,
    'strict_comparison'    => true,
    'strict_param'         => true,

    // String Notation rules
    'escape_implicit_backslashes' => [
        'single_quoted'  => false,
        'double_quoted'  => true,
        'heredoc_syntax' => true,
    ],
    'explicit_string_variable'          => true,
    'heredoc_to_nowdoc'                 => true,
    'no_binary_string'                  => true,
    'no_trailing_whitespace_in_string'  => true,
    'simple_to_complex_string_variable' => true,
    'single_quote'                      => [
        'strings_containing_single_quote_chars' => true,
    ],
    'string_line_ending' => true,

    // Whitespace rules
    'array_indentation'           => true,
    'blank_line_before_statement' => [
        'statements' => ['break', 'case', 'continue', 'declare', 'default', 'do', 'exit', 'for', 'foreach', 'goto', 'if', 'include', 'include_once', 'require', 'require_once', 'return', 'switch', 'throw', 'try', 'while', 'yield', 'yield_from'],
    ],
    'compact_nullable_typehint' => true,
    'heredoc_indentation'       => [
        'indentation' => 'start_plus_one',
    ],
    'indentation_type'            => true,
    'line_ending'                 => true,
    'method_chaining_indentation' => true,
    'no_extra_blank_lines'        => [
        'tokens' => ['break', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'return', 'square_brace_block', 'switch', 'throw', 'use', 'use_trait'],
    ],
    'no_spaces_around_offset' => [
        'positions' => ['inside', 'outside'],
    ],
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_whitespace'       => true,
    'no_whitespace_in_blank_line'  => true,
    'single_blank_line_at_eof'     => true,
])
    ->setFinder($finder);
