export default {
    displayName: 'merchant-portal',
    preset: 'jest-preset-angular',
    setupFilesAfterEnv: ['<rootDir>/frontend/merchant-portal/test-setup.ts'],
    roots: ['<rootDir>/src/Pyz'],
    testMatch: ['**/+(*.)+(spec|test).+(ts|js)?(x)'],
    moduleFileExtensions: ['ts', 'js', 'html'],
    passWithNoTests: true,
    globals: {
        'ts-jest': {
            tsconfig: '<rootDir>/frontend/merchant-portal/tsconfig.spec.json',
            stringifyContentPathRegex: '\\.(html|svg)$',
        },
    },
};
