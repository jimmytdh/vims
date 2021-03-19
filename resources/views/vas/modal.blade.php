<div class="modal" tabindex="-1" role="dialog" id="vaccinationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Vaccination</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="vaccinationContent">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Please Wait...
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="healthModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Health Condition</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="healthContent">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Please Wait...
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="calendarModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Health Condition</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/list/vas/date') }}" method="post" id="calendarForm">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label>Change Date</label>
                    <input type="date" name="vaccination_date" class="form-control" value="{{ $date }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-calendar"></i> Change Date
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="nextVisitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Set Schedule</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/vas/schedule') }}" id="nextVisitForm">
                <input type="hidden" name="vac_id" id="vac_id">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="date" id="nextDate" class="form-control" name="nextDate">
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

<div class="modal" tabindex="-1" role="dialog" id="statusModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Select Status</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/list/vas/status') }}" id="statusForm">
                <input type="hidden" name="id" id="status_id">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="status" id="status" class="custom-select">
                            <option value="">None</option>
                            <option>Previous deferral</option>
                            <option>Previous refusal</option>
                            <option>AEFI reported</option>
                            <option>Serious AEFI</option>
                            <option>Death related to AEFI</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-lg btn-block">
                        <i class="fa fa-save"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="uploadModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Upload QSL</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/vas/upload') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="status_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vaccination Date:</label>
                        <input type="date" name="vaccination_date" class="form-control" value="{{ $date }}">
                    </div>
                    <div class="form-group">
                        <label>Facility:</label>
                        <select name="facility" class="custom-select" required>
                            <option value="">Select...</option>
                            <option>Cebu South Medical Center</option>
                            <option>Vicente Sotto Memorial Medical Center</option>
                            <option>LGU - Talisay City</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>CSV File</label>
                        <input type="file" name="file" required class="form-control btn" accept=".csv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-lg btn-block">
                        <i class="fa fa-check-circle"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
