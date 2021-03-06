@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            @include('layouts.info')

            <div class="card">
                <div class="card-header">Company</div>

                <div class="card-body">
                    <a href="{{ route('company.create') }}"><button type="button" class="btn btn-primary">Add</button></a>
                    <br><br>
                    <table class="table table-condensed table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Logo</th>
                                <th>Act</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($company) > 0)
                            @foreach($company as $item => $val)
                            <tr>
                                <td>{{ $item+1 }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->email }}</td>
                                <td><img style="max-width: 100px; max-height: 100px;" class="card-img-top" src="{{ @url('company/'.$val->file) }}" alt="{{$val->file}}"></td>
                                <td>
                                    <a href="{{ route('company.edit', ['company' => $val->id]) }}"><button type="button" class="btn btn-sm btn-secondary ">Edit</button></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnDelete" data-id="formDelete-{{ $val->id }}">Hapus</a>
                                    <form action="{{ route('company.destroy', ['company' => $val->id])}}" method="post" id="formDelete-{{ $val->id }}" style="visibility: hidden;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                        <button id="btnDelete" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="8" class="text-center"> <label class="text-danger">Data yang anda cari tidak di temukan !</label> </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <nav class="">
                        {{ $company->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click', '.btnDelete', function(event) {
        event.preventDefault();
        let id = $(this).data('id');
        if (confirm("Yakin delete data ini ?")) {
            $("form#" + id).submit();
        }
    });


</script>
@endsection
