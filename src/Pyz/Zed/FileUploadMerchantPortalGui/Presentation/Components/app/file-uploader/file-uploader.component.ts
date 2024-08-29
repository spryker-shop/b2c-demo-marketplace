import { Clipboard } from '@angular/cdk/clipboard';
import {
    booleanAttribute,
    ChangeDetectionStrategy,
    Component,
    inject,
    Input,
    numberAttribute,
    OnDestroy,
    OnInit,
    ViewChild,
    ViewEncapsulation,
} from '@angular/core';
import { ModalComponent } from '@spryker/modal';
import { ToJson } from '@spryker/utils';
import { Observable, Subject, takeUntil } from 'rxjs';
import { FileUploadService, ProgressFile } from './file-upload.service';

interface Translations {
    mb: string;
    copy: string;
    errorType: string;
}

export interface FileData {
    types: string;
    size: number;
    errorSize: string;
}

@Component({
    selector: 'mp-file-uploader',
    templateUrl: './file-uploader.component.html',
    styleUrls: ['./file-uploader.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
})
export class FileUploaderComponent implements OnDestroy, OnInit {
    @Input() importUrl = '/file-upload-merchant-portal-gui/upload/get-upload-url';
    @Input() hookUrl = '/file-upload-merchant-portal-gui/upload/save-upload-data';
    @Input() downloadUrl: string;
    @Input({ transform: booleanAttribute }) showCdn = true;
    @Input({ transform: booleanAttribute }) multiple = null;
    @Input() @ToJson() translations: Translations;
    @Input() buttonSize: string;
    @Input({ transform: numberAttribute }) maxCallAmount = 20;

    protected types: string;

    protected _data: FileData[];
    get data(): FileData[] {
        return this._data;
    }
    @Input({ transform: (value: string) => JSON.parse(value) }) set data(value: FileData[]) {
        this._data = value;
        this.types = value?.reduce((acc, data) => `${acc},${data.types}`, '');
        this.uploadingFiles$ = this.fileUpload.getQueue(this.types);
    }

    @ViewChild('modal', { static: true }) modal!: ModalComponent;

    protected fileUpload = inject(FileUploadService);
    protected clipboard = inject(Clipboard);

    protected destroy$ = new Subject<void>();
    protected uploadingFiles$: Observable<Observable<ProgressFile>[]>;

    protected files: File[] = [];
    protected validFiles: File[] = [];
    protected showProgress = false;

    ngOnInit(): void {
        this.fileUpload.getProgress().pipe(takeUntil(this.destroy$)).subscribe();
    }

    ngOnDestroy(): void {
        this.destroy$.next();
    }

    protected copyToClipboard(url: string): void {
        this.clipboard.copy(url);
    }

    protected onModalVisibleChange(visible: boolean): void {
        if (visible) {
            this.clear();
            this.showProgress = false;
        }
    }

    protected onImport(): void {
        this.fileUpload.updateQueue(this.validFiles);
        this.clear();
    }

    protected onDragOver(event: DragEvent): void {
        event.stopPropagation();
        event.preventDefault();
    }

    protected onSelect(event: Event, _files: File[]): void {
        event.preventDefault();

        const files = this.multiple ? Array.from(_files).slice(0, this.maxCallAmount) : [_files[0]];

        for (const file of files) {
            const fileCheck = this.data.find((data) => data.types.includes(file.type));
            const error =
                !fileCheck || !file.type
                    ? this.translations.errorType
                    : file.size >= Number(fileCheck.size) * 1024 * 1024
                      ? fileCheck.errorSize
                      : null;

            if (error) {
                file.error = error;
                continue;
            }

            file.id = `${file.name}-${Date.now()}`;
            file.importUrl = this.importUrl;
            file.hookUrl = this.hookUrl;
        }

        this.files = this.multiple ? [...this.files, ...files].slice(-this.maxCallAmount) : files;
        this.validFiles = this.files.filter((file) => !file.error);
        event.target['value'] = '';
    }

    protected clear(): void {
        this.files = [];
        this.validFiles = [];
    }

    protected fileSize(file: File): string {
        const mbSize = Math.ceil((file.size / 1024 / 1024) * 100) / 100;
        const maxSize = this.data.find((data) => data.types.includes(file.type))?.size;
        const textSize = maxSize ? `${mbSize}/${maxSize}` : mbSize;

        return `${textSize} ${this.translations.mb}`;
    }

    protected onShowProgress(): void {
        this.showProgress = !this.showProgress;
    }
}
