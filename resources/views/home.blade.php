@extends('layouts.app')

@section('content')
<div class="container m-5 p-2 rounded mx-auto bg-light shadow">
    <!-- App title section -->
    <div class="row m-1 p-4">
        <div class="col">
            <div class="p-1 h1 text-primary text-center mx-auto display-inline-block">
                <i class="fa fa-check bg-primary text-white rounded p-2"></i>
                <u>My Todo-s</u>
            </div>
        </div>
    </div>
    <!-- Create todo section -->
    <div class="row m-1 p-3">
        <div class="col col-11 mx-auto">

             <div class="alert alert-danger print-contacterror-msg" style="display:none">
                                    <ul></ul>
                            </div>
                            <div class="alert alert-success print-success-msg" style="display:none">
                                    <ul></ul>
                            </div>
            <form>                  
                {{ csrf_field() }}
            <div class="row bg-white rounded shadow-sm p-2 add-todo-wrapper align-items-center justify-content-center">
                <div class="col">
                    <input class="form-control form-control-lg border-0 add-todo-input bg-transparent rounded" type="text"  name="title" value="{{old('title')}}" placeholder="Add new .." required="">
                </div>
                <div class="col-auto m-0 px-2 d-flex align-items-center">
                    <label class="text-secondary my-2 p-0 px-1 view-opt-label due-date-label d-none">Due date not set</label>
                    <i class="fa fa-calendar my-2 px-1 text-primary btn due-date-button" data-toggle="tooltip" data-placement="bottom" title="Set a Due date"></i>
                    <i class="fa fa-calendar-times-o my-2 px-1 text-danger btn clear-due-date-button d-none" data-toggle="tooltip" data-placement="bottom" title="Clear Due date"></i>
                </div>
                <div class="col-auto px-0 mx-0 mr-2">
                    <button type="button" class="btn btn-primary btn-submit">Add</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="p-2 mx-4 border-black-25 border-bottom"></div>
    <!-- View options section -->
    <div class="row m-1 p-3 px-5 justify-content-end">
        <div class="col-auto d-flex align-items-center">
            <label class="text-secondary my-2 pr-2 view-opt-label">Filter</label>
            <select id="sortBy" class="custom-select custom-select-sm btn my-2">
                <option value="all" {{Request::getQueryString() == 'sort=all' ? 'selected' :'' }}>All</option>
                <option value="completed" {{Request::getQueryString() == 'sort=completed' ? 'selected' :'' }}>Completed</option>
                <option value="active" {{Request::getQueryString() == 'sort=active' ? 'selected' :'' }}>Active</option>

            </select>
        </div>
        <div class="col-auto d-flex align-items-center px-1 pr-3">
            <label class="text-secondary my-2 pr-2 view-opt-label">Sort</label>
            <select id="filter" class="custom-select custom-select-sm btn my-2">
                <option value="today" {{Request::getQueryString() == 'filter=today' ? 'selected' :'' }}>Today</option>
                <option value="lastweek" {{Request::getQueryString() == 'filter=lastweek' ? 'selected' :'' }}>Last Week</option>
                <option value="lastmonth" {{Request::getQueryString() == 'filter=lastmonth' ? 'selected' :'' }}>Last Month</option>
                <option value="lastthreemonth" {{Request::getQueryString() == 'filter=lastthreemonth' ? 'selected' :'' }}>3 Month Ago</option>
            </select>
            <i class="fa fa fa-sort-amount-asc text-info btn mx-0 px-0 pl-1" data-toggle="tooltip" data-placement="bottom" title="Ascending"></i>
            <i class="fa fa fa-sort-amount-desc text-info btn mx-0 px-0 pl-1 d-none" data-toggle="tooltip" data-placement="bottom" title="Descending"></i>
        </div>
    </div>
    <!-- Todo list section -->
    <div class="row mx-1 px-5 pb-3 w-80">
        <div class="col mx-auto append_todo">
            @foreach($todos as $key => $value)
            <input type="hidden" name="id" value="{{$value->id}}">
            <div class="row px-3 align-items-center todo-item rounded">
                <div class="col-auto m-1 p-0 d-flex align-items-center">
                    <h2 class="m-0 p-0 check_sq">
                        @if($value->status == 'pending')
                        <i class="fa fa-square-o text-primary btn m-0 p-0 todo-update" data-toggle="tooltip" data-placement="bottom" title="Mark as complete" data-href="{{ route('todo-update', $value->id)}}"></i>
                        @else
                        <i class="fa fa-check-square-o text-primary btn m-0 p-0" data-toggle="tooltip" data-placement="bottom" title="Mark as todo"></i>
                        
                        @endif
                    </h2>
                </div>
                <div class="col px-1 m-1 d-flex align-items-center">
                    <input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded px-3" readonly value="{{$value->title}}" title="{{$value->title}}" />
                    <input type="text" class="form-control form-control-lg border-0 edit-todo-input rounded px-3 d-none" value="{{$value->title}}" />
                </div>
                
                <div class="col-auto m-1 p-0 todo-actions">
                    <div class="row d-flex align-items-center justify-content-end">
                        <h5 class="m-0 p-0 px-2">
