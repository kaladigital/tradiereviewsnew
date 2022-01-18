@extends('layouts.master')
@section('view_css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'verification_codes'])
    <div class="col-md-auto col-12 content-wrap">
        <div class="content-inner">
            @include('elements.alerts')
            <h2 class="page-title">Verification Codes</h2>
            <div class="content-widget row no-gutters">
                <div class="w-100">
                    <table class="table table-bordered" id="user_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Code</th>
                                <th>Company Name</th>
                                <th>Country</th>
                                <th>Referral Code</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->verify_code }}</td>
                                    <td>{{ $item->company }}</td>
                                    <td>
                                        {{ $item->Country ? $item->Country->name : '' }}
                                    </td>
                                    <td>{{ $item->referral_code }}</td>
                                    <td data-sort="{{ $item->created_at->format('Y-m-d') }}">
                                        {{ $item->created_at->format('F j, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('view_script')
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#user_table').DataTable({
            "order": [[ 6, "desc" ]],
        });
    });
</script>
@endsection
