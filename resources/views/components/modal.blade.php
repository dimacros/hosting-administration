  @php
    $default = [ 
      'modalId' => null, 
      'modalTitle' => 'Sin título',
      'btnCloseClass' => 'btn btn-secondary', 
      'btnCloseTitle' => 'Cerrar', 
      'btnSaveClass' => 'btn btn-primary',
      'btnSaveFormId' => null, 
      'btnSaveTitle' => 'Guardar cambios'
    ];
  @endphp
  <!-- Modal -->
  <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}-Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $modalId }}-Label">{{ $modalTitle??'Sin título' }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ $slot }}
        </div>
        <div class="modal-footer">
          <button type="button" class="{{ $btnCloseClass??'btn btn-secondary' }}" data-dismiss="modal">
            {{ $btnCloseTitle??'Cerrar' }}
          </button>
          <button type="submit" class="{{ $btnSaveClass??'btn btn-primary' }}" form="{{ $FormId }}">
            {{ $btnSaveTitle??'Guardar cambios' }}
          </button>
        </div>
      </div>
    </div>
  </div><!-- /. modal -->