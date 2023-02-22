@extends('admin.layouts.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item"><a href="#">基本資訊</a></li>
        <li class="breadcrumb-item active" aria-current="page">職等</li>
    </ol>
</nav>


<a class="btn btn-success mb-2" onclick="showAdd();">
    新增職等
<i class="fa fa-plus"></i> </a>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{$pageTitle}}</h4>
                <p class="text-muted mb-3">將會依據職等別設定不同職能</p>
                <div class="table-responsive">
                <table id="gradeTable" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>職等</th>
                        <th>職等名稱</th>
                        <th>職位類別</th>
                        <th>員工數量</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{--MODALS--}}

<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><strong><i class="fa fa-plus"></i> New Grade</strong></h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">

                 <!-- BEGIN FORM-->

                 <!-- END FORM-->
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>

{{------------------------END EDIT MODALS---------------------}}

{{--DELETE MODAL CALLING--}}
@include('admin.include.delete-modal')
@include('include.show-modal')
{{--DELETE MODAL CALLING END--}}
@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
@endpush

@section('footerjs')

 <script type="text/javascript">
const ADD_MORE_INPUT_HTML = `
    <div class="form-group">
        <div class="mb-3">
            <div class="designation-container">
                <input class="form-control input-medium designation"
                    id="designation_%NUM%"
                    name="designation[%NUM%]"
                    type="text"
                    placeholder="{{trans('core.designation')}} #%NUM_PLACEHOLDER%"
                    data-autocomplete-url="{{ route('member.grades.designation') }}?current=%CURRENT%"
                />

                <div class="autocomplete-container"></div>
            </div>
        </div>
    </div>
`;

function addMore(isEdit = false) {
  const insertBefore = isEdit ? document.querySelector('#insertBefore_edit') : document.querySelector('#insertBefore');
  const numDesignations = document.querySelectorAll('input[name^="designation"]').length;
  const lastDesignation = $('input[name^="designation"]').last().val();
  const inputHTML = ADD_MORE_INPUT_HTML
      .replace(/%NUM%/g, numDesignations)
      .replace('%NUM_PLACEHOLDER%', numDesignations + 1)
      .replace('%CURRENT%', encodeURIComponent(lastDesignation));
  insertBefore.insertAdjacentHTML('beforebegin', inputHTML);
}

$(document).on('input', '.designation', function() {
  var url = $(this).data('autocomplete-url');
  var keyword = $(this).val();
  if (keyword.length >= 3) {
    var $container = $(this).closest('.designation-container').find('.autocomplete-container');
    $.ajax({
      url: url.replace('%CURRENT%', encodeURIComponent($(this).val())),
      type: 'GET',
      data: { keyword: keyword },
      success: function(data) {
        var list = $('<ul class="autocomplete-list"></ul>');
        $.each(data, function(key, value) {
          var item = $('<li class="autocomplete-item"></li>');
          item.text(value);
          item.click(function() {
            $container.siblings('.designation').val(value);
            $container.empty();
          });
          list.append(item);
        });
        $container.empty().append(list);
      }
    });
  } else {
    $(this).closest('.designation-container').find('.autocomplete-container').empty();

  }
});

$(document).on('click', '.autocomplete-item', function() {
  var value = $(this).text();
  var designationValue = $('input[name^="designation"]:visible').filter(function() {
    return this.value === '';
  });
  designationValue.val(value);
  $(this).closest('.autocomplete-container').empty();
});




    // 表格選項
    var tableData = $('#gradeTable').dataTable({
    processing: true,
    serverSide: true,
    "ajax":{
        "url": "{{ URL::route("member.grades.ajax_grade") }}"
    },
    "autoWidth": false,
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'grade',name:'grade'},
        { data: 'designation',name:'designation'},
        { data: 'competency',name:'competency'},
        { data: 'employees',name:'employees'},
        { data: 'action'}
    ],
    columnDefs: [
        {
            searchable: false,
            orderable: false,
            targets: 0,
        },
    ],
    order: [[1, 'asc']],
    "lengthMenu": [
        [5, 15, 20, -1],
        [5, 15, 20, "All"] // change per page values here
    ],
    // set the initial value
    "pageLength": 5,
    "sPaginationType": "full_numbers",
    "columnDefs": [{  // set default column settings
        'orderable': false,
        'targets': [0]
    }
    ],
    "fnInitComplete": function () {
        $(".dataTables_length").addClass("hidden-xs");
        $(this).removeClass("hidden");
    },
});

// Show Delete Modal
// 監聽刪除按鈕的點擊事件
$('#gradeTable').on('click', '.delete', function (event) {
    event.preventDefault();
    var id = $(this).data('id');
    var dept = $(this).data('dept');
    $('#deleteModal').modal('show');
    $("#deleteModal").find('#info').html('Are you sure ! You want to delete <strong>'+dept+'</strong> grade?<br>' +
            '<br><div class="note note-warning">' +
            '{!! Lang::get('messages.deleteNoteGrade') !!}'+
            '</div>');
    $('#deleteModal').find("#delete").off().click(function () {
        var url = "{{ route('member.grades.destroy',':id') }}";
        url = url.replace(':id',id);
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            type: 'DELETE',
            url: url,
            data: {'_token': token},
            container: "#deleteModal",
            success: function (response) {
                if (response.status == "success") {
                    $('#deleteModal').modal('hide');
                     // 重新載入目前頁面的資料
                     var currentPage = tableData.api().page();
                    tableData.api().ajax.reload(null, false);
                    tableData.api().page(currentPage).draw(false);
                }
            }
        });
    });
});

    // Javascript function to update the company info and Bank Info
    function storeGrades() {
        const form = document.querySelector('#add_grade_form');
        const url = "{{ route('member.grades.store') }}";

        fetch(url, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new URLSearchParams(new FormData(form))
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
            $('#showModal').modal('hide');
            tableData.ajax.reload(null, false);
            } else {
            // handle error response
            }
        })
        .catch(error => {
            // handle request error
        });
    }

    // Show Create Grade Modal
    function showAdd() {
        var url = "{{ route('member.grades.create') }}";
        $.ajaxModal('#showModal', url);
    }
    // Show Edit Depart Modal
    function showEdit(id) {
        var url = "{{ route('member.grades.edit',[':id']) }}";
        url = url.replace(':id', id);
        $.ajaxModal('#showModal', url);
    }

        // Javascript function to update the company info and Bank Info
    function UpdateGrades(id){

        var url = "{{ route('member.grades.update',':id') }}";
        url = url.replace(':id',id);
        $.easyAjax({
            type: 'POST',
            url: url,
            container: '#edit_grade_form',
            data: $('#edit_grade_form').serialize(),
            success: function () {
                $('#showModal').modal('hide');
                tableData.fnDraw();
            }
        });
    }



    </script>


@endsection
