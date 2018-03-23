@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{asset('css/baguetteBox.min.css')}}">
<link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
<style>
  .bg-ticky {
    background-color: #52C27D;
    color: #fff;
  }

  .comment-meta {
    margin-bottom: 16px;
  }

  .content {
    background-color: #f5f5f5;
    font-family: "Verdana", Arial, Helvetica;
    font-size: 14px;    
  }

  .container-of-attachments {
    padding: 16px;
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
        <h1><i class="fa fa-ticket"></i> Ticket #{{ $ticket->id }}</h1>
        <p>Ver conversación del Ticket</p>
      </div>
    </div> 
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="bg-dark py-2 px-sm-4">
          <h3 class="text-white fw-400">{{ $ticket->subject }} {!! $ticket->badge !!} </h3>
        </div>
        <div class="tile">
          <div class="tile-body">
            @foreach($replies as $reply)
              <h4 class="mb-1">
                {{ $reply->user->full_name }}
                <span class="text-muted">| Respondiste</span>
              </h4>
              <div class="comment-meta">
                <span class="text-muted">{{ $reply->created_at }}</span>
              </div>
              <div class="content p-2">
                {!! $reply->content !!}
              </div>
              @isset($reply->attached_files)
                <div class="container-of-attachments bg-dark mx-md-5 my-4">
                  <h4 class="text-white border-bottom">Archivos Adjuntos:</h4>
                  <nav class="nav flex-column attached_files">
                    @foreach($reply->attached_files as $attached_file)
                      <a href="{{asset('storage/'.$attached_file->file_name)}}" class=" app-menu__item f-16" data-caption="{{ $attached_file->original_name }}">
                        <i class="fa fa-picture-o mr-1" aria-hidden="true"></i> 
                        {{ $attached_file->original_name }}
                      </a> 
                    @endforeach
                  </nav>
                </div>
              @endisset
              <hr>
              
            @endforeach
          </div>
        </div>
      </div>
    </div>   
    <!-- FORM -->
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Escriba su Respuesta</h3>
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
            <form method="POST" action="{{ route('auth.reply.store') }}" id="replyContent" novalidate>
              {{ csrf_field() }}
              <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
              <input type="hidden" id="has_attachments" name="has_attachments" value="no">
              <input type="hidden" id="attachments_list" name="attachments_list">
              <div class="form-group">
                <textarea id="textEditor" class="d-none" name="content" required></textarea>
              </div>
            </form>
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
              <i class="fa fa-fw fa-lg fa-check-circle"></i>Enviar Respuesta
            </button>
          </div>
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </div><!-- /.row -->
  </main>
  <!-- Modal -->
  <div class="modal fade" id="requiredTextArea" tabindex="-1" role="dialog" aria-labelledby="requiredTextAreaLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-ticky">
          <h6 class="modal-title" id="requiredTextAreaLabel">¡CAMPOS OBLIGATORIOS!</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4" style="background-color: #f5f5f5;">
          <ul><li class="f-16">Necesita introducir texto en el campo de comentarios.</li></ul>
          <button type="button" class="btn btn-sm bg-ticky ml-3" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
<script src="{{asset('js/baguetteBox.min.js')}}"></script>
<script src="{{asset('js/summernote-bs4.js')}}"></script>
<script src="{{asset('js/summernote-es-ES.js')}}"></script>
<script src="{{asset('js/dropzone.min.js')}}"></script>
<script src="{{asset('js/dropzone-es-ES.js')}}"></script>

<script>
baguetteBox.run('.attached_files');

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
  params: {ticket_id: "{{ $ticket->id }}"},
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

  $("#replyContent").on("submit", function(event) {

    if (this.checkValidity() === false) 
    { 
      event.preventDefault();
      event.stopPropagation();
      $('#requiredTextArea').modal();
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

  $('#textEditor').summernote({
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