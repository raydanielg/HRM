{{--Check FOR MAINTENANCE MODE--}}
@if(App::isDownForMaintenance())
    <div class="alert alert-danger text-center">Maintenance Mode</div>
@endif
{{--Check FOR MAINTENANCE MODE--}}