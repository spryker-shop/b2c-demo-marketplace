import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { TableConfig } from '@spryker/table';

@Component({
    selector: 'mp-file-upload-list',
    templateUrl: './file-upload-list.component.html',
    styleUrls: ['./file-upload-list.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
})
export class FileUploadListComponent {
    @Input() tableConfig: TableConfig;
    @Input() tableId?: string;
}

