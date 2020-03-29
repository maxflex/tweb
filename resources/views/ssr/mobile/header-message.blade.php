<div class="header-message">
    @if($firstLine !== null)
        <div class="header-message__first-line">
            {{ $firstLine }}
        </div>
    @endif
    @foreach($lines as $index => $line)
    <div>
        {{ $line }}
    </div>
    @endforeach
</div>
