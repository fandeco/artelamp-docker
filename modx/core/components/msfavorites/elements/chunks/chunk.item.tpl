<div class="row ms2_product">
    <div class="span2 col-md-2"><img src="[[+thumb:default=`[[++assets_url]]components/minishop2/img/web/ms2_small.png`]]" width="120" height="90" /></div>
    <div class="row span10 col-md-10">
        <form method="post" class="ms2_form">
            <a href="[[~[[+id]]]]">[[+pagetitle]]</a>
            <span class="flags">[[+new]] [[+popular]] [[+favorite]]</span>
            <span class="price">[[+price]] [[%ms2_frontend_currency]]</span>
            [[+old_price]]
            <button class="btn btn-default" type="submit" name="ms2_action" value="cart/add"><i class="glyphicon glyphicon-barcode"></i> [[%ms2_frontend_add_to_cart]]</button>
            <input type="hidden" name="id" value="[[+id]]">
            <input type="hidden" name="count" value="1">
            <input type="hidden" name="options" value="[]">

            <!-- msfavorites -->

            <div class="favorites favorites-default [[+msfavorites.ids.[[+id]]]]" data-id="[[+id]]">
                <a href="#" class="favorites-add favorites-link" data-text="[[%msfavorites_updating]]">[[%msfavorites_add_to_list]]</a>
                <a href="#" class="favorites-remove favorites-link" data-text="[[%msfavorites_updating]]">[[%msfavorites_remove_from_list]]</a>
                <a href="[[+msfavorites.link]]" class="favorites-go">[[%msfavorites_go_to_list]]</a>
                <span class="favorites-total">[[+msfavorites.total]]</span>
            </div>

            <!-- /msfavorites -->
        </form>
        <p><small>[[+introtext]]</small></p>
    </div>
    <br/><br/>
</div>

<!--minishop2_popular <i class="glyphicon glyphicon-star" title="[[%ms2_frontend_popular]]"></i>-->
<!--minishop2_new <i class="glyphicon glyphicon-flag" title="[[%ms2_frontend_new]]"></i>-->
<!--minishop2_favorite <i class="glyphicon glyphicon-bookmark" title="[[%ms2_frontend_favorite]]"></i>-->
<!--minishop2_old_price <span class="old_price">[[+old_price]] [[%ms2_frontend_currency]]</span>-->
