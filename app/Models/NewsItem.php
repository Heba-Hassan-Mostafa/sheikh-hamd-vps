<?php

namespace App\Models;

use App\Models\Lesson;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;



class NewsItem extends Lesson implements Feedable
{
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->slug,
            'title' => $this->name,
            'summary' => !empty($this->content) ? $this->content : '',
            'updated' => $this->publish_date,
            'link' => route('frontend.lessons.lesson_content',$this->slug),
            'authorName' => setting()->site_name,
        ]);
    }


    public static function getFeedItems()
    {
       return NewsItem::all();
    }
}