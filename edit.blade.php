<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title"><strong><i class="fa fa-edit"></i>編輯職等</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
    </div>
    <div class="modal-body">
        <!-- BEGIN FORM-->

        {!!  Form::open(['method' => 'PUT','class'=>'form-horizontal','id'=>'edit_grade_form'])  !!}
        <div class="form-group">
            <div class="mb-3">
            <label for="edit_grade" class="form-label">職等名稱:</label>
            <input class="form-control form-control-inline" name="grade" id="edit_grade" type="text" value="{{$grade->grade}}" placeholder="Grade" data-autocomplete-url="{{ route('member.grades.designation') }}" />
            <div class="autocomplete-container"></div>
            </div>
        </div>
        <div id="deptresponse"></div>
        <div class="form-group">
                <div class="mb-3">
        <label for="recipient-name" class="form-label">{{trans('core.designations')}}:</label>
        </div>
        @foreach($grade->designations  as $index=>$designation)

        <div class="form-group">
            <div class="mb-3">
                <input class="form-control form-control-inline designation" name="designation[{{$index}}]" value="{{$designation->designation}}" type="text" value="" placeholder="{{trans('core.designation')}} #{{$index +1}}"/>
                <input type="hidden" name="designationID[{{ $index }}]" value="{{ $designation->id }}">
            </div>
        </div>
        @endforeach
        <div id="insertBefore_edit"></div>
        <div class="form-group">
            <div class="mb-3">
                <button type="button" id="plusButton" onclick="addMore(true);return false;" class="btn btn-sm btn-success form-control-inline">
                    {{trans('core.addMoreDesignation')}} <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="mb-3">
                <label for="competencySelect1" class="form-label">管理階級</label>
                <select class="form-select" id="competencySelect1" name="competency">
                    @foreach($competencies as $competency)
                        <option value="{{ $competency->id }}" @if($grade->competencyID == $competency->id) selected @endif>{{ $competency->competency }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="UpdateGrades({{$grade->id}});return false;"   class="btn btn-primary"><i class="fa fa-edit"></i> Update</button>
        {!!  Form::close()  !!}
        <!-- END FORM-->
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>

