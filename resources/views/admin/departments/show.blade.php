{{-- This is ajax called inside the index page modal  --}}
@foreach($department->designations as $index=>$designations)
    <div class="form-group">
        @if($index == 0)
            <label class="control-label">{!! trans('core.designations')!!}</label>
            <small>{!! trans('messages.designationEmptyNote')!!}</small>
        @endif
        <input class="form-control input-medium" name="designation[{{$index}}]" id="designation" type="text"
               value="{{$designations['designation']}}" placeholder="Designation #{{ $index + 1 }}"/>
        <input type="hidden" name="designationID[{{$index}}]" type="text" value="{{$designations['id']}}"/>
    </div>
@endforeach
{{-- This is ajax called inside the index page modal  --}}




