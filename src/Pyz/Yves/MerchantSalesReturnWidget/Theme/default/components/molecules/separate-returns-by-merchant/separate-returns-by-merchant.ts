import SeparateReturnsByMerchantCore from 'MerchantSalesReturnWidget/components/molecules/separate-returns-by-merchant/separate-returns-by-merchant';

export default class SeparateReturnsByMerchant extends SeparateReturnsByMerchantCore {
    protected selectAllCheckboxes: HTMLInputElement[];
    protected checkedSelectAllItems: HTMLInputElement[] = [];
    protected returnReasonDropdowns: HTMLSelectElement[];

    protected init(): void {
        this.selectAllCheckboxes = <HTMLInputElement[]>(
            Array.from(document.getElementsByClassName(this.selectAllCheckboxesClassName))
        );
        if (this.returnReasonDropdownClassName) {
            this.returnReasonDropdowns = <HTMLSelectElement[]>(
                Array.from(document.getElementsByClassName(this.returnReasonDropdownClassName))
            );
        }

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
                target.checked ? this.onAddSelectAllCheckedItems(target) : this.onRemoveSelectAllCheckedItems();
            });
        });
    }

    protected onAddSelectAllCheckedItems(item: HTMLInputElement): void {
        this.checkedSelectAllItems.push(item);
        this.disableSelectAllItem(item);
    }

    protected onRemoveSelectAllCheckedItems(): void {
        this.checkedSelectAllItems = this.checkedSelectAllItems.filter((item) => item.checked);

        if (this.checkedSelectAllItems.length) {
            return;
        }

        this.enableSelectAllItems();
    }

    protected disableItem(target: HTMLInputElement): void {
        this.disableItems(
            target,
            this.checkboxes,
            this.checkboxComponentClassname,
            this.checkboxDisabledComponentClassname,
        );
        this.disableSelectAllItem(target);
    }

    protected disableSelectAllItem(target: HTMLInputElement): void {
        this.disableItems(
            target,
            this.selectAllCheckboxes,
            this.selectAllCheckboxesComponentClassName,
            this.selectAllCheckboxesComponentDisabledClassName,
        );
    }

    protected enableAllItems(): void {
        this.enableItems(this.checkboxes, this.checkboxComponentClassname, this.checkboxDisabledComponentClassname);
        this.enableSelectAllItems();
    }

    protected enableSelectAllItems(): void {
        this.enableItems(
            this.selectAllCheckboxes,
            this.selectAllCheckboxesComponentClassName,
            this.selectAllCheckboxesComponentDisabledClassName,
        );
    }

    protected disableItems(
        target: HTMLInputElement,
        checkboxes: HTMLInputElement[],
        parentClassName: string,
        className: string,
    ): void {
        const currentMerchantReference = target.getAttribute(this.merchantReference);

        checkboxes.forEach((checkbox) => {
            if (checkbox.getAttribute(this.merchantReference) === currentMerchantReference) {
                return;
            }

            checkbox.disabled = true;
            checkbox.closest(`.${parentClassName}`).classList.add(className);
        });

        this.returnReasonDropdowns.forEach((dropdown) => {
            if (dropdown.getAttribute(this.merchantReference) === currentMerchantReference) {
                return;
            }

            dropdown.disabled = true;
        });
    }

    protected enableItems(checkboxes: HTMLInputElement[], parentClassName: string, className: string): void {
        checkboxes.forEach((checkbox) => {
            if (!checkbox.hasAttribute(this.isReturnable)) {
                return;
            }

            checkbox.disabled = false;
            checkbox.closest(`.${parentClassName}`).classList.remove(className);
        });

        this.returnReasonDropdowns.forEach((dropdown) => {
            if (!dropdown.hasAttribute(this.isReturnable)) {
                return;
            }

            dropdown.disabled = false;
        });
    }

    protected get selectAllCheckboxesClassName(): string {
        return this.getAttribute('select-all-checkboxes-classname');
    }

    protected get selectAllCheckboxesComponentClassName(): string {
        return this.getAttribute('select-all-checkboxes-component-classname');
    }

    protected get selectAllCheckboxesComponentDisabledClassName(): string {
        return this.getAttribute('select-all-checkboxes-component-disabled-classname');
    }

    protected get returnReasonDropdownClassName(): string {
        return this.getAttribute('return-reason-dropdown-classname');
    }
}
