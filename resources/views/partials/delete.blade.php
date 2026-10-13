<form action="{{ $action }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $message ?? 'Delete this record?' }}');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
</form>
