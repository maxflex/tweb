<div class="full-width gray-full-width" style='margin-bottom: 60px'>
    <div class="common" style='display: inline-block'>
        <div class='header-1' style='padding-bottom: 30px'>{{ $title }}</div>
        <div class="main-page-masters">
            @foreach ($items as $item)
            <div>
               <div>
                    <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                        <img src='{{ $item->photo_url }}' class="master-photo">
                    </a>
                </div>
                <div>
                    <div class="master-name">
                        <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                            {{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}
                        </a>
                    </div>
                    <div class="masters-description">
                        {{ $item->description_short }} <a href='/masters/{{ $item->id }}/'>Подробнее...</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
         <center class='more-button' style='margin: 40px 0 0'>
            <a class='no-style-link' href='/masters/'>
                <button class="btn-border">смотреть всех</button>
            </a>
        </center>
    </div>
</div>
