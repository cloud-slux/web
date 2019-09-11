<div>
  <data-grid fields="{{ json_encode($form->fields) }}" maps="{{json_encode($form->maps)}}"
    singular-name="{{ $form->singularName }}">
    <div slot="loading">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Lista de {{ $form->name }}</h5>
        </div>

        <ul class="list-group list-group-flush">
          <li class="list-group-item">@include('viewForm.containers.filterbox') </li>
          <li class="list-group-item">@include('viewForm.containers.toolbox')</li>
        </ul>

        <div class="card-body">
          @include('viewForm.components.table')
        </div>
        <div class="card-footer">
          ERP
        </div>
      </div>

    </div>
  </data-grid>
</div>
