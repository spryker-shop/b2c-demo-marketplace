import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { TableModule } from '@spryker/table';

import { FileUploadTableComponent } from './file-upload-table.component';

@NgModule({
    imports: [CommonModule, TableModule],
    declarations: [FileUploadTableComponent],
    exports: [FileUploadTableComponent],
})
export class FileUploadTableModule {}
