@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
<style>
  .note-editable {
    font-family: "Verdana", Arial, Helvetica !important;
    font-size: 16px !important;
  }
  .dropzone {
    border: 2px dashed #0087F7;
    border-radius: 5px;
  }
</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Cliente</h1>
        <p>Registrar Cliente</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
      </ul>
    </div>   
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <div class="tile-body">
            <a href="{{ url('dashboard/clientes') }}" class="btn btn-primary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
          </div>
        </div>
      </div>
    </div>  
    <!-- FORM -->
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Registrar Cliente</h3>
          <hr>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <strong>{{ session('status') }}</strong>
            </div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
           @endif
          <form method="POST" id="replyContent" action="{{ route('admin.respuesta.store') }}" enctype="multipart/form-data">
            <div class="tile-body">
              <div class="form-group">
                <label for="textEditor">Teléfono o Celular:</label>
                <textarea id="textEditor" name="content_of_the_reply"></textarea>
              </div>
              <div class="dropzone" id="myDropzone">
                <div class="fallback">
                  <input name="file" type="file" multiple>
                </div>
                <div class="dz-default dz-message">
                  <span class="h4 text-secondary">Suelta los archivos aquí o haz clic para cargarlos.</span>
                </div>
              </div>
            </div><!-- /.tile-body -->
            <div class="tile-footer">
              <button type="submit" class="btn btn-primary btn-lg" id="submit">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar
              </button>
            </div>
          </form>
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </div><!-- /.row -->
  </main>
@endsection
@push('script')
<script src="{{asset('js/summernote-bs4.js')}}"></script>
<script src="{{asset('js/summernote-es-ES.js')}}"></script>
<script src="{{asset('js/dropzone.min.js')}}"></script>
<script>
  var checkBoxBs4 = '';
  checkBoxBs4 += '<div class="custom-control custom-checkbox">';
  checkBoxBs4 +=   '<input type="checkbox" class="custom-control-input" id="openInNewWindow">';
  checkBoxBs4 +=   '<label class="custom-control-label" for="openInNewWindow">';
  checkBoxBs4 +=     'Abrir en una nueva ventana';
  checkBoxBs4 +=   '</label>';
  checkBoxBs4 += '</div>';

Dropzone.autoDiscover = false;

$(document).ready(function() {
  $('#textEditor').summernote({
    //height: 300,                 
    fontName: 'Helvetica',
    lang: 'es-ES',
    minHeight: 200,             
    maxHeight: 300,             
    focus: true,   
      
  });

  $('#sn-checkbox-open-in-new-window').parent().replaceWith(checkBoxBs4);

});

var myDropzone = new Dropzone("#myDropzone", { 
  url: "{{ route('admin.respuesta.store') }}",
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  addRemoveLinks: true,
  autoProcessQueue: false,
  maxFilesize: 2,
  maxFiles: 8,
  parallelUploads: 8,
  paramName: "files",
  uploadMultiple: true,
});

var submitBtn = document.querySelector("#submit");
submitBtn.addEventListener("click", function(e){
  e.preventDefault();
  e.stopPropagation();
  myDropzone.processQueue();
});

myDropzone.on("addedfile", function(file) {
    alert("file uploaded");
});

myDropzone.on("sending", function(file, xhr, formData) {
  // Will send the filesize along with the file as POST data.
  formData.append("content_of_the_reply", jQuery('#textEditor').val());
});
   
myDropzone.on("successmultiple", function(file, response) {
  console.log(response);
});

myDropzone.on("complete", function(file) {
  myDropzone.removeAllFiles(true);
});

/*
Dropzone.options.myDropzone = 
{
  url: "{{ route('admin.respuesta.store') }}",
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  autoProcessQueue: false,
  uploadMultiple: true,
  maxFilesize: 10,
  maxFiles: 6,
            
  init: function() {
      var submitBtn = document.querySelector("#submit");
      myDropzone = this;
                  
      submitBtn.addEventListener("click", function(e){
          e.preventDefault();
          e.stopPropagation();
          myDropzone.processQueue();
          console.log(myDropzone);
      });

      this.on("addedfile", function(file) {
          alert("file uploaded");
      });

      this.on("sending", function(file, xhr, formData) {
        // Will send the filesize along with the file as POST data.
        formData.append("_token", file.size);
        formData.append("content_of_the_reply", file.size);
      });

      this.on("complete", function(file) {
          myDropzone.removeFile(file);
      });
   
      this.on("success", myDropzone.processQueue.bind(myDropzone) );
  }
};
*/
</script>
@endpush