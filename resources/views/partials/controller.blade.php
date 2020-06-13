<div class="card">
  <div class="card-header">
    <h3 class="card-title">Config Controller</h3>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card-body">
        <div class="form-group row mb-3">
          <div class="col-6">
            <label class="form-label required">Controller Name</label>
            <input type="text" class="form-control" name="controllerName" value="FooController">
          </div>
          <div class="col-6">
            <label class="form-label">Controller Namespace</label>
          <input type="text" class="form-control" name="controllerNamespace" value="Http\Controllers\Admin">
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-6">
            <label class="form-label required">Model Name</label>
            <input type="text" class="form-control" name="modelName" value="Foo">
          </div>
          <div class="col-6">
            <label class="form-label">Model Namespace</label>
            <input type="text" class="form-control" name="modelNamespace" value="Models\Admin">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card-body">
        <div class="form-group row mb-3">
          <div class="col-6">
            <label class="form-label required">Crud Name</label>
            <input type="text" class="form-control" name="crudName" value="foo">
          </div>
          <div class="col-6">
            <label class="form-label required">View Path</label>
            <input type="text" class="form-control" name="viewPath" value="foo">
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-6">
            <label class="form-label">Request Name</label>
            <input type="text" class="form-control" name="requestName" value="FooRequest">
          </div>
          <div class="col-6">
          <div class="form-label">DataTables</div>
          <label class="form-check form-switch cursor-pointer">
            <input class="form-check-input" name="datatables" value="true" type="checkbox">
            <span class="form-check-label">DataTables</span>
          </label>
          </div>
      </div>
    </div>
  </div>
</div>
