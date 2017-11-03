@foreach($properties as $property)
    <tr>
        <td>{{ $property->title }}</td>
        <td><img src="{{ thumb($property->image) }}" alt=""></td>
        <td>
            @lang('admin.'.$property->status->name)
        </td>
        <td>{{ $property->created_at->formatLocalized('%c') }}</td>
        <td>
            <input type="checkbox" name="seen" value="{{ $property->id }}" {{ is_null($property->ingoing) ?  'disabled' : 'checked'}}>
        </td>
        <td><a class="btn btn-success btn-xs btn-block" href="{{ route('properties.show', [$property->id]) }}" role="button" title="@lang('Show')"><span class="fa fa-eye"></span></a></td>
        <td><a class="btn btn-warning btn-xs btn-block" href="{{ route('properties.edit', [$property->id]) }}" role="button" title="@lang('Edit')"><span class="fa fa-edit"></span></a></td>
        <td><a class="btn btn-danger btn-xs btn-block" href="{{ route('properties.destroy', [$property->id]) }}" role="button" title="@lang('Destroy')"><span class="fa fa-remove"></span></a></td>
    </tr>
@endforeach

