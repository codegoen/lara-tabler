<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Config Controller</h3>
    </div>
    <div class="card-body">
      <div class="form-group mb-3 ">
        <label class="form-label">Controller Namespace</label>
          <input type="text" class="form-control" name="controller-namespace">
          @error('controller-namespace')
              {{$message}}
          @enderror
      </div>
      <div class="form-group mb-3 ">
        <label class="form-label required">Controller Name</label>
          <input type="text" class="form-control" name="controller-name">
      </div>
      <div class="form-group mb-3 ">
        <label class="form-label required">View Path / View Name</label>
          <input type="text" class="form-control" name="view-path-name">
      </div>
    </div>
  </div>
</div>
