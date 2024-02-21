@if ($data->admin_check == null || $data->admin_check == '' || empty($data->admin_check))
    <Button class="btn btn-success btn-sm btn-process-check" data-id="{{ $data->id }}">
        <i class="fas fa-check-circle"></i> Check
    </Button>
@else
    <span class="text-success text-center"><i class="fas fa-check-circle"></i> checked</span>
@endif
