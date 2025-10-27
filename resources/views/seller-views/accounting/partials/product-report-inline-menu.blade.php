<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('seller/accounting') ?'active':'' }}"><a href="{{route('seller.accounting.index')}}">{{translate('seller_wallet')}}</a></li>
        <li class="{{ Request::is('seller/accounting/balance-transactions') ?'active':'' }}"><a href="{{route('seller.accounting.balance-transactions')}}">{{translate('balance_transactions')}}</a></li>
        <li class="{{ Request::is('seller/accounting/payout-histories') ?'active':'' }}"><a href="{{route('seller.accounting.payout-histories')}}">{{translate('payout_histories')}}</a></li>
    </ul>
</div>
