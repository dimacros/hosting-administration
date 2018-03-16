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
          <div class="tile-body">
            <form method="POST" id="replyContent" novalidate>
              {{ csrf_field() }}
              <div class="form-group">
                <label for="textEditor">Teléfono o Celular:</label>
                <textarea id="textEditor" name="content_of_the_reply" required></textarea>
              </div>
            </form>
              <div class="dropzone dz-clickable" id="myDropzone">
                <div class="fallback">
                  <input name="file" type="file" multiple>
                </div>
                <div class="dz-default dz-message">
                  <span class="h4 text-secondary">Suelta los archivos aquí o haz clic para cargarlos.</span>
                </div>
              </div>
          </div><!-- /.tile-body -->
          <div class="tile-footer">
            <button type="submit" form="replyContent" class="btn btn-primary btn-lg">
              <i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar
            </button>
          </div>
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
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("#myDropzone", { 
  url: "{{ route('admin.respuesta.store') }}/",
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  addRemoveLinks: true,
  autoProcessQueue: false,
  maxFilesize: 2,
  maxFiles: 8,
  parallelUploads: 8,
  paramName: "files",
  params: { _method:'PUT', reply_id: '', },
  uploadMultiple: true,
});

var checkBoxBs4 = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="openInNewWindow"><label class="custom-control-label" for="openInNewWindow">Abrir en una nueva ventana</label></div>';

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

  $("#replyContent").on("submit", function(event) {
    event.preventDefault();
    event.stopPropagation();
    if (this.checkValidity() === false) 
    { 
      console.log('El campo textEditor está vació'); 
    }
    else 
    {
      $.ajax({
        type: "POST",
        url: "{{ route('admin.respuesta.store') }}",
        dataType: "json",
        data: $(this).serialize(),
          success: function(response) { 
            if(response.success){
              //myDropzone.reply_id = response.reply_id;
              //myDropzone.options.params.reply_id = response.reply_id;
              myDropzone.options.url += response.reply_id;
              myDropzone.processQueue();
              //{{ route('admin.clientes.update', response.reply_id) }}
            } 
          },
          error: function(xhr, status, error) {
            console.log(xhr); 
          }
      });
    }
  });

});

myDropzone.on("addedfile", function(file) {
    //alert("file uploaded");
});

myDropzone.on("sendingmultiple", function(file, xhr, formData) {
  // Will send the filesize along with the file as POST data.
  //formData.append("reply_id", myDropzone.reply_id);
});
   
myDropzone.on("success", function(file, response) {
  console.log(response.paths);
});

myDropzone.on("complete", function(file) {
  myDropzone.removeAllFiles(true);
});
</script>
@endpush