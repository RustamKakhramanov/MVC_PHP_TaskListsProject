<?// print_r($_GET);
$pages = $data['pages'];
//
//
//?>
<div class="text-center">
    <h1>Welcome to Task Manager!</h1>
    <div id="create-button" class="btn btn-success">Create task</div>
    <div class="task-create col-md-4 border rounded" id="task-create">
        <div id="error-tsks" class="text-danger"></div>
        <form  id="task-form">
            <div class="form-group">
                <label for="createbody">Task body</label>
                <textarea type="text" name="Task[body]"  class="form-control" id="create-body"  rows="6" required> </textarea>
            </div>
            <div class="form-group">
                <input type="email"  class="form-control" id="exampleInputEmail1"  placeholder="Enter email">
            </div>
            <div class="custom-file task-img-container">
                <input type="file" name="Task[image]" class="custom-file-input" id="task-image" accept="image/x-png,image/gif,image/jpeg" required>
                <label class="custom-file-label" for="task-image" id="label-image-file">Choose image...</label>
            </div>
            <button type="button" id="task-preview" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-md">Preview</button>
        </form>
    </div>
    <div class="col-md-12 task-table border rounded">
        <div class="task-table-header bg-light text-info border-bottom border-success">
            <div class="row">
                <div class="col-md-2 sorting-func"><a href="javascript:onclick=sorting('username')" sortname="username" sort='DESC'>Username</a></div>
                <div class="col-md-2 sorting-func"><a href="javascript:onclick=sorting('email')" sortname="email" sort ='DESC'>Email</a></div>
                <div class="col-md-3 sorting-func">Task</div>
                <div class="col-md-3 sorting-func">Image</div>
                <div class="col-md-2"><a href="javascript:onclick=sorting('status')" sortname="status" sort='DESC'>Status</a></div>
            </div>
        </div>
        <div class="tasktable-body" id="tasktable-body">
            <?=$data['tasks']?>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-md " id="modal-window" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Task preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center" id="modal-email"></div>
                    <div id="modal-task-body" class="col-7" class="text-center"></div>
                    <div id="modal-task-image" class="image-container col-5"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit"  id="asd" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div id="ct">
    <? if($pages > 1):?>
        <div class="pages" id="pages">
            <ul class="navbar-nav  links-page bg-light">
                <? for($x = 1; $x <= $pages;$x++){?>
                    <? if($_GET['page']){?>
                        <li><?= $_GET['page'] == $x? "<a class='db btn btn-success disabled' href='javascript:onclick=getPage(page=$x)' page='$x'>Page $x</a>" : "<a class='db btn btn-success' href='javascript:onclick=getPage(page=$x)' page='$x'>Page $x</a>"?>
                    <? }else{?>
                        <li class=""><?= $x == 1? "<a class='db btn btn-success disabled' href='javascript:onclick=getPage(page=$x)' page='$x'>Page $x</a>" : "<a class='db btn btn-success' href='javascript:onclick=getPage(page=$x)' page='$x'>Page $x</a>"?>
                    <? }?>
                <? }?>
            </ul>
        </div>
    <? endif;?>
</div>
