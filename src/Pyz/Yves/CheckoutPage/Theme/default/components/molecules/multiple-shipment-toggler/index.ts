import register from 'ShopUi/app/registry';
export default register(
    'multiple-shipment-toggler',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "multiple-shipment-toggler" */
            './multiple-shipment-toggler'
        ),
);
