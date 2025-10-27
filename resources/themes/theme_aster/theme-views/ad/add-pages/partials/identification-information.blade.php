<div class="mb-1 border px-3 py-3 rounded custom-gray-border-color" >
    <div class="mb-3" >
        <h2>{{ translate('identification_informations') }}</h2>
    </div>
    <div class="col-sm-12 mb-3">
        <div class="form-group">
            <label for="title">{{translate('title')}}</label>
            <input type="text" id="title" class="form-control" value="{{ $data['title'] ?? old('title') }}" name="title" placeholder="{{translate('ad_title')}}">
        </div>
    </div>
    <div class="col-sm-12 mb-3">
        <div class="form-group">
            <label for="description">{{translate('description')}}</label>
            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
        </div>
    </div>
</div>