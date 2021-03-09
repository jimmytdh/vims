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

<div class="modal" tabindex="-1" role="dialog" id="uploadCompareModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Upload File</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/upload/compare') }}" method="post" enctype="multipart/form-data">
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

<div class="modal" tabindex="-1" role="dialog" id="vaccineModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Vaccination Status</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="count_ids alert alert-warning"></div>
            <div class="modal-body load_content">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Please Wait...
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="listModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Group Listing</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/vaccine/list') }}" id="groupListForm">
                <div class="count_ids alert alert-warning"></div>
                <input type="hidden" name="emp_id" id="schedule_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select List:</label>
                        <select name="list" class="custom-select">
                            <option>Empty</option>
                            <option>QSL 1</option>
                            <option>QSL 2</option>
                            <option>QSL 3</option>
                            <option>Wait List</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-lg btn-block">
                        <i class="fa fa-calendar"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="scheduleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Set Schedule</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/vaccine/schedule') }}" id="scheduleForm">
                <div class="count_ids alert alert-warning"></div>
                <input type="hidden" name="emp_id" id="schedule_id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Select Date:</label>
                    <input type="date" class="form-control" name="date">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-lg btn-block">
                    <i class="fa fa-calendar"></i> Submit
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

