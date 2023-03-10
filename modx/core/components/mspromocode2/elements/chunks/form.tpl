{*@formatter:off*}

<div class="mspc2 [ js-mspc2 ]">
    {* Form *}
    <div class="mspc2-form [ js-mspc2-form ] {$is_active ? 'is-active' : ''}">
        <input class="mspc2-form__input [ js-mspc2-input ]" {$is_active ? 'disabled="true"' : ''}
               type="text" name="mspc2_code" value="{$coupon['code'] ?: ''}" placeholder="Промо-код">
        <button class="mspc2-form__button mspc2-form__button_submit [ js-mspc2-submit ]"
                type="button">Применить</button>
        <button class="mspc2-form__button mspc2-form__button_cancel [ js-mspc2-cancel ]"
                type="button">Отменить</button>
    </div>

    {* Discount amount *}
    <div class="mspc2-discount-amount">
        Скидка в корзине:
        <span class="[ js-mspc2-discount-amount ]">{$discount_amount}</span>
        {'ms2_frontend_currency' | lexicon}
    </div>

    {* Info *}
    <div class="mspc2-description [ js-mspc2-coupon-description ]">
        {$coupon['description'] ?: ''}
    </div>

    {* Notifications *}
    <div class="mspc2-message">
        <div class="mspc2-message__info [ js-mspc2-message-info ]">{$message_info}</div>
        <div class="mspc2-message__error [ js-mspc2-message-error ]">{$message_error}</div>
        <div class="mspc2-message__success [ js-mspc2-message-success ]">{$message_success}</div>
    </div>
</div>