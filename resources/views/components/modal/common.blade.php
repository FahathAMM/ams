   @props([
       'titleName' => '',
       'idName' => '',
       'size' => 'modal-lg',
   ])


   <div class="modal fade zoomIn" id="{{ $idName }}" tabindex="-1" aria-labelledby="{{ $idName }}Label"
       aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered {{ $size }}">
           <div class="modal-content border-0">
               <div class="modal-header p-3 bg-info-subtle">
                   <h5 class="modal-title" id="{{ $idName }}Label">{{ $titleName }}</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal">
                   </button>
               </div>
               {{ $slot }}
           </div>
       </div>
   </div>
