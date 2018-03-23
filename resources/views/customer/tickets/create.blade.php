@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{asset('css/baguetteBox.min.css')}}">
<link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
<style>
  #formHeader {
    position: relative;
    margin: 0;
    padding: 18px 13px 17px 18px;
    background: #fafafa;
    -moz-border-radius: 3px 3px 0 0;
    -webkit-border-radius: 3px 3px 0 0;
    border-radius: 3px 3px 0 0;
    border-bottom: 1px solid #e5e5e5;
    text-transform: uppercase;
    font-weight: 550;
    letter-spacing: 1px;
    font-size: 13px;
    line-height: 1;
  }
  .bg-ticky {
    background-color: #52C27D;
    color: #fff;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .note-editable {
    font-family: "Verdana", Arial, Helvetica !important;
    font-size: 14px !important;
  }

  .dropzone {
    border: 2px dashed #0087F7;
    border-radius: 5px;
  }
  
  .dz-error * {
    cursor: not-allowed !important;
  }
</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-ticket"></i> Ticket </h1>
        <p>Ver conversación del Ticket</p>
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
            <a href="{{ url('dashboard/tickets/mis-tickets') }}" class="btn btn-primary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
          </div>
        </div>
      </div>
    </div>   
    <!-- FORM -->
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <h6 id="formHeader">Enviar Ticket</h6>
        <div class="tile">
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
          <div class="tile-body py-3 px-4 f-16">
            <form method="POST" action="{{ route('customer.tickets.store') }}" id="replyContent" novalidate>
              {{ csrf_field() }}
              <input type="hidden" id="has_attachments" name="has_attachments" value="no">
              <input type="hidden" id="attachments_list" name="attachments_list">
              <div class="form-group">
                <h5 class="text-primary">Temas de Ayuda</h5>
                <select class="custom-select" id="help_topic_id" name="help_topic_id" required>
                  <option value="" selected disabled>Seleccione un tema..</option>
                  @foreach($helpTopics as $helpTopic)
                    <option value="{{$helpTopic->id}}">{{$helpTopic->title}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <h5 class="text-primary">Asunto del Ticket</h5>
                <input type="text" id="subject" name="subject" class="form-control" placeholder="En general, ¿de qué se trata este ticket?" required>
              </div>
              <div class="form-group">
                <h5 class="text-primary">Deja tu Mensaje</h5>
                <textarea id="content" name="content"  class="d-none" required></textarea>
                <small class="form-text text-muted">
                  Por favor se descriptivo y no descartes ningun detalle...
                </small>
              </div>
            </form>
            <h5 class="text-primary">Adjuntar archivos</h5>
            <div class="dropzone" id="myDropzone">
              <div class="fallback">
                <input type="file" name="attached_files" multiple>
              </div>
              <div class="dz-default dz-message">
                <span class="h4 text-secondary">Arrastra los archivos aquí o haz clic para subirlos.</span>
              </div>
            </div>
          </div><!-- /.tile-body -->
          <div class="tile-footer">
            <button type="submit" id="btnSubmit" form="replyContent" class="btn btn-primary btn-lg">
              <i class="fa fa-fw fa-lg fa-check-circle"></i>Enviar un Ticket
            </button>
          </div>
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </div><!-- /.row -->
  </main>
  <!-- Modal -->
  <div class="modal fade" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="modalWarningLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-ticky">
          <h6 class="modal-title" id="modalWarningLabel">¡CAMPOS OBLIGATORIOS!</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4" style="background-color: #f5f5f5;">
          <ul id="listErrors">

          </ul>
          <button type="button" class="btn btn-sm bg-ticky ml-3" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
<script src="{{asset('js/summernote-bs4.js')}}"></script>
<script src="{{asset('js/summernote-es-ES.js')}}"></script>
<script src="{{asset('js/dropzone.min.js')}}"></script>
<script src="{{asset('js/dropzone-es-ES.js')}}"></script>

<script>

Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("#myDropzone", { 
  url: "{{ route('auth.reply.storeFiles') }}",
  method: "POST",
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  addRemoveLinks: true,
  autoProcessQueue: false,
  clickable: true,
  maxFilesize: 1,
  maxFiles: 6,
  parallelUploads: 6,
  paramName: "attached_files",
  uploadMultiple: true
});

myDropzone.on("addedfile", function(file) {
  document.getElementById('has_attachments').value = "yes";
});

myDropzone.on("error", function(file, errorMessage, xhr) {
  document.getElementById('btnSubmit').disabled = true; 
  file.previewElement.addEventListener("click", function() {
    myDropzone.removeFile(file);
    if (myDropzone.getRejectedFiles().length === 0) {
      document.getElementById('btnSubmit').disabled = false; 
    }
  });
  console.log(errorMessage);
});

myDropzone.on("reset", function() {
  document.getElementById('has_attachments').value = "no";
});

myDropzone.on("processingmultiple", function(files) {
  document.getElementById('btnSubmit').disabled = true; 
});

myDropzone.on("successmultiple", function(files, response) { 
  document.getElementById('has_attachments').value = "no";
  document.getElementById("attachments_list").value = "[" + response.attachments_list + "]";
  document.getElementById("replyContent").submit();
});

$(document).ready(function() {

  $('#modalWarning').on('hidden.bs.modal', function (e) {
    $('#listErrors').empty();
  });

  $("#replyContent").on("submit", function(event) {

    if (this.checkValidity() === false) 
    { 
      event.preventDefault();
      event.stopPropagation();
      if (!document.getElementById('help_topic_id').validity.valid) {
        $('#listErrors').append('<li class="f-16">Necesita elegir una categoría para este ticket.</li>');
      }
      if (!document.getElementById('subject').validity.valid) {
        $('#listErrors').append('<li class="f-16">Necesita introducir un tema para este ticket.</li>');     
      }
      if (!document.getElementById('content').validity.valid) {
        $('#listErrors').append('<li class="f-16">Necesita introducir texto en el campo de comentarios.</li>'); 
      }
      $('#modalWarning').modal();
    }
    else 
    { 
      if (document.getElementById('has_attachments').value === "yes") {
        event.preventDefault();
        event.stopPropagation();
        myDropzone.processQueue();
      }
    }

  });

  $('#content').summernote({
    //height: 300,                 
    fontName: 'Helvetica',
    lang: 'es-ES',
    minHeight: 200,             
    maxHeight: 300,             
    focus: true,   
      
  });

  var checkBox = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="openInNewWindow"><label class="custom-control-label" for="openInNewWindow">Abrir en una nueva ventana</label></div>';
  
  $('#sn-checkbox-open-in-new-window').parent().replaceWith(checkBox);

});

</script>
@endpush