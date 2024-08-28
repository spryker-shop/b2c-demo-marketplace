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
    selector: 'mp-file-upload-table',
    templateUrl: './file-upload-table.component.html',
    styleUrls: ['./file-upload-table.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
})
export class FileUploadTableComponent implements OnInit {
    @Input() @ToJson() config: TableConfig;
    @Input() @ToJson() action: TableRowActionBase;
    @Input() tableId?: string;

    @HostBinding('class.mp-file-upload-table') mainClass = true;
    @HostBinding('class.mp-file-upload-table--inner')
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
