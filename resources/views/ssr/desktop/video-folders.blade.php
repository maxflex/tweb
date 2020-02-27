
@if(count($folders) > 0)
    <h1 class="h1-top">Видео</h1>

    <table class="folders-table {{ $currentFolder === null ? '' : 'folders-table_has-level' }}">
        @if($currentFolder !== null)
        <thead>
            <tr>
                <td colspan="2">
                    <div class="flex-items">
                        <a href="/videos">
                            <i class="fa fa-folder-open link-like-darken" aria-hidden="true" style="margin-right: 5px"></i>
                        </a>
                        @foreach($breadcrumbs as $index => $breadcrumb)
                            / {{ $breadcrumb['name'] }}
                        @endforeach
                    </div>
                </td>
            </tr>
        </thead>
        @endif
        <tbody>
            @foreach($folders as $folder)
            <tr>
                <td width="456">
                    <div class="flex-items">
                        <i class="fa fa-folder color-blue" aria-hidden="true" style="margin-right: 8px"></i>
                        @if($folder->folder_count === 0 && $folder->item_count === 0)
                            {{ $folder->name }}
                        @else
                        <a class="with-hover" href="/videos?id={{ $folder->id}}">
                            {{ $folder->name }}
                        </a>
                        @endif
                    </div>
                </td>
                <td>
                    @if($folder->folder_count > 0)
                        {{ $folder->folder_count }} папок{{ $folder->item_count > 0 ? ',' : ''}}
                    @endif
                    @if($folder->item_count > 0)
                        {{ $folder->item_count }} видео
                    @endif
                    @if($folder->folder_count === 0 && $folder->item_count === 0)
                        <span class="text-gray">пусто</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h1 class="h1-top">{{ $currentFolder === null ? 'Видео' : $currentFolder->name }}</h1>
    {!! $videoBlock->parse() !!}
@endif

