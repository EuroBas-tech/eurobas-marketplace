<form id="redirectForm" action="{{ $route }}" method="POST">
    @csrf
    <input type="hidden" name="ad_id" value="{{ session('sponsor_data')['ad_id'] }}">
    @foreach(session('sponsor_data')['packages_ids'] as $key => $value)
        <input type="hidden" name="packages_ids[]" value="{{ $value }}">
    @endforeach
</form>

<script>
    document.getElementById('redirectForm').submit();
</script>