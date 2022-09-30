@extends('admin.layout')
@section('content')
    @php
        $type = request()->input('type');
    @endphp
    <div class="page-header">
        <h4 class="page-title">Add Product</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
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
                <a href="#">Add Product</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Add Product</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.product.index') . '?language=' . request()->input('language')}}">
                    <span class="btn-label">
                        <i class="fas fa-backward" style="font-size: 12px;"></i>
                    </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5" id="create_content">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
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
                            <form id="ajaxForm" class="" action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="type" value="{{request()->input('type')}}">

                                @if (!empty($langs))
                                    <div class="tab-content">
                                        @foreach ($langs as $lang)
                                            <div class="tab-pane container {{$lang->code == request()->input('language') ? 'active' : ''}}" id="create-lang-{{$lang->code}}">

                                                {{-- START: Featured Image --}}
                                                <div class="form-group">
                                                    <label for="">Featured Image ** </label>
                                                    <br>
                                                    <div class="thumb-preview" id="thumbPreview1{{$lang->id}}">
                                                        <label for="chooseImage1{{$lang->id}}"> <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="Feature Image"></label>
                                                    </div>
                                                    <br>
                                                    <br>


                                                    <input id="fileInput1{{$lang->id}}" type="hidden" name="featured_image_{{$lang->code}}">
                                                    <button id="chooseImage1{{$lang->id}}" class="choose-image btn btn-primary" type="button" data-multiple="false"
                                                            data-toggle="modal" data-target="#lfmModal1{{$lang->id}}">Choose Image
                                                    </button>


                                                    <p class="text-warning mb-0">JPG, PNG, JPEG images are allowed</p>
                                                    <p id="errfeatured_image_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                    <!-- Featured Image LFM Modal -->
                                                    <div class="modal fade lfm-modal" id="lfmModal1{{$lang->id}}" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
                                                        <i class="fas fa-times-circle"></i>
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <iframe src="{{url('laravel-filemanager')}}?serial=1{{$lang->id}}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- END: Featured Image --}}


                                                {{-- START: slider Part --}}
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Slider Images ** </label>
                                                            <br>
                                                            <div class="slider-thumbs" id="sliderThumbs2{{$lang->id}}">

                                                            </div>

                                                            <input id="fileInput2{{$lang->id}}" type="hidden" name="slider_{{$lang->code}}" value=""/>
                                                            <button id="chooseImage2{{$lang->id}}" class="choose-image btn btn-primary" type="button" data-multiple="true"
                                                                    data-toggle="modal" data-target="#lfmModal2{{$lang->id}}">Choose Images
                                                            </button>


                                                            <p class="text-warning mb-0">JPG, PNG, JPEG images are allowed</p>
                                                            <p id="errslider_{{$lang->code}}" class="mb-0 text-danger em"></p>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- slider LFM Modal -->
                                                <div class="modal fade lfm-modal" id="lfmModal2{{$lang->id}}" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
                                                    <i class="fas fa-times-circle"></i>
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <iframe id="lfmIframe2{{$lang->id}}" src="{{url('laravel-filemanager')}}?serial=2{{$lang->id}}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- END: slider Part --}}

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Status **</label>
                                                            <select class="form-control ltr" name="status_{{$lang->code}}">
                                                                <option value="" selected disabled>Select a status</option>
                                                                <option value="1">Show</option>
                                                                <option value="0">Hide</option>
                                                            </select>
                                                            <p id="errstatus_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="">Title **</label>
                                                            <input type="text" class="form-control" name="title_{{$lang->code}}" value="" placeholder="Enter title">
                                                            <p id="errtitle_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="category">Category **</label>
                                                            <select class="form-control categoryData" name="category_id_{{$lang->code}}" id="category">
                                                                <option value="" selected disabled>Select a category</option>
                                                                @foreach ($categories[$lang->code] as $categroy)
                                                                    <option value="{{$categroy->id}}">{{$categroy->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <p id="errcategory_id_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        @if ($type == 'physical')
                                                            <div class="form-group">
                                                                <label for="">Stock Product **</label>
                                                                <input type="number" class="form-control ltr" name="stock_{{$lang->code}}" value=""
                                                                       placeholder="Enter Product Stock">
                                                                <p id="errstock_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                        @endif
                                                        @if ($type == 'digital')
                                                            <div class="form-group">
                                                                <label for="">Type **</label>
                                                                <select name="file_type_{{$lang->code}}" class="form-control" id="fileType_{{$lang->code}}">
                                                                    <option value="upload" selected>File Upload</option>
                                                                    <option value="link">File Download Link</option>
                                                                </select>
                                                                <p id="errfile_type_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($type == 'digital')
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div id="downloadFile_{{$lang->code}}" class="form-group">
                                                                <label for="">Downloadable File **</label>
                                                                <br>
                                                                <input name="download_file_{{$lang->code}}" type="file">
                                                                <p class="mb-0 text-warning">Only zip file is allowed.</p>
                                                                <p id="errdownload_file_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                            <div id="downloadLink_{{$lang->code}}" class="form-group" style="display: none">
                                                                <label for="">Downloadable Link **</label>
                                                                <input name="download_link_{{$lang->code}}" type="text" class="form-control">
                                                                <p id="errdownload_link_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    @if ($type == 'physical')
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for=""> Product Sku **</label>
                                                                <input type="text" class="form-control" name="sku_{{$lang->code}}" value="{{rand(1000000,9999999)}}"
                                                                       placeholder="Enter Product sku">
                                                                <p id="errsku_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="{{$type == 'physical' ? 'col-lg-6' : 'col-12'}}">
                                                        <div class="form-group">
                                                            <label for="">Tags </label>
                                                            <input type="text" class="form-control" name="tags_{{$lang->code}}" value="" data-role="tagsinput"
                                                                   placeholder="Enter tags">
                                                            <p id="errtags_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($bex->catalog_mode == 0)
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for=""> Current Price (in {{$abx->base_currency_text}}) **</label>
                                                                <input type="number" class="form-control ltr" name="current_price_{{$lang->code}}" value=""
                                                                       placeholder="Enter Current Price">
                                                                <p id="errcurrent_price_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">Previous Price (in {{$abx->base_currency_text}})</label>
                                                                <input type="number" class="form-control ltr" name="previous_price_{{$lang->code}}" value=""
                                                                       placeholder="Enter Previous Price">
                                                                <p id="errprevious_price_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="summary">Summary </label>
                                                            <textarea name="summary_{{$lang->code}}" id="summary_{{$lang->code}}" class="form-control" rows="4"
                                                                      placeholder="Enter Product Summary"></textarea>
                                                            <p id="errsummary_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="">Description </label>
                                                            <textarea class="form-control summernote" name="description_{{$lang->code}}" placeholder="Enter description"
                                                                      data-height="300"></textarea>
                                                            <p id="errdescription_{{$lang->code}}" class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Meta Keywords</label>
                                                            <input class="form-control" name="meta_keywords_{{$lang->code}}" value="" placeholder="Enter meta keywords"
                                                                   data-role="tagsinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Meta Description</label>
                                                            <textarea class="form-control" name="meta_description_{{$lang->code}}" rows="5"
                                                                      placeholder="Enter meta description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    @if($type == 'digital')
        <script>
            $(document).ready(function() {
                @foreach ($langs as $lang)
                $("select[name='file_type_{{$lang->code}}']").on('change', function() {
                    let type = $(this).val();
                    if (type == 'link') {
                        $("#downloadFile_{{$lang->code}} input").attr('disabled', true);
                        $("#downloadFile_{{$lang->code}}").hide();
                        $("#downloadLink_{{$lang->code}}").show();
                        $("#downloadLink_{{$lang->code}} input").removeAttr('disabled');
                    } else {
                        $("#downloadLink_{{$lang->code}} input").attr('disabled', true);
                        $("#downloadLink_{{$lang->code}}").hide();
                        $("#downloadFile_{{$lang->code}}").show();
                        $("#downloadFile_{{$lang->code}} input").removeAttr('disabled');
                    }
                });
                @endforeach
            });
        </script>
    @endif


    <script>
        $(document).ready(function() {
            // services load according to language selection
            $("select[name='language_id']").on('change', function() {

                $("#category").removeAttr('disabled');

                let langid = $(this).val();
                let url = "{{url('/')}}/admin/product/" + langid + "/getcategory";
                // console.log(url);
                $.get(url, function(data) {
                    // console.log(data);
                    let options = `<option value="" disabled selected>Select a category</option>`;
                    for (let i = 0; i < data.length; i++) {
                        options += `<option value="${data[i].id}">${data[i].name}</option>`;
                    }

                    $(".categoryData").html(options);

                });
            });


            $("select[name='language_id']").on('change', function() {
                $(".request-loader").addClass("show");
                let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
                console.log(url);
                $.get(url, function(data) {
                    $(".request-loader").removeClass("show");
                    if (data == 1) {
                        $("form input").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form select").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form textarea").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form .summernote").each(function() {
                            $(this).siblings('.note-editor').find('.note-editable').addClass('rtl text-right');
                        });
                    } else {
                        $("form input, form select, form textarea").removeClass('rtl');
                        $("form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
                    }
                })
            });

            // translatable portfolios will be available if the selected language is not 'Default'
            $("#language").on('change', function() {
                let language = $(this).val();
                // console.log(language);
                if (language == 0) {
                    $("#translatable").attr('disabled', true);
                } else {
                    $("#translatable").removeAttr('disabled');
                }
            });
        });

        var today = new Date();
        $("#submissionDate").datepicker({
            autoclose: true,
            endDate : today,
            todayHighlight: true
        });
        $("#startDate").datepicker({
            autoclose: true,
            endDate : today,
            todayHighlight: true
        });
    </script>
@endsection
