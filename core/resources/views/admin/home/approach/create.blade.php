<div class="modal fade" id="createPointModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <form id="ajaxForm" class="modal-form" action="{{route('admin.approach.point.store')}}" method="POST">
           <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add Point</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>
           <div class="modal-body">
              <div class="row">
                 <div class="col-lg-12">
                    @csrf
                     @if (!empty($langs))
                         <ul class="nav nav-tabs">
                             @foreach ($langs as $lang)
                                 <li class="nav-item">
                                     <a class="nav-link {{$lang->code == request()->input('language') ? 'active' : ''}}" data-toggle="tab" href="#create-lang-{{$lang->code}}">{{$lang->name}}</a>
                                 </li>
                             @endforeach
                         </ul>
                     @endif
                     <div class="tab-content">
                         @foreach ($langs as $lang)
                             <div class="tab-pane container {{$lang->code == request()->input('language') ? 'active' : ''}}" id="create-lang-{{$lang->code}}">
                    <div class="form-group">
                       <label for="">Icon **</label>
                       <div class="btn-group d-block">
                          <button type="button" class="btn btn-primary iconpicker-component"><i
                             class="fa fa-fw fa-heart"></i></button>
                          <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                             data-selected="fa-car" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu"></div>
                       </div>
                       <input id="inputIcon{{$lang->code}}" type="hidden" name="icon_{{$lang->code}}" value="fas fa-heart">
                       <div class="mt-2">
                          <small>NB: click on the dropdown sign to select an icon.</small>
                       </div>
                    </div>

                    @if ($be->theme_version == 'cleaning')
                        <div class="form-group">
                            <label for="">Color **</label>
                            <input type="text" class="form-control jscolor" name="color" value="39498a">
                            <p id="errcolor" class="mb-0 text-danger em"></p>
                        </div>
                    @endif

                    <div class="form-group">
                       <label for="">Title **</label>
                       <input type="text" class="form-control" name="title_{{$lang->code}}" value="" placeholder="Enter Title">
                       <p id="errtitle_{{$lang->code}}" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                       <label for="">Short Text **</label>
                       <input type="text" class="form-control" name="short_text_{{$lang->code}}" value="" placeholder="Enter Short Text">
                       <p id="errshort_text_{{$lang->code}}" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                      <label for="">Serial Number **</label>
                      <input type="number" class="form-control ltr" name="serial_number_{{$lang->code}}" value="" placeholder="Enter Serial Number">
                      <p id="errserial_number_{{$lang->code}}" class="mb-0 text-danger em"></p>
                      <p class="text-warning"><small>The higher the serial number is, the later the point will be shown in approach section.</small></p>
                    </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="submitBtn" type="submit" class="btn btn-success">Submit</button>
           </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Point</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="updateBtn" type="submit" class="btn btn-success">Update</button>
                </div>
        </div>
    </div>
</div>

