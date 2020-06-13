<div class="card">
  <div class="card-header">
    <h3 class="card-title">Config Model</h3>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card-body">
        <div class="form-group mb-3">
          <label class="form-label required">Model Name</label>
            <input type="text" class="form-control" name="modelName" value="Foo">
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Model Namespace</label>
            <input type="text" class="form-control" name="modelNamespace" value="Models\Admin">
        </div>
        <div class="form-group mb-3 ">
          <label class="form-label required">Soft Deletes</label>
          <select class="form-select" name="softDeletes">
            <option selected value="true">true</option>
            <option value="false">false</option>
          </select>
        </div>
        <div class="form-group mb-3 ">
          <label class="form-label">Table Name</label>
            <input type="text" class="form-control" name="tableName" value="foos">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card-body">
        <div class="form-group mb-3 ">
          <label class="form-label">Primary Key</label>
            <input type="text" class="form-control" name="primaryKey" value="uuid">
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Accessor</label>
            <input type="text" class="form-control" name="accessor" value="getThumbnailAttribute">
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Mutator</label>
            <input type="text" class="form-control" name="mutator" value="setFirstNameAttribute">
        </div>
        <div class="form-group mb-3 field-container">
          <label class="form-label">Relationships</label>
          <div class="input-group mb-2">
            <input type="text" class="form-control" name="relations[]" value="bars#hasMany#App\Bar|id|bar_id">
            <span class="btn-clone bg-cyan text-white input-group-text cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="12" cy="12" r="9"></circle><line x1="9" y1="12" x2="15" y2="12"></line><line x1="12" y1="9" x2="12" y2="15"></line></svg>
            </span>
          </div>
        </div>
        <div class="clone" style="display: none;">
          <div class="input-group mb-2">
            <input type="text" class="form-control" name="relations[]">
            <span class="btn-remove bg-red text-white input-group-text cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="12" cy="12" r="9"></circle><path d="M10 10l4 4m0 -4l-4 4"></path></svg>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script lang="javascript">
    $(document).ready(function() {
      $('body').on('click', '.btn-clone', function() {
        $('.field-container').after($('.clone').html());
      });
      
      $('body').on('click', '.btn-remove', function() {
        $(this).parent().remove();
      });
    });
  </script>
@endpush
