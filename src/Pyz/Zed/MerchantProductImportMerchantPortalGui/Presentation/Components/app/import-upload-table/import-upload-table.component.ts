import {
    booleanAttribute,
    ChangeDetectionStrategy,
    Component,
    HostBinding,
    Input,
    OnInit,
    ViewEncapsulation,
} from '@angular/core';
import { TableConfig } from '@spryker/table';
import { TableRowActionBase } from '@spryker/table.feature.row-actions';
import { ToJson } from '@spryker/utils';

@Component({
    selector: 'mp-import-upload-table',
    templateUrl: './import-upload-table.component.html',
    styleUrls: ['./import-upload-table.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
})
export class ImportUploadTableComponent implements OnInit {
    @Input() @ToJson() config: TableConfig;
    @Input() @ToJson() action: TableRowActionBase;
    @Input() tableId?: string;

    @HostBinding('class.mp-import-upload-table') mainClass = true;
    @HostBinding('class.mp-import-upload-table--inner')
    @Input({ transform: booleanAttribute })
    inner = true;

    protected _config: TableConfig;

    ngOnInit(): void {
        if (this.config?.rowActions && this.action) {
            this.config.rowActions.click = this.action.id;
            this.config.rowActions.actions.push(this.action);
            this.config = { ...this.config };
        }
    }
}
