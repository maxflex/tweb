<div>
    Имя: {{ @$request->name }}
</div>
<div>
    Телефон: {{ @$request->phone }}
</div>
<div>
    Комментарий: {{ @$request->comment }}
</div>
@if (isset($request->photos) && count($request->photos))
    <div>
        Фотографии:
        <ul>
            @foreach ($request->photos as $index => $url)
                <li>
                    <a href='{{ config('app.url') }}{{ \App\Models\Photo::UPLOAD_DIR }}{{ $url }}'>{{ $index + 1 }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
