import { NgModule } from '@angular/core';
import { WebComponentsModule } from '@spryker/web-components';
import {ImportUploadTableComponent} from "./import-upload-table/import-upload-table.component";
import {ImportUploadTableModule} from "./import-upload-table/import-upload-table.module";

@NgModule({
    imports: [
        WebComponentsModule.withComponents([ImportUploadTableComponent]),
        ImportUploadTableModule,
    ],
})
export class ComponentsModule {}
