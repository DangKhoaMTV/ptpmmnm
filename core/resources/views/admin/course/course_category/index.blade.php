@extends('admin.layout')

@php
    $selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp

@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
    <style>
        form:not(.modal-form) input,
        form:not(.modal-form) textarea,
        form:not(.modal-form) select,
        select[name='language'] {
            direction: rtl;
        }

        form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
            direction: rtl;
            text-align: right;
        }
    </style>
@endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Course Categories</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('admin.dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Courses</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Categories</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Categories</div>
                        </div>

                        <div class="col-lg-3">
                            @if (!empty($langs))
                                <select
                                    name="language"
                                    class="form-control"
                                    onchange="window.location='{{url()->current() . '?language='}}'+this.value"
                                >
                                    <option
                                        value=""
                                        selected
                                        disabled
                                    >Select a Language
                                    </option>
                                    @foreach ($langs as $lang)
                                        <option
                                            value="{{$lang->code}}"
                                            {{$lang->code == request()->input('language') ? 'selected' : ''}}
                                        >{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal" ><i class="fas fa-plus"></i> Add Category</a>

                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.course_category.bulk_delete')}}"><i class="flaticon-interface-5"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($course_categories) == 0)
                                <h3 class="text-center">NO COURSE CATEGORY FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($course_categories as $course_category)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check" data-val="{{$course_category->id}}">
                                                </td>
                                                <td>{{convertUtf8($course_category->name)}}</td>
                                                <td>
                                                    @if ($course_category->status == 1)
                                                        <h2 class="d-inline-block"><span class="badge badge-success">Active</span>
                                                        </h2>
                                                    @else
                                                        <h2 class="d-inline-block"><span class="badge badge-danger">Deactive</span>
                                                        </h2>
                                                    @endif
                                                </td>
                                                <td>{{$course_category->serial_number}}</td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm editbtn_url"
                                                        href="#editModal"
                                                        data-url="{{route('admin.course_category.edit', $course_category->id). '?language=' . request()->input('language')}}"
                                                        data-toggle="modal"
                                                        data-course_category_id="{{$course_category->id}}"
                                                        data-name="{{$course_category->name}}"
                                                        data-status="{{$course_category->status}}"
                                                        data-serial_number="{{$course_category->serial_number}}">
                        <span class="btn-label">
                          <i class="fas fa-edit"></i>
                        </span>
                                                        Edit
                                                    </a>

                                                    <form class="deleteform d-inline-block" action="{{route('admin.course_category.delete')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="course_category_id" value="{{$course_category->id}}">
                                                        <button type="submit" class="btn btn-danger btn-sm deletebtn">
                          <span class="btn-label">
                            <i class="fas fa-trash"></i>
                          </span>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="d-inline-block mx-auto">
                            {{$course_categories->appends(['language' => request()->input('language')])->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Course Category Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Course Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @if (!empty($langs))
                        <ul class="nav nav-tabs">
                            @foreach ($langs as $lang)
                                <li class="nav-item">
                                    <a class="nav-link {{$lang->code == request()->input('language') ? 'active' : ''}}" data-toggle="tab"
                                       href="#create-lang-{{$lang->code}}">{{$lang->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <form id="ajaxForm" class="modal-form create" action="{{route('admin.course_category.store')}}" method="POST">
                        @csrf
                        @if (!empty($langs))
                            <div class="tab-content">
                                @foreach ($langs as $lang)
                                    <div class="tab-pane container {{$lang->code == request()->input('language') ? 'active' : ''}}" id="create-lang-{{$lang->code}}">

                                    <div class="form-group">
                                        <label for="">Name **</label>
                                        <input type="text" class="form-control" name="name_{{$lang->code}}" value="" placeholder="Enter Name">
                                        <p id="errname_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Status **</label>
                                        <select class="form-control ltr" name="status_{{$lang->code}}">
                                            <option value="" selected disabled >Select a status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                        <p id="errstatus_{{$lang->code}}" class="mb-0 text-danger em" ></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Serial Number **</label>
                                        <input type="number" class="form-control ltr" name="serial_number_{{$lang->code}}" value=""
                                            placeholder="Enter Serial Number">
                                        <p id="errserial_number_{{$lang->code}}" class="mb-0 text-danger em" ></p>
                                        <p class="text-warning"><small>The higher the serial number is, the later the course
                                                category will be shown.</small></p>
                                    </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button id="submitBtn" type="button" class="btn btn-primary" >Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Course Category Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" >Edit Course Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Loading...</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                    <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // make input fields RTL
            $("select[name='language_id']").on('change', function () {
                $(".request-loader").addClass("show");
                let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
                // console.log(url);
                $.get(url, function (data) {
                    $(".request-loader").removeClass("show");
                    if (data == 1) {
                        $("form.create input").each(function () {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form.create select").each(function () {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form.create textarea").each(function () {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form.create .summernote").each(function () {
                            $(this).addClass('rtl text-right');
                        });
                    } else {
                        $("form.create input, form.create select, form.create textarea").removeClass('rtl');
                        $("form.create .summernote").removeClass('rtl text-right');
                    }
                })
            });
        });
    </script>
@endsection
