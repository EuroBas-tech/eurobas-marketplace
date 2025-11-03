<!-- Login Modal -->
<div
    class="modal fade"
    id="sponsorModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="transform: translateX(-28%);">
        <div class="modal-content sponsor-modal">
            <div class="modal-body p-4">
                <div class="row g-3">
                    @if(\App\Model\SponsoredAdType::where('name', 'appearance_in_first_results')->value('status') == 1)
                        <div class="col-md-3">
                            <a href="{{route('create.sponsor')}}?type=appearance-in-first-results" class="d-block rounded border border-cool-primary p-3 sponsor-card" role="button" >
                                <h5 class="text-center text-primary" >{{ translate('first_results_appearance') }}</h5>
                                <div>
                                    <img class="80px" src="{{ cloudfront('sponsor/appear-on-first-results.png') }}" alt="sponsor-image">
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(\App\Model\SponsoredAdType::where('name', 'urgent_sale_sticker')->value('status') == 1)
                        <div class="col-md-3">
                            <a href="{{route('create.sponsor')}}?type=urgent-sale-sticker" class="d-block rounded border border-cool-primary p-3 sponsor-card" role="button" >
                                <h5 class="text-center text-primary" >{{ translate('urgent_sale_sticker') }}</h5>
                                <div>
                                    <img class="80px" src="{{ cloudfront('sponsor/urgent-sale-sticker.png') }}" alt="sponsor-image">
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(\App\Model\SponsoredAdType::where('name', 'promotional_video')->value('status') == 1)
                        <div class="col-md-3">
                            <a href="{{route('create.sponsor')}}?type=promotional-video" class="d-block rounded border border-cool-primary p-3 sponsor-card" role="button" >
                                <h5 class="text-center text-primary" >{{ translate('promotional_video') }}</h5>
                                <div>
                                    <img class="80px" src="{{ cloudfront('sponsor/promotional-video.png') }}" alt="sponsor-image">
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(\App\Model\SponsoredAdType::where('name', 'promotional_banner')->value('status') == 1)
                        <div class="col-md-3">
                            <a href="{{route('create.paid-banners')}}" class="d-block rounded border border-cool-primary p-3 sponsor-card" role="button" >
                                <h5 class="text-center text-primary" >{{ translate('promotional_banner') }}</h5>
                                <div>
                                    <img class="80px" src="{{ cloudfront('sponsor/promotional-banner.png') }}" alt="sponsor-image">
                                </div>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>

    </script>
@endpush
