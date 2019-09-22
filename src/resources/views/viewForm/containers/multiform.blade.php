<div>
  <multi-form 
    fields="{{ json_encode($form->fields) }}" 
    defaults="{{ json_encode($form->defaults) }}" 
    maps="{{json_encode($form->maps)}}"
    pickers="{{json_encode($form->pickers)}}"
    visibility-triggers="{{json_encode($form->visibilityTriggers)}}"
    singular-name="{{ $form->singularName }}">
    <div slot="loading">
      <form novalidate v-on:submit.prevent class="md-layout">
        <md-card class="md-layout-item md-size-100 md-small-size-100">
          <md-card-header>
            <div class="md-title">{{ $form->singularName }}</div>
          </md-card-header>

          <md-card-content>
            @include('viewForm.containers.formgenerator')
          </md-card-content>

          <progress-bar></progress-bar>
          <form-bar></form-bar>
        </md-card>
      </form>
    </div>
  </multi-form>
</div>
