<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use DB;
use App\Models\Decorators\TagsFilterDecorator;
use App\Models\{Review, Folder};

class ReviewsBlock extends SsrVariable {
    public function parse()
    {
        $items = isset($this->args->items) ? $this->args->items : $this->getItems();
        $show = isset($this->args->show) ? $this->args->show : 3;
        $showBy = isset($this->args->showBy) ? $this->args->showBy : 10;

        return view($this->getViewName(), [
            'items' => $items,
            'options' => [
                'show' => $show,
                'showBy' => intval($showBy),
            ],
        ]);
    }

    private function getItems()
    {
        if (! $this->args->ids && ! $this->args->folders) {
            $final_query = (new TagsFilterDecorator(Review::with('master')))->withTags(isset($this->args->tags) ? $this->args->tags : '')->orderBy('folder_id', 'asc')->orderByPosition();
        } else {
            $ids = array_filter(explode(',', $this->args->ids));

            if ($this->args->folders) {
                $folder_ids = array_filter(explode(',', $this->args->folders));

                // append all subfolders
                $subfolder_ids = [];
                foreach($folder_ids as $folder_id) {
                    $subfolder_ids = array_merge($subfolder_ids, Folder::getSubfolderIds($folder_id));
                }
                $folder_ids = array_merge($folder_ids, $subfolder_ids);

                $ids_from_folders = [];
                foreach($folder_ids as $folder_id) {
                    $ids_from_folders = array_merge($ids_from_folders, Review::where('folder_id', $folder_id)->orderByPosition()->pluck('id')->all());
                }

                $ids = array_merge($ids_from_folders, $ids);
            }

            $final_query = Review::with('master')->whereIn('id', $ids);
            if (count($ids)) {
                $final_query->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
            }
        }

        return $final_query->get();
    }
}
