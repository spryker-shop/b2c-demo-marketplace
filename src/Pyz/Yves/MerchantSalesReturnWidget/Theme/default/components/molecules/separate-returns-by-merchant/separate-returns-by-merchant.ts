import SeparateReturnsByMerchantCore from 'MerchantSalesReturnWidget/components/molecules/separate-returns-by-merchant/separate-returns-by-merchant';

export default class SeparateReturnsByMerchant extends SeparateReturnsByMerchantCore {
    protected selectAllCheckboxes: HTMLInputElement[];
    protected checkedSelectAllItems: HTMLInputElement[] = [];

    protected init(): void {
        this.selectAllCheckboxes = <HTMLInputElement[]>Array.from(document.getElementsByClassName(this.selectAllCheckboxClass));

        super.init();
    }

    protected mapEvents(): void {
        this.mapSelectAllCheckboxesChangeEvent();

        super.mapEvents();
    }

    protected mapSelectAllCheckboxesChangeEvent(): void {
        this.selectAllCheckboxes.map((checkbox) => {
            checkbox.addEventListener('change', (event) => {
                const target = <HTMLInputElement>event.target;
                target.checked ? this.onAddSelectAllCheckedItem(target) : this.onRemoveSelectAllCheckedItems();
            });
        });
    }

    protected onAddSelectAllCheckedItem(item: HTMLInputElement): void {
        this.checkedSelectAllItems.push(item);
        this.disableSelectAllItem(item);
    }

    protected onRemoveSelectAllCheckedItems(): void {
        this.checkedSelectAllItems = this.checkedSelectAllItems.filter((item) => {
            return item.checked;
        });

        if (this.checkedSelectAllItems.length) {
            return;
        }

        this.enableSelectAllItems();
    }

    protected disableItem(target: HTMLInputElement): void {
        const currentMerchantReference = target.getAttribute(this.merchantReference);

        const checkboxesToDisable = this.checkboxes.filter((checkbox) => {
            return checkbox.getAttribute(this.merchantReference) !== currentMerchantReference;
        });

        checkboxesToDisable.map((checkbox) => {
            checkbox.disabled = true;
            checkbox
                .closest(`.${this.checkboxComponentClassname}`)
                .classList.add(this.checkboxDisabledComponentClassname);
        });

        this.disableSelectAllItem(target);
    }

    protected disableSelectAllItem(target: HTMLInputElement): void {
        const currentMerchantReference = target.getAttribute(this.merchantReference);

        const checkboxesToDisable = this.selectAllCheckboxes.filter((checkbox) => {
            return checkbox.getAttribute(this.merchantReference) !== currentMerchantReference;
        });

        checkboxesToDisable.map((checkbox) => {
            checkbox.disabled = true;
            checkbox
                .closest(`.${this.selectAllCheckboxComponentClass}`)
                .classList.add(this.checkboxComponentDisabledClass);
        });
    }

    protected enableAllItems(): void {
        this.checkboxes.map((checkbox) => {
            if (!checkbox.hasAttribute(this.isReturnable)) {
                return;
            }

            checkbox.disabled = false;
            checkbox
                .closest(`.${this.checkboxComponentClassname}`)
                .classList.remove(this.checkboxDisabledComponentClassname);
        });

        this.enableSelectAllItems();
    }

    protected enableSelectAllItems(): void {
        this.selectAllCheckboxes.map((checkbox) => {
            if (!checkbox.hasAttribute(this.isReturnable)) {
                return;
            }

            checkbox.disabled = false;
            checkbox
                .closest(`.${this.selectAllCheckboxComponentClass}`)
                .classList.remove(this.checkboxComponentDisabledClass);
        });
    }

    protected get checkboxDisabledComponentClass(): string {
        return this.getAttribute('checkbox-component-disabled-classname');
    }

    protected get selectAllCheckboxClass(): string {
        return this.getAttribute('select-all-checkbox-classname');
    }

    protected get selectAllCheckboxComponentClass(): string {
        return this.getAttribute('select-all-checkbox-component-classname');
    }

    protected get checkboxComponentDisabledClass(): string {
        return this.getAttribute('select-all-checkbox-component-disabled-classname');
    }
}
