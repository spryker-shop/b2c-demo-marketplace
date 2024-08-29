import { NgModule } from '@angular/core';
import { NzProgressModule } from 'ng-zorro-antd/progress';
import { ProgressComponent } from './progress.component';

@NgModule({
    imports: [NzProgressModule],
    declarations: [ProgressComponent],
    exports: [ProgressComponent],
})
export class ProgressModule {}
