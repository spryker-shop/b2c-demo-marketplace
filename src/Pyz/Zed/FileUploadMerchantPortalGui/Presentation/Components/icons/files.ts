import { NgModule } from '@angular/core';
import { provideIcons } from '@spryker/icon';

const svg = `
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g fill="currentColor" fill-rule="nonzero">
            <path d="M16.065 4.566C15.157 1.522 12.18-.39 9.067.068 5.953.527 3.642 3.22 3.634 6.4v.091c-2.284.47-3.845 2.61-3.61 4.953.233 2.343 2.186 4.125 4.517 4.122h2.717c.501 0 .907-.41.907-.916a.912.912 0 0 0-.907-.917H4.536c-1.503.012-2.73-1.21-2.743-2.728-.012-1.519 1.197-2.76 2.7-2.772h.111a.97.97 0 0 0 .703-.32.923.923 0 0 0 .207-.75 4.61 4.61 0 0 1 1.54-4.43 4.5 4.5 0 0 1 4.59-.736 4.577 4.577 0 0 1 2.822 3.731c.073.5.534.846 1.03.773h.06c.254-.062.514-.095.774-.101 2.004 0 3.629 1.641 3.629 3.666 0 2.026-1.625 3.667-3.629 3.667h-1.814a.912.912 0 0 0-.907.917c0 .506.406.916.907.916h1.814c3.006-.075 5.383-2.598 5.309-5.636-.075-3.037-2.572-5.439-5.579-5.364h.005z"/>
            <path d="M10.625 10a.912.912 0 0 0-.907.917v7.87L8.55 17.6a.901.901 0 0 0-.877-.237.912.912 0 0 0-.642.649.924.924 0 0 0 .235.886l2.722 2.75a.903.903 0 0 0 1.283 0l2.722-2.75a.924.924 0 0 0 0-1.298.901.901 0 0 0-1.284 0l-1.177 1.185v-7.87a.912.912 0 0 0-.907-.916z"/>
        </g>
    </svg>
`;

@NgModule({
    providers: [provideIcons([IconFilesModule])],
})
export class IconFilesModule {
    static icon = 'files';
    static svg = svg;
}
