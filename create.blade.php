<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong><i class="fa fa-plus"></i>新增職等</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>

    </div>
    <div class="modal-body">

        <!-- BEGIN FORM-->

        {!! Form::open(array('route'=>"member.grades.store",'class'=>'form-horizontal ','method'=>'POST', 'id' => 'add_grade_form')) !!}
        <div class="form-group">
            <div class="mb-3">
                <label for="recipient-name" class="form-label">職等:</label>
                <input class="form-control form-control-inline " name="grade" type="text" value="" placeholder="職等"/>
            </div>
        </div>
        <div class="form-group">
            <div class="mb-3">
                <label for="recipient-name" class="form-label">職等名稱:</label>
                <div class="designation-container">
                    <input class="form-control form-control-inline designation" name="designation[0]" id="try" type="text" value="" placeholder="職等名稱 #1" data-autocomplete-url="{{ route('member.grades.designation') }}" />
                    <div class="autocomplete-container"></div>
                </div>
            </div>
        </div>
        <div id="insertBefore"></div>
        <div class="form-group">
            <div class="mb-3">
                <button type="button" id="plusButton" onclick="addMore(false);return false;" class="btn btn-sm btn-success form-control-inline">
                    新增職等其他名稱 <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="mb-3">
                <label for="competencySelect1" class="form-label">職務別</label>
                <select class="form-select" id="competencySelect1" name="competency">
                    <option selected disabled>選擇一個職務</option>
                    @foreach($competencies as $competency)
                        <option value="{{ $competency->id }}">{{ $competency->competency }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {!!  Form::close()  !!}
        <!-- END FORM-->
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <button type="button" class="btn btn-primary" onclick="storeGrades();return false;" ><i class="fa fa-check"></i> 新增</button>
        </div>

    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>






