import { NgModule } from '@angular/core';
import { WebComponentsModule } from '@spryker/web-components';
import { ButtonLinkComponent, ButtonLinkModule } from '@spryker/button';
import {FileUploadListComponent} from "./file-upload-list/file-upload-list.component";
import {FileUploadListModule} from "./file-upload-list/file-upload-list.module";
import {FileUploaderComponent} from "./file-uploader/file-uploader.component";
import {FileUploaderModule} from "./file-uploader/file-uploader.module";

@NgModule({
    imports: [
        WebComponentsModule.withComponents([
            FileUploadListComponent,
            FileUploaderComponent,
            ButtonLinkComponent,
        ]),
        FileUploadListModule,
        ButtonLinkModule,
        FileUploaderModule,
    ],
})
export class ComponentsModule {}
