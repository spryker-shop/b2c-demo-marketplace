import { NgModule } from '@angular/core';
import { WebComponentsModule } from '@spryker/web-components';
import {FileUploadTableComponent} from "./file-upload-table/file-upload-table.component";
import {FileUploadTableModule} from "./file-upload-table/file-upload-table.module";

@NgModule({
    imports: [
        WebComponentsModule.withComponents([FileUploadTableComponent]),
        FileUploadTableModule,
    ],
})
export class ComponentsModule {}
