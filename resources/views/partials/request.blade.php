<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Config Request</h3>
    </div>
    <div class="card-body">
      <div class="form-group mb-3 ">
        <label class="form-label">Request Namespace</label>
          <input type="text" class="form-control" name="request-namespace">
      </div>
      <div class="form-group mb-3 ">
        <label class="form-label required">Request Name</label>
          <input type="text" class="form-control" name="request" value="FooRequest">
      </div>
      <div class="form-group mb-3 ">
        <label class="form-label required">Authorize</label>
        <select class="form-select" name="authorize">
          <option selected value="true">true</option>
          <option value="false">false</option>
        </select>
      </div>
    </div>
  </div>
</div>
