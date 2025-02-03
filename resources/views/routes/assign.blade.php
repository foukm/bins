@extends('main')
@section('content')

    <div class="col-12">
        <table class = "table table-border data-table">
            <thead>
            <h3 class="box">Ανάθεση αιτημάτων</h3>
            <tr>
                <th>ID</th>
                <th>Εντολέας</th>
                <th>Tηλέφωνο</th>
                <th>Πληροφορίες</th>
                <th>Έχει ανατεθεί</th>
                <th>Επιλογή διαδρομής</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{$request->id}}</td>
                    <td>{{$request->name}}</td>
                    <td>{{$request->phone}}</td>
                    <td>{{$request->info}}</td>
                    <td>{{$request->is_assigned == false ? 'ΟΧΙ' : 'ΝΑΙ'}}</td>
                    <td>
                        @if(!$request->is_assigned)
                        <select name="route_for_{{$request->id}}" id="route_for_{{$request->id}}" class="select-route" data-id="{{$request->id}}">
                            <option value="-1" disabled selected>Επιλέξτε διαδρομή</option>
                            @foreach($routes as $route)
                                <option value="{{$route->id}}">{{$route->name}}</option>
                            @endforeach
                        </select>
                        @else
                            @if(!is_null($request->assigned_to))
                                {{$request->route->name}}
                            @endif
                        @endif
                    </td>
                    <td>
                        @if(!$request->is_assigned)
                            <button type="button" class="btn btn-light btn-assign btn-assign-{{$request->id}}" data-id="{{$request->id}}" disabled>Ανάθεση</button>
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
                var request_id = $(this).data('id');
                var selectedRoute = $('#route_for_'+request_id).val();
                var url = '{{ route('requests.assign.store', ['userRequest' => ':userRequest', 'route' => ':route']) }}';
                $.ajax({
                    url: url.replace(':userRequest', request_id).replace(':route',selectedRoute),
                    method: 'POST',
                    data:{
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(response) {
                        if(response['success']){
                            window.location = '{{route('requests.assign')}}';
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
