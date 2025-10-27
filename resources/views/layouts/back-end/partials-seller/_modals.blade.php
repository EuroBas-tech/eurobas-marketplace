<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{translate('ready_to_Leave')}}?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{translate('select_Logout_below_if_you_are_ready_to_end_your_current_session')}}.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{translate('cancel')}}</button>
                <a class="btn btn--primary" href="{{route('seller.auth.logout')}}">{{translate('logout')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 class="__color-8a8a8a">
                                <i class="tio-shopping-cart-outlined"></i> {{translate('you_have_new order')}}, {{translate('check_Please')}}.
                            </h2>
                            <hr>
                            <button onclick="check_order()" class="btn btn--primary">{{translate('ok')}}, {{translate('let_me_check')}}</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="NotificationModal" tabindex="-1"
                        aria-labelledby="shiftNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg" id="NotificationModalContent">

        </div>
    </div>
</div>

<div class="modal" id="receive-response-popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 class="__color-8a8a8a">
                                <i class="tio-money"></i> {{ translate('you_have_a_admin_receive_response') }}, {{ translate('check_please') }}.
                            </h2>
                            <hr>
                            <button onclick="check_receive_response()" class="btn btn--primary">{{ translate('ok') }}, {{ translate('let_me_check') }}</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="balance-transactions-popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 class="__color-8a8a8a">
                                <i class="tio-money"></i> {{ translate('your_balance_have_been_sent_by_the_admin') }}, {{ translate('check_please') }}.
                            </h2>
                            <hr>
                            <button onclick="check_balance_transactions()" class="btn btn--primary">{{ translate('ok') }}, {{ translate('let_me_check') }}</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="refund_request-popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 class="__color-8a8a8a">
                                <i class="tio-money"></i> {{ translate('you_have_a_refund_request') }}, {{ translate('check_please') }}.
                            </h2>
                            <hr>
                            <button onclick="check_refund_request()" class="btn btn--primary">{{ translate('ok') }}, {{ translate('let_me_check') }}</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="canceled-orders-popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 class="__color-8a8a8a">
                                <i class="tio-money"></i> {{ translate('you_have_a_canceled_order') }}, {{ translate('check_please') }}.
                            </h2>
                            <hr>
                            <button onclick="check_canceled_orders()" class="btn btn--primary">{{ translate('ok') }}, {{ translate('let_me_check') }}</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

