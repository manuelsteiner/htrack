@if(Session::has('success'))
    <notification type="success"  v-cloak>
        <i class="feather-24 align-text-bottom mr-1" data-feather="check"></i>
        {{ Session::get('success') }}
    </notification>
@elseif(Session::has('info'))
    <notification type="info" v-cloak>
        <i class="feather-24 align-text-bottom mr-1" data-feather="info"></i>
        {{ Session::get('info') }}
    </notification>
@elseif(Session::has('warning'))
    <notification type="warning"  v-cloak>
        <i class="feather-24 align-text-bottom mr-1" data-feather="alert-triangle"></i>
        {{ Session::get('warning') }}
    </notification>
@elseif(Session::has('danger'))
    <notification type="danger"  v-cloak>
        <i class="feather-24 align-text-bottom mr-1" data-feather="alert-octagon"></i>
        {{ Session::get('danger') }}
    </notification>
@endif