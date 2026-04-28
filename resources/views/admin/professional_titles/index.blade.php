@extends('layouts.admin')
@section('title', 'Admin – Professional Titles')

@push('styles')
<style>
@keyframes floatIn { 0% { opacity:0; transform:translateY(16px); } 100% { opacity:1; transform:translateY(0); } }
.pt-panel { max-width: 1000px; animation: floatIn 0.45s cubic-bezier(0.16,1,0.3,1) both; }
</style>
@endpush

@section('content')
<main class="dash">
<div class="adm-page">
<div class="adm-card pt-panel">

  {{-- Header --}}
  <div class="adm-card-header">
    <h1>Professional Titles</h1>
    <button class="btn-header" onclick="openCreateModal()">
      <i data-lucide="plus" style="width:16px;height:16px;"></i> Add New Title
    </button>
  </div>

  {{-- Alerts --}}
  @if(session('success'))
    <div style="padding: 16px 28px 0;">
      <div class="adm-alert adm-alert-ok">
        <i data-lucide="check-circle" style="width:16px;flex-shrink:0;"></i> {{ session('success') }}
      </div>
    </div>
  @endif
  @if($errors->any())
    <div style="padding: 16px 28px 0;">
      <div class="adm-alert adm-alert-err">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
      </div>
    </div>
  @endif

  {{-- Table --}}
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Title Name</th>
          <th>Created On</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($titles as $title)
          <tr>
            <td><span class="title-chip">{{ $title->name }}</span></td>
            <td style="color: var(--adm-muted);">{{ $title->created_at->format('M d, Y') }}</td>
            <td>
              <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" class="btn-act btn-act-edit"
                        onclick="openEditModal({{ $title->id }}, '{{ addslashes($title->name) }}')">
                  <i data-lucide="edit-2" style="width:13px;"></i> Edit
                </button>
                <form action="{{ route('admin.professional-titles.destroy', $title->id) }}" method="POST"
                      onsubmit="return confirm('Delete this title?');" style="margin:0;">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-act btn-act-del">
                    <i data-lucide="trash-2" style="width:13px;"></i> Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="adm-empty">No professional titles added yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
</div>
</main>

{{-- Create Modal --}}
<div class="adm-backdrop" id="createModal">
  <div class="adm-modal">
    <div class="adm-modal-head">
      <h2>Add Professional Title</h2>
      <button class="adm-modal-close" onclick="closeCreateModal()"><i data-lucide="x"></i></button>
    </div>
    <div class="adm-modal-body">
      <form action="{{ route('admin.professional-titles.store') }}" method="POST">
        @csrf
        <div class="adm-form-group">
          <label for="name">Title Name</label>
          <input type="text" name="name" id="name" class="adm-form-control"
                 required placeholder="e.g. Clinical Psychologist">
        </div>
        <div class="adm-modal-actions">
          <button type="button" class="btn-adm-cancel" onclick="closeCreateModal()">Cancel</button>
          <button type="submit" class="btn-adm-save">
            <i data-lucide="plus" style="width:14px;"></i> Add Title
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit Modal --}}
<div class="adm-backdrop" id="editModal">
  <div class="adm-modal">
    <div class="adm-modal-head">
      <h2>Edit Professional Title</h2>
      <button class="adm-modal-close" onclick="closeEditModal()"><i data-lucide="x"></i></button>
    </div>
    <div class="adm-modal-body">
      <form id="editForm" method="POST">
        @csrf @method('PUT')
        <div class="adm-form-group">
          <label for="editNameInput">Title Name</label>
          <input type="text" name="name" id="editNameInput" class="adm-form-control" required>
        </div>
        <div class="adm-modal-actions">
          <button type="button" class="btn-adm-cancel" onclick="closeEditModal()">Cancel</button>
          <button type="submit" class="btn-adm-save">
            <i data-lucide="save" style="width:14px;"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
function openCreateModal()  { document.getElementById('createModal').classList.add('open'); }
function closeCreateModal() { document.getElementById('createModal').classList.remove('open'); }
function openEditModal(id, name) {
  document.getElementById('editForm').action = `/admin/professional-titles/${id}`;
  document.getElementById('editNameInput').value = name;
  document.getElementById('editModal').classList.add('open');
}
function closeEditModal() { document.getElementById('editModal').classList.remove('open'); }
</script>
@endsection
