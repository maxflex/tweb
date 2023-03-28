<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\{PriceSection, PricePosition};
use Illuminate\Support\Facades\Log;

class PriceBlock extends SsrVariable {

    public function parse()
    {
        $isFullPrice = $this->page->url === 'price';

        $prices = [];
        $maxPrice = 0;
        $lowPrice = 0;
        $offerCount = 0;


        $items = $this->getItems();

        foreach ($items as $models){
            if (isset($models['items'])) {
                foreach ($models['items'] as $model) {
                    if (isset($model['items'])) {
                        foreach ($model['items'] as $item) {
                            if (isset($item['model']['price'])){

                                $price = str_replace(' ', '', $item['model']['price']);
                                $price = (int)$price;

                                if ($price > 0)
                                    $prices[] = $price;
                            }
                        }
                    }
                }
            }
        }

        if (!empty($prices)){
            $maxPrice = max($prices);
            $lowPrice = min($prices);
            $offerCount = count($prices);
        }

        Log::debug($prices);

        return view($this->getViewName(), [
            'title' => $this->args->title,
            'items' => $items,
            'nobutton' => isset($this->args->nobutton),
            'isFullPrice' => $isFullPrice,
            'maxPrice' => $maxPrice,
            'lowPrice' => $lowPrice,
            'offerCount' => $offerCount
        ]);
    }

    private function getItems()
    {
        $items = [];

        // Допустимые ID позиций, если указан folders или ids
        $allowed_ids = [];

        // Берем все допустимые ID из папок
        $ids_from_folders = [];
        if (@$this->args->folders) {
            // append all subfolders
            $subfolder_ids = [];
            foreach($this->args->folders as $folder_id) {
                $subfolder_ids = array_merge($subfolder_ids, PriceSection::getSubsectionIds($folder_id));
            }
            $folder_ids = array_merge($this->args->folders, $subfolder_ids);

            foreach($folder_ids as $folder_id) {
                $allowed_ids = array_merge($allowed_ids, PricePosition::where('price_section_id', $folder_id)->orderBy('position')->pluck('id')->all());
            }
        }

        // Допустимые ID
        if (@$this->args->ids) {
            $allowed_ids = array_merge($allowed_ids, $this->args->ids);
        }

        $allowed_ids = array_unique($allowed_ids);
        if (! count($allowed_ids)) {
            $allowed_ids = null;
        }

        $top_level_price_sections = PriceSection::whereNull('price_section_id')->orderBy('position')->get();
        foreach($top_level_price_sections as $section) {
            $item = $section->getItem(@$this->page->tags, $allowed_ids);
            if ($item !== null) {
                $items[] = $section->getItem(@$this->page->tags, $allowed_ids);
            }
        }
        return $items;
    }
}
