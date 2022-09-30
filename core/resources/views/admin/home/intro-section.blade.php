@extends('admin.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select,
    select {
        direction: rtl;
    }
    form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Intro Section</h4>
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
        <a href="#">Home Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Intro Section</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Update Intro Section</div>
                </div>
                <div class="col-lg-2">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if (!empty($langs))
                    <ul class="nav nav-tabs">
                        @foreach ($langs as $lang)
                            <li class="nav-item">
                                <a class="nav-link {{$lang->code == request()->input('language') ? 'active' : ''}}" data-toggle="tab" href="#create-lang-{{$lang->code}}">{{$lang->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
              <form id="ajaxForm" action="{{route('admin.introsection.update', $lang_id)}}" method="post">
                @csrf
                  @if (!empty($langs))
                      <div class="tab-content">
                          @foreach ($langs as $lang)
                              <div class="tab-pane container {{$lang->code == request()->input('language') ? 'active' : ''}}" id="create-lang-{{$lang->code}}">
                                  @include('admin.sameContent')
                <div class="row">
                    <div class="{{$be->theme_version == 'logistic' ||$be->theme_version == 'amaya' || $be->theme_version == 'lawyer' ? 'col-lg-6' : 'col-lg-12'}}">

                        {{-- Image Part --}}
                        <div class="form-group">
                            <label for="">Image ** </label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview1{{$lang->id}}">
                                <img src="{{asset('assets/front/img/'.$abs[$lang->code]->intro_bg)}}" alt="Image">
                            </div>
                            <br>
                            <br>


                            <input id="fileInput1{{$lang->id}}" type="hidden" name="image_{{$lang->code}}">
                            <button id="chooseImage1{{$lang->id}}" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1{{$lang->id}}">Choose Image</button>


                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <p class="text-danger mb-0 em" id="errimage_{{$lang->code}}"></p>

                            <!-- Image LFM Modal -->
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
                    </div>
                    @if ($be->theme_version == 'logistic' ||$be->theme_version == 'amaya' || $be->theme_version == 'lawyer')
                        <div class="col-lg-6">

                            {{-- Image 2 Part --}}
                            <div class="form-group">
                                <label for="">Image 2 ** </label>
                                <br>
                                <div class="thumb-preview" id="thumbPreview10{{$lang->id}}">
                                    <img src="{{asset('assets/front/img/'.$abe[$lang->code]->intro_bg2)}}" alt="Image">
                                </div>
                                <br>
                                <br>


                                <input id="fileInput10{{$lang->id}}" type="hidden" name="image_2_{{$lang->code}}">
                                <button id="chooseImage10{{$lang->id}}" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal10{{$lang->id}}">Choose Image</button>


                                <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                                <p class="text-danger mb-0 em" id="errimage_2_{{$lang->code}}"></p>

                                <!-- Image 2 LFM Modal -->
                                <div class="modal fade lfm-modal" id="lfmModal10{{$lang->id}}" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
                                    <i class="fas fa-times-circle"></i>
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <iframe src="{{url('laravel-filemanager')}}?serial=10{{$lang->id}}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">Title **</label>
                          <input type="text" class="form-control" name="intro_section_title_{{$lang->code}}" value="{{$abs[$lang->code]->intro_section_title}}">
                          <p id="errintro_section_title_{{$lang->code}}" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">Video Link </label>
                          <input type="text" class="form-control ltr" name="intro_section_video_link_{{$lang->code}}" value="{{$abs[$lang->code]->intro_section_video_link}}">
                          <p class="text-warning mb-0">Link will be formatted automatically after submitting form.</p>
                          <p id="errintro_section_video_link_{{$lang->code}}" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Text **</label>
                            <input name="intro_section_text_{{$lang->code}}" class="form-control" value="{{$abs[$lang->code]->intro_section_text}}">
                            <p id="errintro_section_text_{{$lang->code}}" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Button Text</label>
                            <input type="text" class="form-control" name="intro_section_button_text_{{$lang->code}}" value="{{$abs[$lang->code]->intro_section_button_text}}">
                            <p id="errintro_section_button_text_{{$lang->code}}" class="em text-danger mb-0"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Button URL</label>
                            <input type="text" class="form-control ltr" name="intro_section_button_url_{{$lang->code}}" value="{{$abs[$lang->code]->intro_section_button_url}}">
                            <p id="errintro_section_button_url_{{$lang->code}}" class="em text-danger mb-0"></p>
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
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
