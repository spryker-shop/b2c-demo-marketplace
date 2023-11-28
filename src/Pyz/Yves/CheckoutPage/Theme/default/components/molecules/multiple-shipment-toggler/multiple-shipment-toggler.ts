import MultipleShipmentTogglerCore from 'CheckoutPage/components/molecules/multiple-shipment-toggler/multiple-shipment-toggler';
import CustomSelect from 'ShopUiProject/components/molecules/custom-select/custom-select';
import { mount } from 'ShopUi/app';

export default class MultipleShipmentToggler extends MultipleShipmentTogglerCore {
    protected async updateShipmentTypeSelect(): Promise<void> {
        super.updateShipmentTypeSelect();

        const shipmentTypeCustomSelect: CustomSelect = <HTMLSelectElement>(
            document.getElementsByClassName(this.customSelectClassName)[0]
        );
        await mount();
        shipmentTypeCustomSelect.initSelect({
            templateResult: (data: { element?: HTMLOptionElement; text: string }): string | void => {
                if (data.element?.classList.contains(this.toggleClassName)) {
                    return;
                }

                return data.text;
            },
        });
    }

    protected get customSelectClassName(): string {
        return this.getAttribute('custom-select-class-name');
    }
}
