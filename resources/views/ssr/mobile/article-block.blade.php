@foreach ($items as $item)
<div class='article-list'>
    <p>
        <a href='/{{ $item->url }}/'>{{ $item->title }}</a>
    </p>
</div>
@endforeach
