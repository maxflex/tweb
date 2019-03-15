@foreach ($items as $item)
<p>
    <a href='/{{ $item->url }}/'>{{ $item->title }}</a>
</p>
@endforeach
