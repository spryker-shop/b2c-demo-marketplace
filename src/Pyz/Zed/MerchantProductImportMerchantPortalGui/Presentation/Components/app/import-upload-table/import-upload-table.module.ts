import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { TableModule } from '@spryker/table';

import { ImportUploadTableComponent } from './import-upload-table.component';

@NgModule({
    imports: [CommonModule, TableModule],
    declarations: [ImportUploadTableComponent],
    exports: [ImportUploadTableComponent],
})
export class ImportUploadTableModule {}
