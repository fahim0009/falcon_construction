@extends('admin.layouts.admin')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
        <div id="addThisFormContainer">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>New property details</h3>
                            <div class="ermsg"></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="tile">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            {!! Form::open(['url' => 'admin/productid/create','id'=>'createThisForm']) !!}
                                            {!! Form::hidden('codeid','', ['id' => 'codeid']) !!}
                                            @csrf

                                            <div>
                                                <label for="title">Title</label>
                                                <input class="form-control" id="title" name="title" type="text">
                                            </div>
                                            <div>
                                                <label for="sizenumber">Category</label>
                                                <select class="form-control" name="category" id="category">
                                                    <option value="Commercial">Commercial</option>
                                                    <option value="Residential">Residential</option>
                                                    <option value="New Build">New Build</option>
                                                    <option value="Developing">Developing</option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label for="image">Image</label>
                                                <input class="form-control" id="image" name="image" type="file">
                                            </div>

                                        </div>
                    
                                        <div class="col-lg-6" id="colorForm">
                                            
                                            <div>
                                                <label for="location">Location</label>
                                                <input class="form-control" id="location" name="location" type="text">
                                            </div>

                                            <div>
                                                <label for="description"> Description</label>
                                                <textarea name="description" id="description" cols="30" rows="5"  class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tile-footer">
                                        <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                                        <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                                        {!! Form::close() !!}
                    
                                    </div>
                                </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <button id="newBtn" type="button" class="btn btn-info">Add New</button>
        <hr>

        <div id="contentContainer">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> Property Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">


                                    <table class="table table-bordered table-hover" id="example">
                                        <thead>
                                        <tr>
                                          <th>ID</th>
                                          <th>Title</th>
                                          <th>Category</th>
                                          <th>Image</th>
                                          <th>Location</th>
                                          <th>Description</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                              @foreach ($properties as $key => $data)
                                            <tr>
                                              <td>{{$key + 1}}</td>
                                              <td>{{$data->title}}</td>
                                              <td>{{$data->category}}</td>
                                              <td><img src="{{asset('images/property/'.$data->image)}}" height="80px" width="80px" alt=""></td>
                                              <td>{{$data->location}}</td>
                                              <td>{!!$data->description!!}</td>
                                              <td>
                                                <div class="toggle-flip">
                                                    <label>
                                                        <input type="checkbox" class="toggle-class" data-id="{{$data->id}}" {{ $data->status ? 'checked' : '' }}><span class="flip-indecator" data-toggle-on="Active" data-toggle-off="Inactive"></span>
                                                    </label>
                                                </div>
                                            </td>
                                              <td>
                                                <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                                                <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
                                              </td>
                                            </tr>
                                            @endforeach
                                          </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </main>
   
@endsection
@section('script')
<script>
    $(function() {
      $('.toggle-class').change(function() {
        var url = "{{URL::to('/admin/activeslider')}}";
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
           console.log(status);
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'status': status, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                                $(".ermsg").html(d.message);
                            }else if(d.status == 300){
                                $(".ermsg").html(d.message);
                                // window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error: function (d) {
                            console.log(d);
                        }
          });
      })
    })
  </script>

    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'details' );
    </script>
    <script>
        $(document).ready(function () {

            $("#addThisFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);

            });
            $("#FormCloseBtn").click(function(){
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });


            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/admin/property')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {
                    for ( instance in CKEDITOR.instances ) {
                    CKEDITOR.instances[instance].updateElement();
                    }  
                    var file_data = $('#image').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append("title", $("#title").val());
                    form_data.append("category", $("#category").val());
                    form_data.append('image', file_data);
                    form_data.append("description", $("#description").val());
                    form_data.append("location", $("#location").val());

                    var title = $("#title").val();
                    var slug = title.toLowerCase().replace(/[^\w-]+/g, '-'); 

                    console.log(slug); 

                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                              $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            success("Data Insert Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                }
                //create  end
                //Update
                if($(this).val() == 'Update'){
                // alert('update btn work');
                for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
                }  
                  var file_data = $('#image').prop('files')[0];
                  if(typeof file_data === 'undefined'){
                    file_data = 'null';
                  }
                  var form_data = new FormData();
                  form_data.append("title", $("#title").val());
                  form_data.append("category", $("#category").val());
                  form_data.append('image', file_data);
                  form_data.append("description", $("#description").val());
                  form_data.append("location", $("#location").val());

                  var title = $("#title").val();
                  var slug = title.toLowerCase().replace(/[^\w-]+/g, '-'); 
                  form_data.append('_method', 'put');

                    // console.log(image);
                    $.ajax({
                        url:url+'/'+$("#codeid").val(),
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data:form_data,
                        success: function(d){
                            console.log(d);
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                                pagetop();
                            }else if(d.status == 300){
                                success("Data Update Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error:function(d){
                            console.log(d);
                        }
                    });
                }
                //Update
            });
            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                //alert("btn work");
                codeid = $(this).attr('rid');
                //console.log($codeid);
                info_url = url + '/'+codeid+'/edit';
                //console.log($info_url);
                $.get(info_url,{},function(d){
                    populateForm(d);
                    pagetop();
                });
            });
            //Edit  end

            //Delete
            $("#contentContainer").on('click','#deleteBtn', function(){
                if(!confirm('Sure?')) return;
                 masterid = $(this).attr('rid');
                 info_url = url + '/'+masterid;
                console.log(info_url);
                //alert(info_url);
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete




            function populateForm(data){
                for ( instance in CKEDITOR.instances ) {
                    CKEDITOR.instances[instance].updateElement();
                    } 
                $("#title").val(data.title);
                $("#description").val(data.description);
                 CKEDITOR.replace( 'description' );
                $("#location").val(data.location);
                $("#category").val(data.category);
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#property").addClass('active');
        });
    </script>
   
@endsection