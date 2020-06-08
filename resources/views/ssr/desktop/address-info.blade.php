<div class="address-info-block flex-items map-block-wrapper">
    <div>
        <div class="flex-items">
            <i class="fas fa-map-marker-alt"></i>
            <span>
                {{ $info->address }}
            </span>
        </div>
        <div class="flex-items">
            <i class="far fa-clock"></i>
            <span>
                09:00-21:00 без выходных
            </span>
        </div>
        <div class="flex-items">
            <i class="fas fa-location-arrow"></i>
            <a href="{{ $info->route }}" target="_blank">
              Проложить маршрут
            </a>
        </div>
    </div>
    <div>
        <div class="flex-items">
            <i class="fas fa-phone"></i>
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
            <i class="fab fa-whatsapp-square"></i>
            <a href="whatsapp://send?phone=+79057464481">
                +7 903 763 15 21
            </a>
        </div>
        <div class="flex-items">
            <i class="fab fa-viber"></i>
            <a href="viber://chat?number=+79057464481">
                +7 903 763 15 21
            </a>
        </div>
    </div>
    <div>
        <div class="flex-items">
            <i class="fas fa-globe"></i>
            <a href="https://atelier-talisman.ru">
                atelier-talisman.ru
            </a>
        </div>
        <div class="flex-items">
            <i class="fas fa-envelope"></i>
            <a href="mail:info@atelier-talisman.ru">
                info@atelier-talisman.ru
            </a>
        </div>
        <div class="flex-items">
            <i class="fab fa-cc-mastercard"></i>
            <span>
                Оплата по картам
            </span>
        </div>
    </div>
    <div>
        <div class="flex-items">
            <i class="fab fa-instagram"></i>
            <a href="https://instagram.com/atelier_talisman" target="_blank">
                Instagram
            </a>
        </div>
        <div class="flex-items">
            <i class="fab fa-vk"></i>
            <a href="https://vk.com/atelier_talisman" target="_blank">
                ВК
            </a>
        </div>
        <div class="flex-items">
            <i class="fab fa-youtube"></i>
            <a href="https://www.youtube.com/channel/UCCIMu941ZNGNMhDwlaWHNSA" target="_blank">
                Youtube
            </a>
        </div>
    </div>
</div>
