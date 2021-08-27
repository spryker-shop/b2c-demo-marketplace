import register from 'ShopUi/app/registry';
export default register(
    'separate-returns-by-merchant',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "separate-returns-by-merchant" */
            './separate-returns-by-merchant'
        ),
);
