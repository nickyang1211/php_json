<?php

namespace App\Services;
use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Collection;


class CollectionService
{
    private function getData()
    {
        return file_get_contents(storage_path('article.json'));
    }

    public function filter()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->filter(function ($item) {
            
            // return $row['tags'];
            return $item['type'] === '限制文章';
        });
        return $filtered->all();
    }

    public function pluck()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->filter(function ($item) {
            return isset($item['image']);
        });
        $plucked = $filtered->pluck('image');
        return $plucked->all();
    }

    public function contains()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->filter(function ($item) {
            $row = collect($item);
            if($row->contains('image')) {
                return $item;
            }
        })->pluck('image');
        return $filtered;
        // $plucked = $filtered->pluck('image');
        // return $plucked->all();
    }

    public function groupby()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $grouped = $collection_data->groupBy('POST_hint');
        return $grouped->all();
    }

    public function sortby()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $sorted = $collection_data->sortBy('commentCount');
        $row = $sorted->map(function($item) {
            return [
                'title' => $item['title'], // 假设标题字段是 title  
                'comments_count' => $item['commentCount'],
            ];
        });
        return $row->all();
    }

    public function partition()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        [$type_one, $type_two] = $collection_data->partition(function ($item) {
            return $item['type'] === '一般文章';
        });
        return [
            "一般文章"=> $type_one->all(),
            "限制文章"=> $type_two->all(),
        ];
    }

    public function reject()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filteredArticles = $collection_data->filter(function ($item) {
            return $item['likeCount'] < 10000;
        });
        $likesToTitles = $filteredArticles->groupBy('likeCount')->map(function ($articles, $likes) {  
            return [$likes => $articles->pluck('title')->all()];  
        });
        return $likesToTitles->all();
    }

    public function where()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->where('POST_hint', 'image');
        return $filtered->all();
    }

    public function whereIn()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->whereIn('POST_hint', ['image','video']);
        return $filtered->all();
    }

    public function chunk()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->chunk(2);
        return $filtered->all();
    }
    
    public function count()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->count();
        return $filtered;
    }

    public function first()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->first(function ($item) {
            return $item['likeCount'] > 10000;
        });
        return $filtered;
    }

    public function firstWhere()
    {
        $data = $this->getData();
        $json = json_decode($data, true);
        $collection_data = collect($json);
        $filtered = $collection_data->firstWhere('likeCount', '>=', 1000);
        return $filtered;
    }


}