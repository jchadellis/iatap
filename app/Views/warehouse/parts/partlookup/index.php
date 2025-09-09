<form action="" id="part-search-form">
    <div class="row mx-auto">
        <div class="col-2">
            <div class="form-floating">
                <input type="text" name="id" id="id" class="form-control" placeholder="">
                <label for="id">Part ID</label>
            </div>
        </div>
        <div class="col-3">
            <div class="form-floating">
                <input type="text" name="description" id="description" class="form-control" placeholder="">
                <label for="id">Description</label>
            </div>
        </div>
        <div class="col-2">
            <div class="form-floating">
                <select name="user_def" id="user_define" class="form-select" placeholder="">
                    <option value="ALL">All User Defs</option>
                    <option value="user_1">User Define 1</option>
                    <option value="user_2">User Define 2</option>
                    <option value="user_3">User Define 3</option>
                    <option value="user_4">User Define 4</option>
                    <option value="user_5">User Define 5</option>
                    <option value="user_6">User Define 6</option>
                    <option value="user_7">User Define 7</option>
                    <option value="user_8">User Define 8</option>
                    <option value="user_9">User Define 9</option>
                    <option value="user_10">User Define 10</option>
                </select>
                <label for="">User Define</label>
            </div>
        </div>
        <div class="col-2">
            <div class="form-floating">
                <input type="text" name="user_define_text" id="user_define_text" class="form-control" placeholder="">
                <label for="id">User Define</label>
            </div>
        </div>
        <div class="col-2">
            <div class="d-flex justify-content-center align-items-center h-100">
                <input 
                    type="checkbox" 
                    name="operator" 
                    id="operator" 
                    class="form-control" 
                    placeholder="" 
                    value="OR"
                    data-toggle="toggle"
                    data-on = "OR - Operator"
                    data-off = 'AND - Operator'
                    checked 
                >
            </div>
        </div>
        <div class="col-1">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="d-grid">
                    <button type="button" class="btn btn-primary" id="search-btn"><i class="bi bi-search"></i>&nbsp;Search</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row mt-2">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <strong>Tip:</strong> Use wildcards in your search: <code>%</code> matches many characters, 
            <code>_</code> matches one character.<br>
            Example: <code>123%</code> finds 123, 123-00033, 123-00067, etc.<br>
            Example: <code>123_</code> finds 1231, 1238, etc.
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-striped table-bordered">
        
        </table>
    </div>
</div>

<div class="modal" id="content-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

        </div>
    </div>
</div>