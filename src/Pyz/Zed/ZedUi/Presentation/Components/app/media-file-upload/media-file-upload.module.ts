import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ButtonLinkModule, ButtonModule } from '@spryker/button';
import { IconModule } from '@spryker/icon';
import { ModalModule } from '@spryker/modal';
import { IconFilesModule } from '../../icons';
import { ProgressModule } from '../progress/progress.module';
import { MediaFileUploadComponent } from './media-file-upload.component';

@NgModule({
    imports: [IconModule, IconFilesModule, CommonModule, ModalModule, ButtonModule, ButtonLinkModule, ProgressModule],
    declarations: [MediaFileUploadComponent],
    exports: [MediaFileUploadComponent],
})
export class MediaFileUploadModule {}
