import {
    ChangeDetectionStrategy,
    Component,
    Input,
    numberAttribute,
    OnChanges,
    SimpleChanges,
    ViewEncapsulation,
} from '@angular/core';
import { NzProgressStatusType } from 'ng-zorro-antd/progress';

type ProgressStatus = NzProgressStatusType;

@Component({
    selector: 'mp-progress',
    templateUrl: './progress.component.html',
    styleUrl: './progress.component.less',
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: { class: 'mp-progress' },
})
export class ProgressComponent implements OnChanges {
    @Input({ transform: numberAttribute }) percent: number;
    @Input() error: string;

    protected status: ProgressStatus = null;

    ngOnChanges(changes: SimpleChanges): void {
        if ('error' in changes && changes.error.currentValue) {
            this.status = 'exception';
        }
    }
}
