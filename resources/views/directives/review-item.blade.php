<div class="student-review">
    <div class="student-review-photo"></div>
    <div class="student-review-text">
        <div class="student-review-name">@{{ item.signature }}</div>
        <div>
            <span>@{{ item.body }}</span>
            <span ng-if="item.master">
                Мастер:
                <a href='/masters/@{{ item.master.id }}/'>@{{ item.master.first_name }} @{{ item.master.middle_name }}</a>
            </span>
        </div>
        <div class="student-review-date">
            @{{ item.date_string }}
        </div>
    </div>
</div>
