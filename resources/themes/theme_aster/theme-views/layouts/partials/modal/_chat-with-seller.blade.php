<!-- Review Modal -->
<div class="modal fade" id="contact_sellerModal" style="display: none; background: rgba(0, 0, 0, 0.13);" aria-labelledby="contact_sellerModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="top: 140px;">
        <div class="modal-content">
            <div class="modal-header px-sm-5 pb-1">
                <h5 class="" id="contact_sellerModalLabel">{{translate('contact_With_Seller')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5">
                <form action="{{route('chat_with_seller')}}" method="post" id="contact_with_seller_form" data-success-message="{{translate('send_successfully')}}">
                    @csrf
                    <input type="hidden" name="ad_id" value="{{$ad->id}}" >
                    <input type="hidden" name="seller_id" value="{{$ad->user->id}}" >
                    <textarea name="message" class="form-control" row="8" required placeholder="{{translate('Type_your_message')}}"></textarea>
                    <div class="d-flex justify-content-between mt-3">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary me-2" >{{translate('send')}}</button>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{translate('close')}}</button>
                        </div>
                        <div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>