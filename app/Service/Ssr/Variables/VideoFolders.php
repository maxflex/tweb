<?php

namespace App\Service\Ssr\Variables;

use App\Models\Folder;
use App\Service\Ssr\SsrVariable;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoFolders extends SsrVariable
{
    public function parse()
    {
        $request = app()->make(Request::class);
        if ($request->has('id')) {
            $currentFolder = Folder::find($request->id);
            $breadcrumbs = $this->getBreadcrumbs($request->id);
            $folders = Folder::where('class', Video::class)
                ->searchByFolder($request->id)
                ->orderByPosition()
                ->get();
            $videoIds = Video::searchByFolder($request->id)->orderByPosition()->pluck('id');
        } else {
            $currentFolder = null;
            $breadcrumbs = [];
            $folders = Folder::where('class', Video::class)->whereNull('folder_id')->get();
            $videoIds = Video::whereNull('folder_id')->orderByPosition()->pluck('id');
        }
        // dd($breadcrumbs, $folders, $videoIds);
        $videoBlock = new VideoBlock('video-block', $this->page, (object) [
            'ids' => $videoIds->implode(','),
            'title' => '',
            'options' => [
                'show' => 9,
                'showBy' => 9
            ]
        ]);

        return view($this->getViewName(), compact(
            'currentFolder',
            'videoBlock',
            'folders',
            'breadcrumbs'
        ));
    }

    private function getBreadcrumbs($folderId)
    {
        $breadcrumbs = [];
        $current_folder = Folder::find($folderId);
        while (true) {
            $breadcrumbs[] = [
                'id'    => $current_folder->id,
                'name'  => $current_folder->name,
            ];
            if ($current_folder->folder_id) {
                $current_folder = Folder::find($current_folder->folder_id);
            } else {
                break;
            }
        }
        return array_reverse($breadcrumbs);
    }
}
