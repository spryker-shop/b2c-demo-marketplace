import { HttpClient, HttpEventType } from '@angular/common/http';
import { inject, Injectable, Injector } from '@angular/core';
import { AjaxActionResponse, AjaxActionService } from '@spryker/ajax-action';
import {
    catchError,
    concatMap,
    EMPTY,
    from,
    map,
    mergeMap,
    Observable,
    of,
    ReplaySubject,
    shareReplay,
    Subject,
    switchMap,
    tap,
} from 'rxjs';

declare global {
    interface File {
        id: string;
        importUrl: string;
        hookUrl: string;
        error?: string;
    }
}

export interface MediaFileUpload {
    updateQueue(files: File[]): void;
    getProgress(): Observable<null>;
    getQueue(id: string): Observable<Observable<ProgressFile>[]>;
}

export interface ProgressFile {
    name: string;
    progress: number;
    error?: string;
    url?: string;
}

interface HookResponse extends AjaxActionResponse {
    success: boolean;
    cdnUrl: string;
    fileUrl: string;
    fileName: string;
}

interface FileQueue {
    subject: ReplaySubject<ProgressFile>;
    type: string;
}

@Injectable({
    providedIn: 'root',
})
export class FileUploadService implements MediaFileUpload {
    protected injector = inject(Injector);
    protected http = inject(HttpClient);
    protected ajaxActionService = inject(AjaxActionService);

    protected queue: Record<string, FileQueue> = {};
    protected triggerQueue$ = new ReplaySubject<void>(1);

    protected updateQueue$ = new Subject<File[]>();

    protected progress$: Observable<null> = this.updateQueue$.pipe(
        concatMap((files) => {
            for (const file of files) {
                this.updateProgress(file, { name: file.name, progress: 0 });
            }

            return from(files);
        }),
        mergeMap((file) => this.uploadFile(file), 5),
        map(() => null),
        shareReplay({ bufferSize: 1, refCount: true }),
    );

    getQueue(types: string): Observable<Observable<ProgressFile>[]> {
        return this.triggerQueue$.pipe(
            map(() =>
                Object.values(this.queue).reduce(
                    (acc, { subject, type }) => (types.includes(type) ? [...acc, subject] : acc),
                    [],
                ),
            ),
            shareReplay({ bufferSize: 1, refCount: true }),
        );
    }

    updateQueue(files: File[]): void {
        this.updateQueue$.next(files);
    }

    getProgress(): Observable<null> {
        return this.progress$;
    }

    protected uploadFile(file: File) {
        const { name } = file;
        const uploadData = new FormData();

        uploadData.append('fileName', file.name);
        uploadData.append('fileContentType', file.type);
        uploadData.append('fileSize', file.size.toString());

        return this.http.post<HookResponse>(file.importUrl, uploadData).pipe(
            switchMap((response) =>
                this.http
                    .put(response.fileUrl, file, {
                        reportProgress: true,
                        observe: 'events',
                        headers: { 'Content-Type': file.type },
                    })
                    .pipe(
                        tap((event) => {
                            if (event.type === HttpEventType.UploadProgress && event.total) {
                                const progress = Math.round((100 * event.loaded) / event.total);
                                this.updateProgress(file, { name, progress });
                            }
                        }),
                        switchMap((event) => {
                            if (event.type !== HttpEventType.Response) {
                                return EMPTY;
                            }

                            uploadData.set('fileName', response.fileName);
                            uploadData.append('originalFileName', file.name);

                            return this.http.post<HookResponse>(file.hookUrl, uploadData);
                        }),
                    ),
            ),
            tap((response) => {
                this.ajaxActionService.handle(response, this.injector);
                this.updateProgress(file, { name, progress: 100, url: response.cdnUrl });
            }),
            catchError((error) => {
                this.updateProgress(file, { name, progress: 100, error: error.message });

                return of(null);
            }),
        );
    }

    protected updateProgress(file: File, data: ProgressFile): void {
        const { id } = file;

        if (!this.queue[id]) {
            this.queue[id] = {
                subject: new ReplaySubject<ProgressFile>(1),
                type: file.type,
            };
            this.triggerQueue$.next();
        }

        this.queue[id].subject.next(data);
    }
}
