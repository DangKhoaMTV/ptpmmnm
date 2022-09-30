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
    <h4 class="page-title">Product Categories</h4>
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
        <a href="#">Shop Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Manage Products</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Category</a>
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
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Category</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.pcategory.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($pcategories) == 0)
                <h3 class="text-center">NO PRODUCT CATEGORY FOUND</h3>
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
                        <th scope="col">Menu_parent</th>
                        @if ($be->theme_version == 'ecommerce')
                        <th scope="col">Featured</th>
                        <th scope="col">Products in Home</th>
                        @endif
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($pcategories as $key => $category)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$category->id}}">
                          </td>

                          <td>{{convertUtf8($category->name)}}</td>

                          <td>
                            @if ($category->status == 1)
                              <h2 class="d-inline-block"><span class="badge badge-success">Active</span></h2>
                            @else
                              <h2 class="d-inline-block"><span class="badge badge-danger">Deactive</span></h2>
                            @endif
                          </td>
                          <td>
                            @if (!empty($category->parent))
                            {{convertUtf8($category->parent ? $category->parent->name : '')}}
                            @endif
                          </td>

                          @if ($be->theme_version == 'ecommerce')
                          <td>
                            <form class="d-inline-block" action="{{route('admin.category.feature')}}" id="featureForm{{$category->id}}" method="POST">
                              @csrf
                              <input type="hidden" name="category_id" value="{{$category->id}}">
                              <select name="is_feature" id="" class="form-control form-control-sm
                              @if($category->is_feature == 1)
                              bg-success
                              @else
                              bg-danger
                              @endif
                              " onchange="document.getElementById('featureForm{{$category->id}}').submit();">
                                <option value="1" {{$category->is_feature == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0"  {{$category->is_feature == 0 ? 'selected' : ''}}>No</option>
                              </select>
                            </form>
                          </td>
                          @endif

                          @if ($be->theme_version == 'ecommerce')
                          <td>
                            <form class="d-inline-block" action="{{route('admin.category.home')}}" id="homeForm{{$category->id}}" method="POST">
                              @csrf
                              <input type="hidden" name="category_id" value="{{$category->id}}">
                              <select name="products_in_home" id="" class="form-control form-control-sm
                              @if($category->products_in_home == 1)
                              bg-success
                              @else
                              bg-danger
                              @endif
                              " onchange="document.getElementById('homeForm{{$category->id}}').submit();">
                                <option value="1" {{$category->products_in_home == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0"  {{$category->products_in_home == 0 ? 'selected' : ''}}>No</option>
                              </select>
                            </form>
                          </td>
                          @endif

                          <td>
                            <a class="btn btn-secondary btn-sm editbtn_url" href="{{route('admin.category.edit', $category->id) . '?language=' . request()->input('language')}}" data-url="{{route('admin.category.edit', $category->id) . '?language=' . request()->input('language') . ' #edit_content'}}" data-toggle="modal" data-target="#editModal">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.category.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="category_id" value="{{$category->id}}">
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
              {{$pcategories->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Product Category Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Product Category</h5>
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
          <form id="ajaxForm" class="modal-form" action="{{route('admin.category.store')}}" method="POST">
            @csrf
              @if (!empty($langs))
                  <div class="tab-content">
                      @foreach ($langs as $lang)
                          <div class="tab-pane container {{$lang->code == request()->input('language') ? 'active' : ''}}" id="create-lang-{{$lang->code}}">

                    @if ($be->theme_version == 'ecommerce')
                    <div class="form-group">
                      <label for="">Image  </label>
                      <br>
                      <div class="thumb-preview" id="thumbPreview1{{$lang->id}}">
                        <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="User Image">
                      </div>
                      <br>
                      <br>

                      <input id="fileInput1{{$lang->id}}" type="hidden" name="image_{{$lang->code}}">
                      <button id="chooseImage1{{$lang->id}}" class="choose-image btn btn-primary" type="button" data-multiple="false"
                        data-toggle="modal" data-target="#lfmModal1{{$lang->id}}">Choose Image</button>
                      <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                      <p class="em text-danger mb-0" id="errimage_{{$lang->code}}"></p>
                    </div>
                    @endif

                    <div class="form-group">
                      <label for="">Name **</label>
                      <input type="text" class="form-control" name="name_{{$lang->code}}" value="" placeholder="Enter name">
                      <p id="errname_{{$lang->code}}" class="mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                      <label for="">Status **</label>
                      <select class="form-control ltr" name="status_{{$lang->code}}">
                        <option value="" selected disabled>Select a status</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                      </select>
                      <p id="errstatus_{{$lang->code}}" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                      <label for="category">Menu_child</label>
                      <select class="form-control parentData" name="parent_id_{{$lang->code}}" id="category">
                          <option value="" selected disabled>Select a category</option>
                          @foreach ($categories[$lang->code] as $categroy)
                              <option data-assoc_id="{{$categroy->assoc_id}}" value="{{$categroy->id}}">{{$categroy->name}}</option>
                          @endforeach
                      </select>
                      {{-- <p id="errparent_id_{{$lang->code}}" class="mb-0 text-danger em"></p> --}}
                  </div>
                          </div>
                    @endforeach
                  </div>
              @endif
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Product Category Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Product Category</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Loading...</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
              </div>
          </div>
      </div>
  </div>

  @foreach ($langs as $lang)
      <!-- Image LFM Modal -->
      <div class="modal fade lfm-modal" id="lfmModal1{{$lang->id}}" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
        aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <iframe src="{{url('laravel-filemanager')}}?serial=1{{$lang->id}}"
                style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
          </div>
        </div>
      </div>
      <!-- Image LFM Modal -->
      <div class="modal fade lfm-modal" id="lfmModal{{$lang->id}}1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
        aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <iframe src="{{url('laravel-filemanager')}}?serial={{$lang->id}}1"
                style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
          </div>
        </div>
      </div>
  @endforeach
@endsection

@section('scripts')
<script>

$(document).ready(function() {

    // make input fields RTL
    $("select[name='language_id']").on('change', function() {
      $("#category").removeAttr('disabled');

        $(".request-loader").addClass("show");
        let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
        console.log(url);
        $.get(url, function (data) {
                // console.log(data);
                let options = `<option value="" disabled selected>Select a category</option>`;
                for (let i = 0; i < data.length; i++) {
                    options += `<option value="${data[i].id}">${data[i].name}</option>`;
                }

                $(".parentData").html(options);

            })
        $.get(url, function(data) {
            $(".request-loader").removeClass("show");
            if (data == 1) {
                $("form.modal-form input").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form select").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form textarea").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form .nicEdit-main").each(function() {
                    $(this).addClass('rtl text-right');
                });

            } else {
                $("form.modal-form input, form.modal-form select, form.modal-form textarea").removeClass('rtl');
                $("form.modal-form .nicEdit-main").removeClass('rtl text-right');
            }
        })
    });
});
</script>
@endsection
