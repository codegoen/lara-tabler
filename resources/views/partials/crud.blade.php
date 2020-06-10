<div class="card">
  <div class="card-header">
    <h3 class="card-title">Config Model</h3>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card-body">
        <div class="form-group mb-3">
          <label class="form-label required">Model Name</label>
            <input type="text" class="form-control" name="modelName" value="Foo">
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
        <div class="form-group mb-3 ">
          <label class="form-label">Primary Key</label>
            <input type="text" class="form-control" name="primaryKey" value="uuid">
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Add Relation</label>
            <input type="text" class="form-control" name="relations" value="bars#hasMany#App\Bar|id|bar_id">
        </div>
      </div>
    </div>
  </div>
</div>
