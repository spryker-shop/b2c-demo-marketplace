import typescriptEslint from '@typescript-eslint/eslint-plugin';
import typescriptParser from '@typescript-eslint/parser';
import deprecationPlugin from 'eslint-plugin-deprecation';
import angularEslint from 'angular-eslint';
import { createRequire } from 'module';

const require = createRequire(import.meta.url);
const sprykerConfig = require('@spryker/frontend-config.eslint/.eslintrc.js');

export default [
    {
        ignores: [
            'docker/',
            'public/*/assets/',
            '**/dist/',
            '**/node_modules/',
            'vendor/',
            '**/.angular/',
        ],
    },
    // Configuration for regular JS files
    {
        files: ['**/*.js'],
        languageOptions: {
            ecmaVersion: 2020,
            sourceType: 'module',
            globals: {
                ...sprykerConfig.globals,
            },
        },
        rules: {
            ...sprykerConfig.rules,
            'accessor-pairs': [
                'error',
                {
                    setWithoutGet: true,
                    enforceForClassMembers: false,
                },
            ],
        },
    },
    // Configuration for Yves TypeScript files
    {
        files: ['src/{Pyz,SprykerShop,SprykerFeature}/*/src/{Pyz,SprykerShop,SprykerFeature}/Yves/**/*.ts'],
        languageOptions: {
            parser: typescriptParser,
            parserOptions: {
                ecmaVersion: 2020,
                sourceType: 'module',
                project: ['./tsconfig.yves.json'],
            },
            globals: {
                ...sprykerConfig.globals,
            },
        },
        plugins: {
            '@typescript-eslint': typescriptEslint,
            deprecation: deprecationPlugin,
        },
        rules: {
            ...sprykerConfig.rules,
            'no-undef': 'off',
            'no-unused-vars': 'off',
            'accessor-pairs': [
                'error',
                {
                    setWithoutGet: true,
                    enforceForClassMembers: false,
                },
            ],
            '@typescript-eslint/no-unused-vars': [
                'error',
                {
                    args: 'none',
                    ignoreRestSiblings: true,
                },
            ],
            '@typescript-eslint/no-empty-function': [
                'error',
                {
                    allow: ['methods'],
                },
            ],
            '@typescript-eslint/no-magic-numbers': [
                'error',
                {
                    ignore: [-1, 0, 1],
                    ignoreDefaultValues: true,
                    ignoreClassFieldInitialValues: true,
                    ignoreArrayIndexes: true,
                    ignoreEnums: true,
                    ignoreReadonlyClassProperties: true,
                },
            ],
        },
    },
    // Configuration for Merchant Portal TypeScript files
    {
        files: ['src/Pyz/Zed/*/Presentation/Components/**/*.ts'],
        languageOptions: {
            parser: typescriptParser,
            parserOptions: {
                ecmaVersion: 2020,
                sourceType: 'module',
                project: ['./tsconfig.mp.json'],
            },
        },
        plugins: {
            '@typescript-eslint': typescriptEslint,
            '@angular-eslint': angularEslint.tsPlugin,
        },
        processor: angularEslint.processInlineTemplates,
        rules: {
            ...sprykerConfig.rules,
            'no-undef': 'off',
            'no-unused-vars': 'off',
            'no-console': [
                'warn',
                {
                    allow: ['warn', 'error'],
                },
            ],
            'no-empty': 'error',
            'no-use-before-define': 'off',
            'max-classes-per-file': 'off',
            'max-lines': 'off',
            'handle-callback-err': 'off',
            '@typescript-eslint/array-type': 'off',
            '@typescript-eslint/no-restricted-imports': ['error', 'rxjs/Rx'],
            '@typescript-eslint/no-unused-vars': 'error',
            '@typescript-eslint/no-inferrable-types': [
                'error',
                {
                    ignoreParameters: true,
                },
            ],
            '@typescript-eslint/no-non-null-assertion': 'error',
            '@typescript-eslint/no-var-requires': 'off',
            '@typescript-eslint/no-explicit-any': 'error',
            '@typescript-eslint/member-ordering': [
                'error',
                {
                    default: ['instance-field', 'instance-method', 'static-field', 'static-method'],
                },
            ],
            '@angular-eslint/directive-selector': [
                'error',
                {
                    type: 'attribute',
                    prefix: 'mp',
                    style: 'camelCase',
                },
            ],
            '@angular-eslint/component-selector': [
                'error',
                {
                    type: 'element',
                    prefix: 'mp',
                    style: 'kebab-case',
                },
            ],
            '@angular-eslint/no-host-metadata-property': 'off',
        },
    },
    // Configuration for Merchant Portal HTML templates
    {
        files: ['src/Pyz/Zed/*/Presentation/Components/**/*.html'],
        languageOptions: {
            parser: angularEslint.templateParser,
        },
        plugins: {
            '@angular-eslint': angularEslint.templatePlugin,
        },
        rules: {
            '@typescript-eslint/ban-types': 'off',
            '@typescript-eslint/ban-ts-comment': 'off',
            '@typescript-eslint/no-empty-interface': 'off',
            '@typescript-eslint/no-explicit-any': 'off',
            '@typescript-eslint/no-unused-vars': 'off',
            '@angular-eslint/no-host-metadata-property': 'off',
            '@angular-eslint/directive-class-suffix': 'off',
            'no-prototype-builtins': 'off',
        },
    },
];
