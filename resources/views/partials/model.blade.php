<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Config Model</h3>
    </div>
    <div class="card-body">
      <div class="form-group mb-3 ">
        <label class="form-label">Model Namespace</label>
          <input type="text" class="form-control" name="model-namespace">
          @error('model-namespace')
              {{$message}}
          @enderror
      </div>
      <div class="form-group mb-3 ">
        <label class="form-label required">Model Name</label>
          <input type="text" class="form-control" name="model-name">
          @error('model')
              {{$message}}
          @enderror
      </div>
      <div class="form-group mb-3 ">
        <label class="form-label required">Soft Deletes</label>
        <select class="form-select" name="soft-deletes">
          <option selected value="true">true</option>
          <option value="false">false</option>
        </select>
      </div>
    </div>
  </div>
</div>
