<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delete</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center font-weight-bold">
                <h3 class="pr-4 pl-4">
                    <i class="fa fa-question-circle-o fa-4x"></i><br>
                    Are you sure you want to continue?

                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary btn-lg btn-block" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="#" type="button" class="btnYes btn btn-primary btn-lg btn-block"><i class="fa fa-check"></i> Yes</a>
                        </div>
                    </div>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="uploadModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Upload File</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/upload/file') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body text-center font-weight-bold">
                    <input type="file" class="form-control btn" name="file" placeholder="Upload File" required accept=".csv">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>


