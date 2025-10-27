<!-- Login Modal -->
<div
    class="modal fade"
    style="display: none; background: rgba(0, 0, 0, 0.13);"
    id="reportModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body px-4 px-sm-5 py-0">
                <div class="mb-3">
                    <h2>{{ translate('report_this_ad') }}</h2>
                </div>
                <form action="{{route('report-ad')}}" method="post" id="report_ad_modal" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group mb-4">
                        <label for="email">{{ translate('reason') }}</label>
                        <textarea name="message" class="form-control" row="8" required placeholder="{{translate('Type_your_message')}}"></textarea>
                    </div>
                    <div class="my-4">
                        <button type="submit" class="fs-16 btn btn-primary d-block w-100 px-5">{{ translate('send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
