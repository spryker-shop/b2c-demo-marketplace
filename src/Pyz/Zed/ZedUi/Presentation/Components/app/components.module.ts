import { NgModule } from '@angular/core';
import { ComponentsModule as CoreComponentsModule } from '@mp/zed-ui';
import { ButtonLinkComponent, ButtonLinkModule } from '@spryker/button';
import { WebComponentsModule } from '@spryker/web-components';
import { MediaFileUploadComponent } from './media-file-upload/media-file-upload.component';
import { MediaFileUploadModule } from './media-file-upload/media-file-upload.module';

@NgModule({
    imports: [
        CoreComponentsModule,
        WebComponentsModule.withComponents([
            ButtonLinkComponent,
            MediaFileUploadComponent,
        ]),
        ButtonLinkModule,
        MediaFileUploadModule,
    ],
})
export class ComponentsModule {}