<!--                             <i class="fa fa-pencil text-info btn m-0 p-0" data-toggle="tooltip" data-placement="bottom" title="Edit todo"></i>
 -->                        </h5>
                        <h5 class="m-0 p-0 px-2">
                            <i class="fa fa-trash-o text-danger btn m-0 p-0 todo-remove" data-toggle="tooltip" data-placement="bottom" title="Delete todo" data-href="{{ route('todo-remove', $value->id)}}"></i>
                        </h5>
                    </div>
                    <div class="row todo-created-info">
                        <div class="col-auto d-flex align-items-center pr-2">
                            <i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Created date"></i>
                            <label class="date-label my-2 text-black-50">{{date('D M d Y', strtotime($value->created_at))}}</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">  
    $(document).ready(function() {
          $(".btn-submit").click(function(e){
            e.preventDefault();
       
            var _token = $("input[name='_token']").val();
            var title = $("input[name='title']").val();

            $.ajax({
                url: "{{ route('storeTodo') }}",
                type:'POST',
                dataType : 'json',
                data: {_token:_token, title:title},
                success: function(data) {
                    var url = '{{ route("todo-remove") }}'+"/"+data['id'];
                    var url2= '{{ route("todo-update")}}'+"/"+data['id'];
                    if ((data.errors)) {
                        printContactErrorMsg(data.errors);
                    }else{
                     date = new Date(data['created_at']);
                         $("input[name='title']").val('');
                        $(".print-contacterror-msg").css('display','none');
                        $('.append_todo').append('<div class="row px-3 align-items-center todo-item rounded"> <div class="col-auto m-1 p-0 d-flex align-items-center"><h2 class="m-0 p-0"><i class="fa fa-square-o text-primary btn m-0 p-0 todo-update" data-toggle="tooltip" data-placement="bottom" title="Mark as complete" data-href="'+url2+'" ></i><i class="fa fa-check-square-o text-primary btn m-0 p-0 d-none" data-toggle="tooltip" data-placement="bottom" title="Mark as todo"></i></h2></div><div class="col px-1 m-1 d-flex align-items-center"><input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded px-3" readonly value="'+data['title']+'" title="'+data['title']+'" /><input type="text" class="form-control form-control-lg border-0 edit-todo-input rounded px-3 d-none" value="'+data['title']+'" /></div> <div class="col-auto m-1 p-0 todo-actions"><div class="row d-flex align-items-center justify-content-end"><h5 class="m-0 p-0 px-2"></h5><h5 class="m-0 p-0 px-2"><i class="fa fa-trash-o text-danger btn m-0 p-0 todo-remove" data-toggle="tooltip" data-placement="bottom" title="Delete todo" data-href="'+url+'"></i></h5></div><div class="row todo-created-info"><div class="col-auto d-flex align-items-center pr-2"><i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Created date"></i><label class="date-label my-2 text-black-50">'+date.toDateString()+'</label></div></div></div></div>');    

                         printSuccessMsg(['Your point addedd successfully']);   
                     }
                },
                error: function (data) {
                  toastr.error("@lang('main.error')");                

                }
            });
       
        }); 
        function printContactErrorMsg (msg) {
            $(".print-contacterror-msg").find("ul").html('');
            $(".print-contacterror-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-contacterror-msg").find("ul").append('<li>'+value+'</li>');
            });
        }


      $(document).on('click', '.todo-remove', function(){
          $(this).parent().parent().parent().parent().remove();
          $.get( $(this).data('href') , function( data ) {
              $('#todo-count').html(data[1]);
              printSuccessMsg(data);
          });
      });


      $(document).on('click', '.todo-update', function(){
          $.get( $(this).data('href') , function( data ) {

              printSuccessMsg(['Your point is finished successfully']);
          });
          $(this).removeClass('fa-square-o');
          $(this).addClass('fa-check-square-o');
          $(this).next().next().next( "input" ).addClass('change-decoration');

      });


function printSuccessMsg (msg) {
            $(".print-success-msg").find("ul").html('');
            $(".print-success-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-success-msg").find("ul").append('<li>'+value+'</li>');
            });
        }


    });
 $('#sortBy').change(function () {
            var sort= $(this).val();

            window.location="{{url('/home')}}?sort="+sort;
        });

  $('#filter').change(function () {
            var filter= $(this).val();

            window.location="{{url('/home')}}?filter="+filter;
        });
</script>
@endpush