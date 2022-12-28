import { CustomWebpackBrowserSchema, TargetOptions } from '@angular-builders/custom-webpack';
import * as webpack from 'webpack';
import * as path from 'path';
import { getMPEntryPointsMap } from './entry-points';

export default async (
    config: webpack.Configuration,
    options: CustomWebpackBrowserSchema,
    targetOptions: TargetOptions,
): Promise<webpack.Configuration> => {
    console.log('Resolving entry points...');

    const entryPointsMap = await getMPEntryPointsMap();

    console.log(`Found ${Object.keys(entryPointsMap).length} entry point(s)!`);

    config.entry = {
        ...(config.entry as any),
        ...entryPointsMap,
    };

    config.resolve.alias = {
        '~@spryker': path.resolve(__dirname, '../../node_modules/@spryker'),
        '~@angular': path.resolve(__dirname, '../../node_modules/@angular'),
    };

    return config;
};
