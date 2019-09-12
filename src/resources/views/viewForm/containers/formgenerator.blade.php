<form-generator url="{!! $apiUrl !!}">
  <div slot="loading">
    <div class="d-flex justify-content-center">
      <div class="spinner-border text-primary" style="width: 6rem; height: 6rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
  <div slot-scope="{ schema, formData, readOnly, mode, maps, getPickerRouteFromField, getPickerSchemaFromField, getPickerHiddenFieldsFromField, getPickerHooksFromField, getPickerPreFilterFromField, getPickerDisplayExpressionFromField }">
    <div class="md-layout md-gutter">
      <component v-for="(field, index) in schema" :key="index" :is="field.fieldType" :value="formData[field.name]"
         v-bind="field" :maps="maps" :readonly="readOnly" :mode="mode" :name="field.name"
          :picker-route="getPickerRouteFromField(field)"
          :picker-schema="getPickerSchemaFromField(field)"
          :picker-hidden-fields="getPickerHiddenFieldsFromField(field)"
          :picker-hooks="getPickerHooksFromField(field)"
          :picker-pre-filter="getPickerPreFilterFromField(field)"
          :picker-display-expression="getPickerDisplayExpressionFromField(field)"></component>
    </div>
  </div>
</form-generator>
