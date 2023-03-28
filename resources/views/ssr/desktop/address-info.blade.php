        <div class="flex-items address-info-block">
            <div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/marker.png)">
                    </div>
                    <span>
                        {{ $info->address }}
                    </span>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/clock.png)"></div>
                    <span>
                        09:00-21:00 без выходных
                    </span>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/route.png)"></div>
                    <a href="{{ $info->route }}" target="_blank">
                    Проложить маршрут
                    </a>
                </div>
            </div>
            <div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/phone.png)"></div>
                    <div class="flex-items">
                        <a href="tel:84952152231">
                            +7 495 215-22-31
                        </a>
                        <span>
                            , {{ $info->phone }}
                        </span>
                    </div>
                </div>

                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/whatsapp.png)"></div>
                    <a href="whatsapp://send?phone=+{{ \App\Service\Phone::clean($info->mobile) }}">
                        {{ $info->mobile }}
                    </a>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/viber.png)"></div>
                    <a href="viber://chat?number=+{{ \App\Service\Phone::clean($info->mobile) }}">
                        {{ $info->mobile }}
                    </a>
                </div>
            </div>
            <div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/globe.png)"></div>
                    <a href="https://www.atelier-talisman.ru/">
                        atelier-talisman.ru
                    </a>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/mail.png)"></div>
                    <a href="mailto:info@atelier-talisman.ru">
                        info@atelier-talisman.ru
                    </a>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/card.png)"></div>
                    <span>
                        Оплата по картам
                    </span>
                </div>
            </div>
            <div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/instagram.png)"></div>
                    <a rel="nofollow" href="https://instagram.com/atelier_talisman" target="_blank">
                        Instagram
                    </a>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/vk.png)"></div>
                    <a href="https://vk.com/atelier_talisman" target="_blank">
                        ВК
                    </a>
                </div>
                <div class="flex-items">
                    <div class="img" style="background-image: url(/img/icons/border/youtube.png)"></div>
                    <a href="https://www.youtube.com/channel/UCCIMu941ZNGNMhDwlaWHNSA" target="_blank">
                        Youtube
                    </a>
                </div>
            </div>
        </div>
