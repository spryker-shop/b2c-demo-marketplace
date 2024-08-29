import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { TableModule } from '@spryker/table';
import { HeadlineModule } from '@spryker/headline';

import { FileUploadListComponent } from './file-upload-list.component';

@NgModule({
    imports: [CommonModule, TableModule, HeadlineModule],
    declarations: [FileUploadListComponent],
    exports: [FileUploadListComponent],
})
export class FileUploadListModule {}
