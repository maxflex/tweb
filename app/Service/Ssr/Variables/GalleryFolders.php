<?php

namespace App\Service\Ssr\Variables;

use App\Models\Folder;
use App\Service\Ssr\SsrVariable;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryFolders extends SsrVariable
{
    public function parse()
    {
        $request = app()->make(Request::class);
        if ($request->has('id')) {
            $currentFolder = Folder::find($request->id);
            $breadcrumbs = $this->getBreadcrumbs($request->id);
            $folders = Folder::where('class', Gallery::class)
                ->searchByFolder($request->id)
                ->orderByPosition()
                ->get();
            $galleryIds = Gallery::searchByFolder($request->id)->orderByPosition()->pluck('id');
        } else {
            $currentFolder = null;
            $breadcrumbs = [];
            $folders = Folder::where('class', Gallery::class)->whereNull('folder_id')->get();
            $galleryIds = Gallery::whereNull('folder_id')->orderByPosition()->pluck('id');
        }
        // dd($breadcrumbs, $folders, $galleryIds);
        $galleryBlock = new GalleryBlock('gallery-block', $this->page, (object) [
            'ids' => $galleryIds->implode(','),
            'title' => '',
            'folders' => ''
        ]);

        return view($this->getViewName(), compact(
            'currentFolder',
            'galleryBlock',
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
