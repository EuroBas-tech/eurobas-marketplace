<!-- Review Modal -->
<div class="modal fade" id="makeAnOfferModal" style="display: none; background: rgba(0, 0, 0, 0.13);" aria-labelledby="makeAnOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="top: 140px;">
        <div class="modal-content">
            <div class="modal-header px-sm-5 pb-1">
                <h5 class="" id="makeAnOfferModalLabel">{{translate('make_an_offer')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5">
                <form action="{{route('messages_store')}}" method="post" id="contact_with_seller_form" data-success-message="{{translate('offer_sended_successfully')}}">
                    @csrf
                    <input type="hidden" name="seller_id" value="{{$ad->user->id}}" >
<textarea style="block-size: 115px;" name="message" class="form-control" rows="15" required placeholder="{{ translate('type_your_offer_message') }}">{{ translate('dear') }} {{ $ad->user->f_name }}, {{ translate('Im offering you a deal here for') }} 200$.
{{ translate('best Regards') }},
{{ auth('customer')->user()->l_name }}</textarea>
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