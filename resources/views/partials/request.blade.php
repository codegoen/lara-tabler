<div class="card">
  <div class="card-header">
    <h3 class="card-title">Config Request</h3>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card-body">
        <div class="form-group mb-3">
          <label class="form-label required">Request Name</label>
            <input type="text" class="form-control" name="requestName" value="FooRequest">
        </div>
        <div class="form-group mb-3 ">
          <label class="form-label required">Request Authorized</label>
            <select class="form-select" name="authorized">
              <option selected value="true">true</option>
              <option value="false">false</option>
            </select>
        </div>
        <div class="form-group mb-3 ">
          <label class="form-label required">Request Rules</label>
            <input type="text" class="form-control" name="fieldRules[]" value="title#required|string|min:3">
            <input type="text" class="form-control mt-3" name="fieldRules[]" value="body#required|string|min:3|max:225">
            <input type="text" class="form-control mt-3" name="fieldRules[]" value="thumbnail#required|mimes:jpg,png">
        </div>
      </div>
    </div>
  </div>
</div>
