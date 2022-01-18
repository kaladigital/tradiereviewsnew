@extends('layouts.master')
@section('view_css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'users'])
    <div class="col-md-auto col-12 content-wrap">
        <div class="content-inner">
            @include('elements.alerts')
            <h2 class="page-title">Users</h2>
            <div class="content-widget row no-gutters">
                <div class="w-100">
                    <table class="table table-bordered table-responsive" id="user_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company Name</th>
                                <th>Website</th>
                                <th>Subscription</th>
                                <th>IP</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot style=" display: table-header-group;">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($users as $item)
                                <tr class="user_row_item" data-id="{{ $item->user_id }}">
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->reviews_company_name }}</td>
                                    <td>{{ $item->website_url }}</td>
                                    <td>
                                        {{ $item->current_subscription_name ?? 'Expired' }}
                                    </td>
                                    <td>{{ $item->ip }}</td>
                                    <td data-sort="{{ $item->created_at->format('Y-m-d') }}">{{ $item->created_at->format('F j, Y') }}</td>
                                    <td>
                                        <a href="/admin/impersonate/{{ $item->user_id }}" class="btn btn--round btn-primary">Impersonate</a>
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
            "order": [[ 5, "desc" ]],
            initComplete: function () {
                this.api().columns(4).every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });

        $(document).on('change','#user_subscription',function(e){
            e.preventDefault();
            console.log('changed')
            return false;
        });
    });
</script>
@endsection
