<div class="modal fade" id="search_Modal" style="display: none; background: rgba(0, 0, 0, 0.13);" aria-labelledby="search_ModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-dialog-style">
        <div class="modal-content p-0">
        <div class="col-xl-12">
                    <div class="p-3 rounded mt-2">
                        <ul class="nav nav-tabs custom-tab-style" id="myTab" role="tablist">
                            @foreach($categories as $category)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link max-content fs-18 px-4 text-center @if($loop->index == 0) active @endif" 
                                        id="tab-{{$category->name}}-search" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#{{ str_replace(' ', '-', $category->name) }}-tap-search" 
                                        type="button"
                                        role="tab" 
                                        aria-controls="{{ str_replace(' ', '-', $category->name) }}-tap-search"
                                        aria-selected="@if($loop->index == 0) true @else false @endif">
                                        {{ $category->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content p-2 py-3 px-3">
                            @foreach($categories as $category)
                                <div class="tab-pane fade @if($loop->index == 0) show active @endif" 
                                    id="{{ str_replace(' ', '-', $category->name) }}-tap-search" 
                                    role="tabpanel" 
                                    aria-labelledby="tab-{{$category->name}}-search">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="d-flex h-100 align-items-center justify-content-center">
                                                            <span>
                                                                <i class="bi bi-car-front-fill" style="font-size: 80px;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-3">
                                                                    <input type="text" name="search" placeholder="search for vehicle . . ." id="search-vehicle" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name">{{ translate('country') }}</label>
                                                                    <select class="form-control" name="" id="">
                                                                        <option value="">{{ translate('choose_the_country') }}</option>
                                                                        @foreach (EUROPE_COUNTRIES as $country)
                                                                            <option value="">{{ $country['name'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name">{{ translate('mark') }}</label>
                                                                    <select class="form-control" name="" id="">
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name">{{ translate('model') }}</label>
                                                                    <select class="form-control" name="" id="">
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name">{{ translate('construction_year') }}</label>
                                                                    <select class="form-control" name="" id="">
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name">{{ translate('price') }}</label>
                                                                    <select class="form-control" name="" id="">
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="delivery_service_name">{{ translate('mileage') }}</label>
                                                                    <select class="form-control" name="" id="">
                                                                        <option value="">one</option>
                                                                        <option value="">two</option>
                                                                        <option value="">three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-end">
                                                    <button class="btn btn-primary">
                                                        <i class="bi bi-search"></i>    
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
               </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // This ensures Bootstrap's tab functionality is properly initialized
        var tabElements = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabElements.forEach(function(tabElement) {
            new bootstrap.Tab(tabElement);
        });
    });
</script>
