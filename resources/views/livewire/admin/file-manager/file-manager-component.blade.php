<div>

    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#fileManager">
        FileManager
    </a>

    <div wire:ignore.self class="modal fade" id="fileManager" tabindex="-1" aria-labelledby="fileManagerLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="update-loading" wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">FileManager</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="path" class="form-label">Image</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control @error('path') is-invalid @enderror"
                                id="path" wire:model="path">
                            <div class="input-group-append">
                                <a class="btn btn-primary" wire:click="saveMedia">Save</a>
                            </div>
                        </div>

                        @error('path')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <div wire:loading wire:target="path">
                            <span class="text-success">Uploading...</span>
                        </div>

                        @if (!$errors->has('path') && $path && $path->isPreviewable())
                            <p class="text-danger">Click on the photo to delete it.</p>
                            <img src="{{ $path->temporaryUrl() }}" alt="" width="100"
                                wire:click="removeUpload('path', '{{ $path->getFilename() }}')">
                        @endif

                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <tbody>
                                @foreach ($media as $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td><img src="{{ asset($item->path) }}" alt="" height="50"></td>
                                        <td>{{ asset($item->path) }}</td>
                                        <td>
                                            <div x-data="{ input: '{{ asset($item->path) }}', showMsg: false }">
                                                <div class="overflow-hidden">

                                                    <a @click="navigator.clipboard.writeText(input), showMsg = true, setTimeout(() => showMsg = false, 1000)"
                                                        class="btn btn-warning" title="Copy url">
                                                        <i class="far fa-copy"></i>
                                                    </a>
                                                    <p x-show="showMsg" @click.away="showMsg = false"
                                                        class="media-copied" style="display: none;">Copied to Clipboard
                                                    </p>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $media->links(data: ['scrollTo' => false]) }}
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
