<div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 px-3">
    <div>
        <form method="POST" action="{{route('store.sponsor')}}" enctype="multipart/form-data">
            <input type="hidden" name="type" value="{{$sponsor_type}}">
            @csrf
            <div class="col-xl-12 mb-4">
                <div class="form-group">
                    <h1 class="pt-4 pb-3 sponsor-title" >{{translate('Promote Your ads with appearance on top and first results')}}</h2>
                </div>
            </div>

            @include('theme-views.sponsor.partials._user-ads', ['user_ads' => $user_ads])

            @include('theme-views.sponsor.partials._sponsor-package-blade-code')

            <div class="col-12 mt-4"> 
                <div> 
                    <button id="sponsor-submit-btn" type="submit" class="btn btn-primary d-flex align-items-center gap-1"> 
                        <span><i class="bi bi-floppy"></i></span> 
                        <span>{{translate('payment_checkout')}}</span> 
                    </button> 
                </div> 
            </div>
        </form>
    </div>
</div>