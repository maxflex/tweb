<div class="flex-items address-info-block address-info-block_all">
    <div>
        <div class="header-3">
            <a href="/len/">Талисман на Ленинском</a>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/marker.png);"
            ></div>
            <span>
                {{ $maps["len"]["address"] }}
            </span>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/route.png);"
            ></div>
            <a rel="nofollow" href="{{ $maps['len']['route'] }}" target="_blank">
                Проложить маршрут
            </a>
        </div>
        <div class="flex-items" style="margin-top: 35px;">
            <div
                class="img"
                style="background-image: url(/img/icons/border/phone.png);"
            ></div>
            <div class="flex-items">
                <a href="tel:84952152231">
                    +7 495 215-22-31
                </a>
                <span> , {{ $maps["len"]["phone"] }} </span>
            </div>
        </div>
        <div class="flex-items">
            <div class="img" style="background-image: url(/img/icons/border/whatsapp.png)"></div>
            <a href="whatsapp://send?phone=+{{ \App\Service\Phone::clean($maps['len']['mobile']) }}">
                {{ $maps['len']['mobile'] }}
            </a>
        </div>
        <div class="flex-items">
            <div class="img" style="background-image: url(/img/icons/border/viber.png)"></div>
            <a href="viber://chat?number=+{{ \App\Service\Phone::clean( $maps['len']['mobile'] ) }}">
                {{ $maps['len']['mobile'] }}
            </a>
        </div>
        <div class="flex-items" style="margin-top: 35px;">
            <div
                class="img"
                style="background-image: url(/img/icons/border/globe.png);"
            ></div>
            <a href="https://www.atelier-talisman.ru/">
                atelier-talisman.ru
            </a>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/instagram.png);"
            ></div>
            <a rel="nofollow" href="https://instagram.com/atelier_talisman" target="_blank">
                Instagram
            </a>
        </div>
        <div class="address-info-gallery">
            <a href="{{ $maps['len']['gallery']['link'] }}">
                <img loading="lazy" src="https://cms.atelier-talisman.ru/img/gallery/{{ $maps['len']['gallery']['id'] }}.jpg" />
            </a>
            <div>
                <a href="{{ $maps['len']['gallery']['link'] }}">
                    {{ $maps['len']['gallery']['h1'] }}
                </a>
            </div>
            <span>
                {{ $maps['len']['gallery']['text'] }}
            </span>
        </div>
    </div>
    <div>
        <div class="header-3">
            <a href="/pol/">Талисман на Полежаевской</a>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/marker.png);"
            ></div>
            <span>
                {{ $maps["pol"]["address"] }}
            </span>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/route.png);"
            ></div>
            <a rel="nofollow" href="{{ $maps['pol']['route'] }}" target="_blank">
                Проложить маршрут
            </a>
        </div>
        <div class="flex-items" style="margin-top: 35px;">
            <div
                class="img"
                style="background-image: url(/img/icons/border/phone.png);"
            ></div>
            <div class="flex-items">
                <a href="tel:84952152231">
                    +7 495 215-22-31
                </a>
                <span> , {{ $maps["pol"]["phone"] }} </span>
            </div>
        </div>

        <div class="flex-items">
            <div class="img" style="background-image: url(/img/icons/border/whatsapp.png)"></div>
            <a href="whatsapp://send?phone=+{{ \App\Service\Phone::clean($maps['pol']['mobile']) }}">
                {{ $maps['pol']['mobile'] }}
            </a>
        </div>
        <div class="flex-items">
            <div class="img" style="background-image: url(/img/icons/border/viber.png)"></div>
            <a href="viber://chat?number=+{{ \App\Service\Phone::clean( $maps['pol']['mobile'] ) }}">
                {{ $maps['pol']['mobile'] }}
            </a>
        </div>
        <div class="flex-items" style="margin-top: 35px;">
            <div
                class="img"
                style="background-image: url(/img/icons/border/mail.png);"
            ></div>
            <a href="mailto:info@atelier-talisman.ru">
                info@atelier-talisman.ru
            </a>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/youtube.png);"
            ></div>
            <a
                rel="nofollow"
                href="https://www.youtube.com/channel/UCCIMu941ZNGNMhDwlaWHNSA"
                target="_blank"
            >
                Youtube
            </a>
        </div>

        <div class="address-info-gallery">
            <a href="{{ $maps['pol']['gallery']['link'] }}">
                <img loading="lazy" src="https://cms.atelier-talisman.ru/img/gallery/{{ $maps['pol']['gallery']['id'] }}.jpg" />
            </a>
            <div>
                <a href="{{ $maps['pol']['gallery']['link'] }}">
                    {{ $maps['pol']['gallery']['h1'] }}
                </a>
            </div>
            <span>
                {{ $maps['pol']['gallery']['text'] }}
            </span>
        </div>
    </div>
    <div>
        <div class="header-3">
            <a href="/delegat/">Талисман на Цветном бульваре</a>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/marker.png);"
            ></div>
            <span>
                {{ $maps["delegat"]["address"] }}
            </span>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/route.png);"
            ></div>
            <a rel="nofollow" href="{{ $maps['delegat']['route'] }}" target="_blank">
                Проложить маршрут
            </a>
        </div>
        <div class="flex-items" style="margin-top: 35px;">
            <div
                class="img"
                style="background-image: url(/img/icons/border/phone.png);"
            ></div>
            <div class="flex-items">
                <a href="tel:84952152231">
                    +7 495 215-22-31
                </a>
                <span> , {{ $maps["delegat"]["phone"] }} </span>
            </div>
        </div>

         <div class="flex-items">
            <div class="img" style="background-image: url(/img/icons/border/whatsapp.png)"></div>
            <a href="whatsapp://send?phone=+{{ \App\Service\Phone::clean($maps['delegat']['mobile']) }}">
                {{ $maps['delegat']['mobile'] }}
            </a>
        </div>
        <div class="flex-items">
            <div class="img" style="background-image: url(/img/icons/border/viber.png)"></div>
            <a href="viber://chat?number=+{{ \App\Service\Phone::clean( $maps['delegat']['mobile'] ) }}">
                {{ $maps['delegat']['mobile'] }}
            </a>
        </div>
        <div class="flex-items" style="margin-top: 35px;">
            <div
                class="img"
                style="background-image: url(/img/icons/border/card.png);"
            ></div>
            <span>
                Оплата по картам
            </span>
        </div>
        <div class="flex-items">
            <div
                class="img"
                style="background-image: url(/img/icons/border/vk.png);"
            ></div>
            <a rel="nofollow" href="https://vk.com/atelier.talisman" target="_blank">
                ВК
            </a>
        </div>
        <div class="address-info-gallery">
           <a href="{{ $maps['delegat']['gallery']['link'] }}">
                <img loading="lazy" src="https://cms.atelier-talisman.ru/img/gallery/{{ $maps['delegat']['gallery']['id'] }}.jpg" />
            </a>
            <div>
                <a href="{{ $maps['delegat']['gallery']['link'] }}">
                    {{ $maps['delegat']['gallery']['h1'] }}
                </a>
            </div>
            <span>
                {{ $maps['delegat']['gallery']['text'] }}
            </span>
        </div>
    </div>
</div>
