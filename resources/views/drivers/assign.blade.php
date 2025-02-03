@extends('main')
@section('content')

    <div class="col-12">
        <table class = "table table-border data-table">
            <thead>
            <h3 class="box">Ανάθεση διαδρομής σε οδηγό</h3>
            <tr>
                <th>ID</th>
                <th>Όνομα διαδρομής</th>
                <th>Πληροφορίες</th>
                <th>Έχει ανατεθεί</th>
                <th>Επιλογή οδηγού</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($routes as $route)
                <tr>
                    <td>{{$route->id}}</td>
                    <td>{{$route->name}}</td>
                    <td>{{$route->notes}}</td>
                    <td>{{$route->is_assigned == false ? 'ΟΧΙ' : 'ΝΑΙ'}}</td>
                    <td>
                        @if(!$route->is_assigned)
                        <select name="driver_for_{{$route->id}}" id="driver_for_{{$route->id}}" class="select-route" data-id="{{$route->id}}">
                            <option value="-1" disabled selected>Επιλέξτε οδηγό</option>
                            @foreach($drivers as $driver)
                                <option value="{{$driver->id}}">{{$driver->name}}</option>
                            @endforeach
                        </select>
                        @else
                            @if(!is_null($route->assigned_to))
                                {{$route->driver->name}}
                            @endif
                        @endif
                    </td>
                    <td>
                        @if(!$route->is_assigned)
                            <button type="button" class="btn btn-light btn-assign btn-assign-{{$route->id}}" data-id="{{$route->id}}" disabled>Ανάθεση</button>
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){

            $('.btn-assign').on('click',function (e){
                var route_id = $(this).data('id');
                var selectedDriver = $('#driver_for_'+route_id).val();
                var url = '{{ route('routes.assign.store', ['route' => ':route', 'driver' => ':driver']) }}';
                $.ajax({
                    url: url.replace(':route', route_id).replace(':driver',selectedDriver),
                    method: 'POST',
                    data:{
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(response) {
                        if(response['success']){
                            window.location = '{{route('routes.assign')}}';
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                });
            })

            $('.select-route').on('change',function(e){
                if($(this).val() !== ''){
                    $('.btn-assign-'+$(this).data('id')).removeAttr('disabled');
                }
            })
        })
    </script>
@endpush
