<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/accounting') ?'active':'' }}">
            <a href="{{route('admin.accounting.index')}}">
                {{translate('admin_wallet')}}
            </a>
        </li>
        <li class="{{ Request::is('admin/accounting/costs-and-expenses') ? 'active':'' }}">
            <a href="{{route('admin.accounting.costs-and-expenses')}}">
                {{translate('costs_and_expenses')}}
            </a>
        </li>
    </ul>
</div>
