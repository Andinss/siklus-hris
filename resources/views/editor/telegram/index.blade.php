{!! Form::model($leave, [
    'route' => ['editor.send-telegram-message.update', $leave->id],
    'method' => 'PUT',
    'files' => 'true',
]) !!}
{{ csrf_field() }}
<button type="submit" id="btnsave" class="btn btn-success pull-right"><i class="fa fa-check"></i> Kirim</button>
{!! Form::close() !!}
